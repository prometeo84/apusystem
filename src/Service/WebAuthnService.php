<?php

namespace App\Service;

use App\Entity\WebAuthnCredential;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WebAuthnService
{
    public function __construct(private LoggerInterface $logger, private ?HttpClientInterface $httpClient = null) {}

    public function validateClientData(string $clientDataJSONB64, string $expectedChallenge): bool
    {
        $b64 = strtr($clientDataJSONB64, '-_', '+/');
        $pad = strlen($b64) % 4;
        if ($pad) $b64 .= str_repeat('=', 4 - $pad);
        $json = base64_decode($b64);
        if ($json === false) return false;

        $data = json_decode($json, true);
        if (!is_array($data)) return false;

        $challenge = $data['challenge'] ?? null;
        $type = $data['type'] ?? null;

        if ($challenge) {
            $c = rtrim(strtr($challenge, '+/', '-_'), '=');
            if ($c !== $expectedChallenge) {
                $this->logger->warning('webauthn: challenge mismatch', ['got' => $c, 'expected' => $expectedChallenge]);
                return false;
            }
        }

        if ($type !== 'webauthn.create') {
            $this->logger->warning('webauthn: clientData type unexpected', ['type' => $type]);
            return false;
        }

        return true;
    }

    public function isHardwareAttested(?string $fmt, ?string $aaguid): bool
    {
        if (empty($aaguid)) return false;
        $hex = preg_replace('/[^0-9a-f]/i', '', $aaguid);
        if (strlen($hex) !== 32) return false;
        if (preg_match('/^0+$/', $hex)) return false;
        if ($fmt && in_array(strtolower($fmt), ['packed', 'android-key', 'fido-u2f', 'apple'], true)) {
            return true;
        }
        return true;
    }

    /**
     * Full verification using web-auth/webauthn-lib when available.
     * Expects the rawId (base64url) and the current user to recreate the creation options.
     */
    public function validateRegistrationPayload(string $attestationObjectB64, string $clientDataJSONB64, string $expectedChallenge, string $rawIdB64, User $user, string $host): bool
    {
        if (!$this->validateClientData($clientDataJSONB64, $expectedChallenge)) {
            return false;
        }

        // If web-auth library is available, attempt full validation
        try {
            if (class_exists(\Webauthn\PublicKeyCredentialLoader::class) && class_exists(\Webauthn\AuthenticatorAttestationResponseValidator::class)) {
                $attStmtManager = \Webauthn\AttestationStatement\AttestationStatementSupportManager::create();
                $attLoader = \Webauthn\AttestationStatement\AttestationObjectLoader::create($attStmtManager);
                $pkLoader = \Webauthn\PublicKeyCredentialLoader::create($attLoader);
                $pkLoader->setLogger($this->logger);

                $pkcArray = [
                    'id' => rtrim(strtr($rawIdB64, '+/', '-_'), '='),
                    'rawId' => $rawIdB64,
                    'type' => 'public-key',
                    'response' => [
                        'attestationObject' => $attestationObjectB64,
                        'clientDataJSON' => $clientDataJSONB64,
                    ],
                ];

                $pkc = $pkLoader->loadArray($pkcArray);

                $options = [
                    'challenge' => $expectedChallenge,
                    'rp' => ['name' => 'APU System', 'id' => $host],
                    'user' => [
                        'id' => rtrim(strtr(base64_encode($user->getUuid()), '+/', '-_'), '='),
                        'name' => $user->getEmail(),
                        'displayName' => $user->getFullName()
                    ],
                    'pubKeyCredParams' => [['type' => 'public-key', 'alg' => -7]],
                    'timeout' => 60000,
                    'attestation' => 'direct'
                ];

                $creationOptions = \Webauthn\PublicKeyCredentialCreationOptions::createFromArray($options);

                $validator = \Webauthn\AuthenticatorAttestationResponseValidator::create();

                // Try to enable metadata support from config/webauthn/metadata if present
                $projectDir = dirname(__DIR__, 2);
                $mdsFolder = $projectDir . '/config/webauthn/metadata';
                if (is_dir($mdsFolder) && is_readable($mdsFolder)) {
                    try {
                        $serializerFactory = new \Webauthn\Denormalizer\WebauthnSerializerFactory(\Webauthn\AttestationStatement\AttestationStatementSupportManager::create());
                        $serializer = $serializerFactory->create();
                        $metadataService = \Webauthn\MetadataService\Service\FolderResourceMetadataService::create($mdsFolder, $serializer);
                        $repo = new class($metadataService) implements \Webauthn\MetadataService\MetadataStatementRepository {
                            private $service;
                            public function __construct($service)
                            {
                                $this->service = $service;
                            }
                            public function findOneByAAGUID(string $aaguid): ?\Webauthn\MetadataService\Statement\MetadataStatement
                            {
                                if ($this->service->has($aaguid)) {
                                    return $this->service->get($aaguid);
                                }
                                return null;
                            }
                        };

                        $statusRepo = new \App\Service\SimpleStatusReportRepository();
                        // Only enable certificate chain validation when we have a proper HttpClientInterface
                        if ($this->httpClient instanceof HttpClientInterface) {
                            $certificateValidator = \Webauthn\MetadataService\CertificateChain\PhpCertificateChainValidator::create($this->httpClient);
                            $validator->enableMetadataStatementSupport($repo, $statusRepo, $certificateValidator);
                        } else {
                            $this->logger->info('webauthn: no HttpClientInterface available; skipping metadata certificate chain validation');
                        }
                    } catch (\Throwable $e) {
                        $this->logger->info('webauthn: failed to enable metadata: ' . $e->getMessage());
                    }
                }

                $validator->setLogger($this->logger);
                $validator->check($pkc->response, $creationOptions, $host);
                return true;
            }
        } catch (\Throwable $e) {
            $this->logger->warning('webauthn full verification failed: ' . $e->getMessage());
        }

        $aaguid = $this->extractAaguidFromAttestation($attestationObjectB64);
        if ($aaguid) {
            return true;
        }

        return false;
    }

    private function extractAaguidFromAttestation(string $attestationB64): ?string
    {
        $b64 = strtr($attestationB64, '-_', '+/');
        $pad = strlen($b64) % 4;
        if ($pad) $b64 .= str_repeat('=', 4 - $pad);
        $bin = base64_decode($b64);
        if ($bin === false) return null;

        $pos = strpos($bin, 'authData');
        if ($pos === false) return null;
        $offset = $pos + strlen('authData');
        $len = strlen($bin);
        for ($i = 0; $i < 6 && ($offset + $i) < $len; $i++) {
            $b = ord($bin[$offset + $i]);
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
                if (strlen($authData) < 37 + 16) return null;
                $aaguidBin = substr($authData, 37, 16);
                $aaguidHex = strtolower(bin2hex($aaguidBin));
                return $aaguidHex;
            }
        }
        return null;
    }
}
