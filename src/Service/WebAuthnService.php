<?php

namespace App\Service;

use App\Entity\WebAuthnCredential;
use App\Entity\User;
use Psr\Log\LoggerInterface;

class WebAuthnService
{
    public function __construct(private LoggerInterface $logger) {}

    // -----------------------------------------------------------------------
    // REGISTRATION
    // -----------------------------------------------------------------------

    /**
     * Validate clientDataJSON for a registration ceremony.
     */
    public function validateClientData(string $clientDataJSONB64, string $expectedChallenge, string $expectedType = 'webauthn.create'): bool
    {
        $json = $this->base64UrlDecode($clientDataJSONB64);
        if ($json === false) {
            $this->logger->warning('webauthn: cannot decode clientDataJSON');
            return false;
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            $this->logger->warning('webauthn: clientDataJSON is not valid JSON');
            return false;
        }

        $type = $data['type'] ?? null;
        if ($type !== $expectedType) {
            $this->logger->warning('webauthn: unexpected clientData type', ['type' => $type, 'expected' => $expectedType]);
            return false;
        }

        // Normalize challenge (remove padding, standardize alphabet)
        $gotChallenge = rtrim(strtr($data['challenge'] ?? '', '+/', '-_'), '=');
        $expectedNormalized = rtrim(strtr($expectedChallenge, '+/', '-_'), '=');
        if (!hash_equals($expectedNormalized, $gotChallenge)) {
            $this->logger->warning('webauthn: challenge mismatch');
            return false;
        }

        return true;
    }

    /**
     * Validate a registration payload.
     * Returns the extracted COSE public key (base64url) on success, or null on failure.
     */
    public function validateRegistrationPayload(
        string $attestationObjectB64,
        string $clientDataJSONB64,
        string $expectedChallenge,
        string $rawIdB64,
        User $user,
        string $host
    ): bool {
        return $this->doValidateRegistration($attestationObjectB64, $clientDataJSONB64, $expectedChallenge, $rawIdB64, $user, $host) !== null;
    }

    /**
     * Validate registration and return extracted auth data info (publicKey, aaguid, signCount).
     * Returns null on failure.
     *
     * @return array{publicKey: string, aaguid: ?string, signCount: int}|null
     */
    public function extractRegistrationData(
        string $attestationObjectB64,
        string $clientDataJSONB64,
        string $expectedChallenge,
        string $rawIdB64,
        User $user,
        string $host
    ): ?array {
        return $this->doValidateRegistration($attestationObjectB64, $clientDataJSONB64, $expectedChallenge, $rawIdB64, $user, $host);
    }

    /**
     * Check whether attestation format indicates hardware key.
     * Only allows packed, fido-u2f, android-key, apple (non-none attestation with non-zero AAGUID).
     */
    public function isHardwareAttested(?string $fmt, ?string $aaguid): bool
    {
        if (empty($fmt) || strtolower($fmt) === 'none') {
            return false;
        }

        $allowedFormats = ['packed', 'fido-u2f', 'android-key', 'apple', 'tpm'];
        if (!in_array(strtolower($fmt), $allowedFormats, true)) {
            return false;
        }

        // Require a non-zero AAGUID for packed/tpm/android-key/apple attestation
        if (!empty($aaguid)) {
            $hex = preg_replace('/[^0-9a-f]/i', '', $aaguid);
            if (strlen($hex) === 32 && !preg_match('/^0+$/', $hex)) {
                return true;
            }
        }

        // fido-u2f can have zero AAGUID (by spec), still counts as hardware
        if (strtolower($fmt) === 'fido-u2f') {
            return true;
        }

        return false;
    }

    // -----------------------------------------------------------------------
    // AUTHENTICATION (assertion)
    // -----------------------------------------------------------------------

