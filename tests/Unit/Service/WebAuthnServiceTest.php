<?php

namespace App\Tests\Unit\Service;

use App\Service\WebAuthnService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\NullLogger;

/**
 * UC-03: Servicio WebAuthn
 * Cubre: base64url helpers, isHardwareAttested, validateClientData
 */
class WebAuthnServiceTest extends TestCase
{
    private WebAuthnService $service;

    protected function setUp(): void
    {
        $this->service = new WebAuthnService(new NullLogger());
    }

    // ---- base64UrlDecode ----

    #[Test]
    public function base64UrlDecodeReturnsCorrectString(): void
    {
        // "hello" -> base64 = "aGVsbG8=" -> base64url = "aGVsbG8"
        $result = $this->service->base64UrlDecode('aGVsbG8');
        $this->assertSame('hello', $result);
    }

    #[Test]
    public function base64UrlDecodeHandlesPaddingVariants(): void
    {
        // "Man" -> base64 = "TWFu" (no padding needed)
        $this->assertSame('Man', $this->service->base64UrlDecode('TWFu'));
    }

    #[Test]
    public function base64UrlDecodeHandlesUrlSafeChars(): void
    {
        // Value that would normally contain + and / in standard base64
        $original = chr(0xFB) . chr(0xFF);
        $b64std  = base64_encode($original); // '+/8=' standard
        $b64url  = str_replace(['+', '/', '='], ['-', '_', ''], $b64std);
        $this->assertSame($original, $this->service->base64UrlDecode($b64url));
    }

    #[Test]
    public function base64UrlDecodeReturnsFalseForInvalidInput(): void
    {
        $result = $this->service->base64UrlDecode('!!!invalid!!!');
        $this->assertFalse($result);
    }

    // ---- base64UrlEncode ----

    #[Test]
    public function base64UrlEncodeProducesUrlSafeString(): void
    {
        $binary = random_bytes(32);
        $encoded = $this->service->base64UrlEncode($binary);

        $this->assertStringNotContainsString('+', $encoded);
        $this->assertStringNotContainsString('/', $encoded);
        $this->assertStringNotContainsString('=', $encoded);
    }

    #[Test]
    public function base64UrlEncodeDecodeRoundTrip(): void
    {
        $binary  = random_bytes(64);
        $encoded = $this->service->base64UrlEncode($binary);
        $decoded = $this->service->base64UrlDecodeBin($encoded);
        $this->assertSame($binary, $decoded);
    }

    // ---- isHardwareAttested ----

    #[Test]
    public function fmtNoneIsNotHardwareAttested(): void
    {
        $this->assertFalse($this->service->isHardwareAttested('none', null));
    }

    #[Test]
    public function fmtNoneWithAaguidIsNotHardwareAttested(): void
    {
        $this->assertFalse($this->service->isHardwareAttested('none', 'aabbaabb-aabb-aabb-aabb-aabbccddeeff'));
    }

    #[Test]
    public function fmtPackedWithZeroAaguidIsNotHardwareAttested(): void
    {
        // All-zero AAGUID means "not attested device"
        $this->assertFalse($this->service->isHardwareAttested('packed', '00000000-0000-0000-0000-000000000000'));
    }

    #[Test]
    public function fmtPackedWithRealAaguidIsHardwareAttested(): void
    {
        // Non-zero AAGUID indicates a specific authenticator model
        $this->assertTrue($this->service->isHardwareAttested('packed', 'f8a011f3-8c0a-4d15-8006-17111f9edc7d'));
    }

    #[Test]
    public function fmtAndroidKeyIsHardwareAttested(): void
    {
        $this->assertTrue($this->service->isHardwareAttested('android-key', 'f8a011f3-8c0a-4d15-8006-17111f9edc7d'));
    }

    #[Test]
    public function nullFmtIsNotHardwareAttested(): void
    {
        $this->assertFalse($this->service->isHardwareAttested(null, null));
    }

    // ---- validateClientData ----

    #[Test]
    public function validateClientDataReturnsFalseForInvalidBase64(): void
    {
        $result = $this->service->validateClientData('not_base64!!!', 'challenge123');
        $this->assertFalse($result);
    }

    #[Test]
    public function validateClientDataReturnsFalseForWrongChallenge(): void
    {
        $clientData = json_encode([
            'type'      => 'webauthn.create',
            'challenge' => $this->service->base64UrlEncode(random_bytes(32)),
            'origin'    => 'https://example.com',
        ]);
        $b64 = $this->service->base64UrlEncode($clientData);

        // Pass a different challenge
        $result = $this->service->validateClientData($b64, 'completelydifferentchallenge');
        $this->assertFalse($result);
    }

    #[Test]
    public function validateClientDataReturnsTrueForCorrectData(): void
    {
        $expectedChallenge = random_bytes(32);
        $clientData = json_encode([
            'type'      => 'webauthn.create',
            'challenge' => $this->service->base64UrlEncode($expectedChallenge),
            'origin'    => 'https://example.com',
        ]);
        $b64 = $this->service->base64UrlEncode($clientData);

        $result = $this->service->validateClientData(
            $b64,
            $this->service->base64UrlEncode($expectedChallenge),
            'webauthn.create'
        );
        $this->assertTrue($result);
    }

    #[Test]
    public function validateClientDataReturnsFalseForWrongType(): void
    {
        $challenge = random_bytes(32);
        $clientData = json_encode([
            'type'      => 'webauthn.get', // wrong type for registration
            'challenge' => $this->service->base64UrlEncode($challenge),
            'origin'    => 'https://example.com',
        ]);
        $b64 = $this->service->base64UrlEncode($clientData);

        $result = $this->service->validateClientData(
            $b64,
            $this->service->base64UrlEncode($challenge),
            'webauthn.create' // expected type
        );
        $this->assertFalse($result);
    }
}
