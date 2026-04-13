<?php

namespace App\Controller;

use App\Entity\WebAuthnCredential;
use App\Service\SecurityLogger;
use App\Service\WebAuthnService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class WebAuthnController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SecurityLogger         $securityLogger,
        private WebAuthnService        $webauthnService
    ) {}

    // -----------------------------------------------------------------------
    // LIST / VIEW
    // -----------------------------------------------------------------------

    #[Route('/webauthn/credentials', name: 'webauthn_list')]
    #[IsGranted('ROLE_USER')]
    public function listCredentials(): Response
    {
        $user = $this->getUser();
        $creds = $this->em->getRepository(WebAuthnCredential::class)->findBy(['user' => $user]);

        return $this->render('profile/webauthn.html.twig', [
            'credentials' => $creds,
        ]);
    }

    // -----------------------------------------------------------------------
    // REGISTRATION
    // -----------------------------------------------------------------------

    #[Route('/webauthn/register/start', name: 'webauthn_register_start', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function startRegistration(Request $request): JsonResponse
    {
        $user = $this->getUser();

        $challenge = \random_bytes(32);
        $encodedChallenge = $this->webauthnService->base64UrlEncode($challenge);

        $request->getSession()->set('webauthn_challenge', $encodedChallenge);
        $request->getSession()->set('webauthn_challenge_type', 'registration');

        $publicKey = [
            'challenge' => $encodedChallenge,
            'rp'        => [
                'name' => 'APU System',
                'id'   => $request->getHost(),
            ],
            'user' => [
                'id'          => $this->webauthnService->base64UrlEncode($user->getUuid()),
                'name'        => $user->getEmail(),
                'displayName' => $user->getFullName(),
            ],
            'pubKeyCredParams' => [
                ['type' => 'public-key', 'alg' => -7],   // ES256
                ['type' => 'public-key', 'alg' => -257],  // RS256
            ],
            'authenticatorSelection' => [
                'userVerification' => 'preferred',
            ],
            'timeout'     => 60000,
            'attestation' => 'direct',
        ];

        return new JsonResponse($publicKey);
    }

    #[Route('/webauthn/register/finish', name: 'webauthn_register_finish', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function finishRegistration(Request $request): JsonResponse
    {
        $user = $this->getUser();

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return new JsonResponse(['error' => 'invalid_payload'], 400);
        }

        $attestationObjectB64 = $data['attestationObject'] ?? null;
        $clientDataJSONB64    = $data['clientDataJSON'] ?? null;
        $rawIdB64             = $data['rawId'] ?? null;

        if (!$attestationObjectB64 || !$clientDataJSONB64 || !$rawIdB64) {
            return new JsonResponse(['error' => 'missing_fields'], 400);
        }

        $challenge = $request->getSession()->get('webauthn_challenge');
        $chalType  = $request->getSession()->get('webauthn_challenge_type');

        if (!$challenge || $chalType !== 'registration') {
            return new JsonResponse(['error' => 'no_challenge'], 401);
        }

        $request->getSession()->remove('webauthn_challenge');
        $request->getSession()->remove('webauthn_challenge_type');

        $regData = $this->webauthnService->extractRegistrationData(
            $attestationObjectB64,
            $clientDataJSONB64,
            $challenge,
            $rawIdB64,
            $user,
            $request->getHost()
        );

        if ($regData === null) {
            $this->securityLogger->logWebAuthnFailed($user, 'registration_verification_failed');
            return new JsonResponse(['error' => 'invalid_attestation'], 400);
        }

        $fmt    = $data['fmt'] ?? null;
        $aaguid = $regData['aaguid'];

        // Admins must use hardware-attested keys
        $isAdmin = in_array('ROLE_ADMIN', $user->getRoles(), true) || in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true);
        if ($isAdmin && !$this->webauthnService->isHardwareAttested($fmt, $aaguid)) {
            $this->securityLogger->logWebAuthnFailed($user, 'admin_requires_hardware_key');
            return new JsonResponse(['error' => 'admin_requires_hardware_attestation'], 403);
        }

        $cred = new WebAuthnCredential($user, $rawIdB64, $regData['publicKey']);
        if ($fmt) {
            $cred->setFmt($fmt);
        }
        if ($aaguid) {
            $cred->setAaguid($aaguid);
        }
        if (!empty($data['transports'])) {
            $cred->setTransports(json_encode($data['transports']));
        }
        $cred->setAttestation($attestationObjectB64);

        $this->em->persist($cred);
        $this->em->flush();

        $this->securityLogger->logWebAuthnRegistered($user, 'webauthn');

        return new JsonResponse(['ok' => true]);
    }

    // -----------------------------------------------------------------------
    // AUTHENTICATION (login)
    // -----------------------------------------------------------------------

    #[Route('/webauthn/login/start', name: 'webauthn_login_start', methods: ['POST'])]
    public function startLogin(Request $request): JsonResponse
    {
        $email = $request->getSession()->get('webauthn_pending_email');
        if (!$email) {
            // Allow initiating from request body too
            $body = json_decode($request->getContent(), true) ?? [];
            $email = $body['email'] ?? null;
        }

        if (!$email) {
            return new JsonResponse(['error' => 'no_user_context'], 401);
        }

        /** @var \App\Entity\User|null $user */
        $user = $this->em->getRepository(\App\Entity\User::class)->findOneBy(['email' => $email]);
        if (!$user) {
            // Timing-safe: return a fake challenge
            return new JsonResponse(['error' => 'user_not_found'], 404);
        }

        $creds = $this->em->getRepository(WebAuthnCredential::class)->findBy(['user' => $user]);
        if (empty($creds)) {
            return new JsonResponse(['error' => 'no_credentials'], 404);
        }

        $challenge = \random_bytes(32);
        $encodedChallenge = $this->webauthnService->base64UrlEncode($challenge);

        $request->getSession()->set('webauthn_challenge', $encodedChallenge);
        $request->getSession()->set('webauthn_challenge_type', 'authentication');
        $request->getSession()->set('webauthn_login_email', $email);

        $allowCredentials = array_map(
            fn(WebAuthnCredential $c) => [
                'type'       => 'public-key',
                'id'         => $c->getCredentialId(),
                'transports' => $c->getTransports() ? json_decode($c->getTransports(), true) : [],
            ],
            $creds
        );

        return new JsonResponse([
            'challenge'        => $encodedChallenge,
            'timeout'          => 60000,
            'rpId'             => $request->getHost(),
            'allowCredentials' => $allowCredentials,
            'userVerification' => 'preferred',
        ]);
    }

    #[Route('/webauthn/login/finish', name: 'webauthn_login_finish', methods: ['POST'])]
    public function finishLogin(Request $request): JsonResponse
    {
        $challenge = $request->getSession()->get('webauthn_challenge');
        $chalType  = $request->getSession()->get('webauthn_challenge_type');
        $email     = $request->getSession()->get('webauthn_login_email');

        if (!$challenge || $chalType !== 'authentication' || !$email) {
            return new JsonResponse(['error' => 'no_challenge'], 401);
        }

        $request->getSession()->remove('webauthn_challenge');
        $request->getSession()->remove('webauthn_challenge_type');
        $request->getSession()->remove('webauthn_login_email');
        $request->getSession()->remove('webauthn_pending_email');

        $data = json_decode($request->getContent(), true);
        if (!is_array($data)) {
            return new JsonResponse(['error' => 'invalid_payload'], 400);
        }

        $credentialIdB64    = $data['id'] ?? $data['rawId'] ?? null;
        $clientDataJSONB64  = $data['clientDataJSON'] ?? null;
        $authenticatorDataB64 = $data['authenticatorData'] ?? null;
        $signatureB64       = $data['signature'] ?? null;

        if (!$credentialIdB64 || !$clientDataJSONB64 || !$authenticatorDataB64 || !$signatureB64) {
            return new JsonResponse(['error' => 'missing_fields'], 400);
        }

        /** @var \App\Entity\User|null $user */
        $user = $this->em->getRepository(\App\Entity\User::class)->findOneBy(['email' => $email]);
        if (!$user) {
            return new JsonResponse(['error' => 'user_not_found'], 404);
        }

        // Find matching credential
        $creds = $this->em->getRepository(WebAuthnCredential::class)->findBy(['user' => $user]);
        $normalizedGot = rtrim(strtr($credentialIdB64, '+/', '-_'), '=');
        $matchedCred = null;
        foreach ($creds as $cred) {
            $normalizedStored = rtrim(strtr($cred->getCredentialId(), '+/', '-_'), '=');
            if (hash_equals($normalizedStored, $normalizedGot)) {
                $matchedCred = $cred;
                break;
            }
        }

        if ($matchedCred === null) {
            $this->securityLogger->logWebAuthnFailed($user, 'credential_not_found');
            return new JsonResponse(['error' => 'credential_not_found'], 401);
        }

        $valid = $this->webauthnService->validateAssertionResponse(
            $credentialIdB64,
            $clientDataJSONB64,
            $authenticatorDataB64,
            $signatureB64,
            $challenge,
            $matchedCred,
            $request->getHost()
        );

        if (!$valid) {
            $this->securityLogger->logWebAuthnFailed($user, 'signature_verification_failed');
            return new JsonResponse(['error' => 'invalid_signature'], 401);
        }

        $this->securityLogger->log('webauthn_login_success', 'INFO', $user);

        // Mark session as WebAuthn-authenticated so SecurityController can finalize login
        $request->getSession()->set('webauthn_authenticated_user', $user->getId());

        return new JsonResponse(['ok' => true, 'redirect' => $this->generateUrl('app_dashboard')]);
    }

    // -----------------------------------------------------------------------
    // REVOKE
    // -----------------------------------------------------------------------

    #[Route('/webauthn/revoke/{id}', name: 'webauthn_revoke', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function revoke(Request $request, int $id): JsonResponse
    {
        $user = $this->getUser();
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
}