    /**
     * Validate a WebAuthn assertion (login) response.
     * Returns true on valid signature, false otherwise.
     */
    public function validateAssertionResponse(
        string $credentialIdB64,
        string $clientDataJSONB64,
        string $authenticatorDataB64,
        string $signatureB64,
        string $expectedChallenge,
        WebAuthnCredential $credential,
        string $host
    ): bool {
        // 1. Validate clientData
        if (!$this->validateClientData($clientDataJSONB64, $expectedChallenge, 'webauthn.get')) {
            return false;
        }

        // 2. Verify credential ID matches
        $gotId = rtrim(strtr($credentialIdB64, '+/', '-_'), '=');
        $storedId = rtrim(strtr($credential->getCredentialId(), '+/', '-_'), '=');
        if (!hash_equals($storedId, $gotId)) {
            $this->logger->warning('webauthn: credential ID mismatch');
            return false;
        }

        // 3. Decode authenticator data
        $authDataBin = $this->base64UrlDecodeBin($authenticatorDataB64);
        if ($authDataBin === null || strlen($authDataBin) < 37) {
            $this->logger->warning('webauthn: invalid authenticatorData');
            return false;
        }

        // 4. Verify rpIdHash
        $rpIdHash = substr($authDataBin, 0, 32);
        $expectedRpIdHash = hash('sha256', $host, true);
        if (!hash_equals($expectedRpIdHash, $rpIdHash)) {
            $this->logger->warning('webauthn: rpIdHash mismatch');
            return false;
        }

        // 5. Check UP flag (bit 0 of flags byte)
        $flags = ord($authDataBin[32]);
        if (!($flags & 0x01)) {
            $this->logger->warning('webauthn: user presence flag not set');
            return false;
        }

        // 6. Verify signature using stored public key
        $publicKeyB64 = $credential->getPublicKey();
        if (empty($publicKeyB64)) {
            $this->logger->warning('webauthn: no public key stored for credential');
            return false;
        }

        // Build verification data: authData || SHA-256(clientDataJSON)
        $clientDataHashBin = hash('sha256', $this->base64UrlDecode($clientDataJSONB64), true);
        $verificationData = $authDataBin . $clientDataHashBin;

        $signatureBin = $this->base64UrlDecodeBin($signatureB64);
        if ($signatureBin === null) {
            return false;
        }

        return $this->verifySignature($verificationData, $signatureBin, $publicKeyB64);
    }

    // -----------------------------------------------------------------------
    // PRIVATE HELPERS
    // -----------------------------------------------------------------------

    /**
     * @return array{publicKey: string, aaguid: ?string, signCount: int}|null
     */
    private function doValidateRegistration(
        string $attestationObjectB64,
        string $clientDataJSONB64,
        string $expectedChallenge,
        string $rawIdB64,
        User $user,
        string $host
    ): ?array {
        if (!$this->validateClientData($clientDataJSONB64, $expectedChallenge, 'webauthn.create')) {
            return null;
        }

        $attestationBin = $this->base64UrlDecodeBin($attestationObjectB64);
        if ($attestationBin === null) {
            $this->logger->warning('webauthn: cannot decode attestationObject');
            return null;
        }

        $parsed = $this->parseCborMap($attestationBin, 0);
        if ($parsed === null || !isset($parsed['value']['authData'])) {
            $this->logger->warning('webauthn: cannot parse attestationObject CBOR');
            return null;
        }

        $authDataBin = $parsed['value']['authData'];

        // authData structure: rpIdHash(32) + flags(1) + signCount(4) + aaguid(16) + credIdLen(2) + credId(var) + cosePublicKey(var)
        if (strlen($authDataBin) < 55) {
            $this->logger->warning('webauthn: authData too short');
            return null;
        }

        // Verify rpIdHash
        $rpIdHash = substr($authDataBin, 0, 32);
        $expectedRpIdHash = hash('sha256', $host, true);
        if (!hash_equals($expectedRpIdHash, $rpIdHash)) {
            $this->logger->warning('webauthn: rpIdHash mismatch during registration');
            return null;
        }

        // Check UP flag
        $flags = ord($authDataBin[32]);
        if (!($flags & 0x01)) {
            $this->logger->warning('webauthn: user presence flag not set');
            return null;
        }

        // signCount (4 bytes big-endian at offset 33)
        $signCount = unpack('N', substr($authDataBin, 33, 4))[1];

        // aaguid (16 bytes at offset 37)
        $aaguidBin = substr($authDataBin, 37, 16);
        $aaguidHex = strtolower(bin2hex($aaguidBin));

        // credIdLen (2 bytes big-endian at offset 53)
        $credIdLen = unpack('n', substr($authDataBin, 53, 2))[1];
        $offset = 55;

        if (strlen($authDataBin) < $offset + $credIdLen) {
            $this->logger->warning('webauthn: authData too short for credId');
            return null;
        }

        $offset += $credIdLen;

        // COSE public key starts at offset
        $coseKeyBin = substr($authDataBin, $offset);
        if (empty($coseKeyBin)) {
            $this->logger->warning('webauthn: no COSE public key in authData');
            return null;
        }

        // Store COSE key as base64url
        $publicKeyB64 = rtrim(strtr(base64_encode($coseKeyBin), '+/', '-_'), '=');

        return [
            'publicKey' => $publicKeyB64,
            'aaguid'    => $aaguidHex,
            'signCount' => $signCount,
        ];
    }

