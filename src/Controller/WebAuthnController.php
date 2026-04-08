<?php

namespace App\Controller;

use App\Entity\WebAuthnCredential;
use App\Service\SecurityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebAuthnController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SecurityLogger $securityLogger,
        private \App\Service\WebAuthnService $webauthnService
    ) {}

    #[Route('/webauthn/credentials', name: 'webauthn_list')]
    public function listCredentials(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $repo = $this->em->getRepository(WebAuthnCredential::class);
        $creds = $repo->findBy(['user' => $user]);

        return $this->render('profile/webauthn.html.twig', [
            'credentials' => $creds
        ]);
    }

    #[Route('/webauthn/register/start', name: 'webauthn_register_start', methods: ['POST'])]
    public function startRegistration(Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'not_authenticated'], 401);
        }

        // Generar un challenge simple
        $challenge = random_bytes(32);
        $encoded = rtrim(strtr(base64_encode($challenge), '+/', '-_'), '=');

        $request->getSession()->set('webauthn_challenge', $encoded);

        $publicKey = [
            'challenge' => $encoded,
            'rp' => ['name' => 'APU System'],
            'user' => [
                'id' => rtrim(strtr(base64_encode($user->getUuid()), '+/', '-_'), '='),
                'name' => $user->getEmail(),
                'displayName' => $user->getFullName()
            ],
            'pubKeyCredParams' => [['type' => 'public-key', 'alg' => -7]],
            'timeout' => 60000,
            'attestation' => 'direct'
        ];

        return new JsonResponse($publicKey);
    }

    #[Route('/webauthn/register/finish', name: 'webauthn_register_finish', methods: ['POST'])]
    public function finishRegistration(Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'not_authenticated'], 401);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse(['error' => 'invalid_payload'], 400);
        }

        $attestationObjectB64 = $data['attestationObject'] ?? null;
        $clientDataJSONB64 = $data['clientDataJSON'] ?? null;
        $rawIdB64 = $data['rawId'] ?? null;

        if (!$attestationObjectB64 || !$clientDataJSONB64 || !$rawIdB64) {
            return new JsonResponse(['error' => 'missing_fields'], 400);
        }

        // Validar clientData / attestation básico
        $challenge = $request->getSession()->get('webauthn_challenge');
        if (!$this->webauthnService->validateRegistrationPayload($attestationObjectB64, $clientDataJSONB64, $challenge, $rawIdB64, $user, $request->getHost())) {
            return new JsonResponse(['error' => 'invalid_attestation'], 400);
        }

        // Guardar credencial básica
        $credentialId = $rawIdB64;
        $publicKey = $data['publicKey'] ?? '';

        $cred = new WebAuthnCredential($user, $credentialId, $publicKey);
        $cred->setAttestation($attestationObjectB64);

        // Intento de extracción básica de fmt / aaguid desde attestationObject
        $fmt = $data['fmt'] ?? null;
        if ($fmt) {
            $cred->setFmt($fmt);
        }

        // Extraer authData->aaguid (básico): buscar "authData" en el CBOR y obtener bytes
        $aaguid = $this->extractAaguidFromAttestation($attestationObjectB64);
        if ($aaguid) {
            $cred->setAaguid($aaguid);
        }

        // transports si vienen
        if (!empty($data['transports'])) {
            $cred->setTransports(json_encode($data['transports']));
        }

        $this->em->persist($cred);
        $this->em->flush();

        // If user is admin, ensure hardware-attested
        $isAdmin = in_array('ROLE_ADMIN', $user->getRoles(), true) || in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true);
        $fmt = $data['fmt'] ?? null;
        if ($isAdmin && !$this->webauthnService->isHardwareAttested($fmt, $aaguid)) {
            // remove stored cred and reject
            $this->em->remove($cred);
            $this->em->flush();
            return new JsonResponse(['error' => 'admin_requires_hardware_attestation'], 403);
        }

        $this->securityLogger->logWebAuthnRegistered($user, 'webauthn');

        return new JsonResponse(['ok' => true]);
    }

    #[Route('/webauthn/revoke/{id}', name: 'webauthn_revoke', methods: ['POST'])]
    public function revoke(Request $request, int $id): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'not_authenticated'], 401);
        }

        $repo = $this->em->getRepository(WebAuthnCredential::class);
        $cred = $repo->find($id);
        if (!$cred || $cred->getUser()->getId() !== $user->getId()) {
            return new JsonResponse(['error' => 'not_found'], 404);
        }

        $this->em->remove($cred);
        $this->em->flush();

        $this->securityLogger->log('webauthn_revoked', 'INFO', $user, ['credential_id' => $cred->getCredentialId()]);

        return new JsonResponse(['ok' => true]);
    }

    private function extractAaguidFromAttestation(string $attestationB64): ?string
    {
        // Base64url -> binary
        $b64 = strtr($attestationB64, '-_', '+/');
        $pad = strlen($b64) % 4;
        if ($pad) $b64 .= str_repeat('=', 4 - $pad);
        $bin = base64_decode($b64);

        if ($bin === false) {
            return null;
        }

        $pos = strpos($bin, 'authData');
        if ($pos === false) {
            return null;
        }

        $offset = $pos + strlen('authData');
        // Buscar el siguiente byte que indique un byte string (0x40-0x5f)
        $len = strlen($bin);
        for ($i = 0; $i < 6 && ($offset + $i) < $len; $i++) {
            $b = ord($bin[$offset + $i]);
            // Major type 2 (byte string) => high 3 bits == 2
            if (($b >> 5) === 2) {
                $idx = $offset + $i;
                $ai = $b & 0x1f;
                $dataLen = 0;
                if ($ai < 24) {
                    $dataLen = $ai;
                    $start = $idx + 1;
                } elseif ($ai === 24) {
                    $dataLen = ord($bin[$idx + 1]);
                    $start = $idx + 2;
                } elseif ($ai === 25) {
                    $dataLen = (ord($bin[$idx + 1]) << 8) | ord($bin[$idx + 2]);
                    $start = $idx + 3;
                } elseif ($ai === 26) {
                    $dataLen = (ord($bin[$idx + 1]) << 24) | (ord($bin[$idx + 2]) << 16) | (ord($bin[$idx + 3]) << 8) | ord($bin[$idx + 4]);
                    $start = $idx + 5;
                } else {
                    return null;
                }

                if (($start + $dataLen) > $len) return null;

                $authData = substr($bin, $start, $dataLen);
                // authData layout: rpIdHash(32) + flags(1) + signCount(4) + aaguid(16) + credIdLen(2) + credId ...
                if (strlen($authData) < 37 + 16) return null;
                $aaguidBin = substr($authData, 37, 16);
                $aaguidHex = strtolower(bin2hex($aaguidBin));
                return $aaguidHex;
            }
        }

        return null;
    }
}