    /**
     * Verify an EC P-256 or RSA signature against data using stored COSE public key.
     */
    private function verifySignature(string $verificationData, string $signatureBin, string $publicKeyB64): bool
    {
        $coseKeyBin = $this->base64UrlDecodeBin($publicKeyB64);
        if ($coseKeyBin === null) {
            return false;
        }

        // Parse COSE key to extract algorithm and key material
        $parsed = $this->parseCborMap($coseKeyBin, 0);
        if ($parsed === null || !isset($parsed['value'])) {
            $this->logger->warning('webauthn: cannot parse COSE key');
            return false;
        }

        $coseKey = $parsed['value'];
        $kty = $coseKey[1] ?? null;   // Key type: 2=EC2, 3=RSA
        $alg = $coseKey[3] ?? null;   // Algorithm: -7=ES256, -257=RS256

        try {
            if ($kty === 2) {
                // EC2 key (P-256)
                $x = $coseKey[-2] ?? null;
                $y = $coseKey[-3] ?? null;
                if (!$x || !$y) {
                    return false;
                }
                $pemKey = $this->buildEC2PublicKeyPEM($x, $y);
                $openSslAlg = OPENSSL_ALGO_SHA256;
            } elseif ($kty === 3) {
                // RSA key
                $n = $coseKey[-1] ?? null;
                $e = $coseKey[-2] ?? null;
                if (!$n || !$e) {
                    return false;
                }
                $pemKey = $this->buildRSAPublicKeyPEM($n, $e);
                $openSslAlg = OPENSSL_ALGO_SHA256;
            } else {
                $this->logger->warning('webauthn: unsupported key type', ['kty' => $kty]);
                return false;
            }

            $result = openssl_verify($verificationData, $signatureBin, $pemKey, $openSslAlg);
            return $result === 1;
        } catch (\Throwable $e) {
            $this->logger->warning('webauthn: signature verification error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Build PEM for uncompressed EC P-256 public key from x,y coordinates.
     */
    private function buildEC2PublicKeyPEM(string $x, string $y): string
    {
        // EC P-256 OID: 1.2.840.10045.2.1  curve OID: 1.2.840.10045.3.1.7
        $oidHeader = hex2bin('3059301306072a8648ce3d020106082a8648ce3d030107034200');
        $uncompressedPoint = chr(0x04) . str_pad($x, 32, "\x00", STR_PAD_LEFT) . str_pad($y, 32, "\x00", STR_PAD_LEFT);
        $der = $oidHeader . $uncompressedPoint;
        return "-----BEGIN PUBLIC KEY-----\n" . chunk_split(base64_encode($der), 64, "\n") . "-----END PUBLIC KEY-----\n";
    }

    /**
     * Build PEM for RSA public key from modulus (n) and exponent (e).
     */
    private function buildRSAPublicKeyPEM(string $n, string $e): string
    {
        $modLen = strlen($n);
        $expLen = strlen($e);

        // Ensure positive integers (prepend 0x00 if high bit set)
        if (ord($n[0]) > 0x7f) $n = "\x00" . $n;
        if (ord($e[0]) > 0x7f) $e = "\x00" . $e;

        $modDer = "\x02" . $this->derLength(strlen($n)) . $n;
        $expDer = "\x02" . $this->derLength(strlen($e)) . $e;
        $seqContent = $modDer . $expDer;
        $seq = "\x30" . $this->derLength(strlen($seqContent)) . $seqContent;

        // RSA OID: 1.2.840.113549.1.1.1
        $oidHeader = hex2bin('300d06092a864886f70d0101010500');
        $bitStr = "\x03" . $this->derLength(strlen($seq) + 1) . "\x00" . $seq;
        $der = "\x30" . $this->derLength(strlen($oidHeader) + strlen($bitStr)) . $oidHeader . $bitStr;

        return "-----BEGIN PUBLIC KEY-----\n" . chunk_split(base64_encode($der), 64, "\n") . "-----END PUBLIC KEY-----\n";
    }

    private function derLength(int $len): string
    {
        if ($len < 128) {
            return chr($len);
        }
        $bytes = '';
        $tmp = $len;
        while ($tmp > 0) {
            $bytes = chr($tmp & 0xff) . $bytes;
            $tmp >>= 8;
        }
        return chr(0x80 | strlen($bytes)) . $bytes;
    }

    /**
     * Parse a CBOR map/bytes/text/array at given offset.
     * Simplified: handles only what we need for WebAuthn (maps, byte strings, text, integers, arrays, booleans).
     *
     * @return array{value: mixed, next: int}|null
     */
    private function parseCborMap(string $data, int $offset): ?array
    {
        if ($offset >= strlen($data)) return null;

        $initialByte = ord($data[$offset]);
        $majorType = ($initialByte >> 5) & 0x07;
        $additionalInfo = $initialByte & 0x1f;
        $offset++;

        // Determine length/value
        $value = null;
        if ($additionalInfo < 24) {
            $value = $additionalInfo;
        } elseif ($additionalInfo === 24) {
            if ($offset >= strlen($data)) return null;
            $value = ord($data[$offset++]);
        } elseif ($additionalInfo === 25) {
            if ($offset + 1 >= strlen($data)) return null;
            $value = (ord($data[$offset]) << 8) | ord($data[$offset + 1]);
            $offset += 2;
        } elseif ($additionalInfo === 26) {
            if ($offset + 3 >= strlen($data)) return null;
            $value = (ord($data[$offset]) << 24) | (ord($data[$offset + 1]) << 16) | (ord($data[$offset + 2]) << 8) | ord($data[$offset + 3]);
            $offset += 4;
        } elseif ($additionalInfo === 27) {
            // 8-byte unsigned int — for our purposes, just skip
            $offset += 8;
            $value = 0;
        } elseif ($additionalInfo === 31) {
            $value = -1; // indefinite length — not supported
        }

        switch ($majorType) {
            case 0: // unsigned integer
                return ['value' => (int)$value, 'next' => $offset];

            case 1: // negative integer
                return ['value' => -1 - (int)$value, 'next' => $offset];

            case 2: // byte string
                $len = (int)$value;
                if ($offset + $len > strlen($data)) return null;
                $bytes = substr($data, $offset, $len);
                return ['value' => $bytes, 'next' => $offset + $len];

            case 3: // text string
                $len = (int)$value;
                if ($offset + $len > strlen($data)) return null;
                $text = substr($data, $offset, $len);
                return ['value' => $text, 'next' => $offset + $len];

            case 4: // array
                $count = (int)$value;
                $arr = [];
                for ($i = 0; $i < $count; $i++) {
                    $item = $this->parseCborMap($data, $offset);
                    if ($item === null) return null;
                    $arr[] = $item['value'];
                    $offset = $item['next'];
                }
                return ['value' => $arr, 'next' => $offset];

            case 5: // map
                $count = (int)$value;
                $map = [];
                for ($i = 0; $i < $count; $i++) {
                    $kItem = $this->parseCborMap($data, $offset);
                    if ($kItem === null) return null;
                    $offset = $kItem['next'];
                    $vItem = $this->parseCborMap($data, $offset);
                    if ($vItem === null) return null;
                    $offset = $vItem['next'];
                    $map[$kItem['value']] = $vItem['value'];
                }
                return ['value' => $map, 'next' => $offset];

            case 7: // float/bool/null
                if ($additionalInfo === 20) return ['value' => false, 'next' => $offset];
                if ($additionalInfo === 21) return ['value' => true, 'next' => $offset];
                if ($additionalInfo === 22) return ['value' => null, 'next' => $offset];
                return ['value' => null, 'next' => $offset];

            default:
                return null;
        }
    }

    // -----------------------------------------------------------------------
    // BASE64URL HELPERS
    // -----------------------------------------------------------------------

    public function base64UrlDecode(string $b64url): string|false
    {
        $b64 = strtr($b64url, '-_', '+/');
        $pad = strlen($b64) % 4;
        if ($pad) $b64 .= str_repeat('=', 4 - $pad);
        return base64_decode($b64, true);
    }

    public function base64UrlDecodeBin(string $b64url): ?string
    {
        $result = $this->base64UrlDecode($b64url);
        return $result === false ? null : $result;
    }

    public function base64UrlEncode(string $binary): string
    {
        return rtrim(strtr(base64_encode($binary), '+/', '-_'), '=');
    }
}
