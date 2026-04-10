<?php

namespace App\Tests\Unit\Service;

use App\Service\EncryptionService;
use Defuse\Crypto\Exception\CryptoException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * UC-02: Servicio de encriptación (TOTP secrets, datos sensibles)
 * Cubre: encrypt/decrypt con OpenSSL fallback y Defuse
 */
class EncryptionServiceTest extends TestCase
{
    private EncryptionService $service;

    protected function setUp(): void
    {
        // Usar una clave arbitraria en formato no-defuse para forzar el fallback OpenSSL
        $this->service = new EncryptionService('test_app_secret_key_for_unit_tests');
    }

    #[Test]
    public function encryptReturnsDifferentStringThanInput(): void
    {
        $plaintext = 'JBSWY3DPEHPK3PXP';
        $ciphertext = $this->service->encrypt($plaintext);

        $this->assertNotEquals($plaintext, $ciphertext);
        $this->assertNotEmpty($ciphertext);
    }

    #[Test]
    public function encryptThenDecryptReturnsOriginalString(): void
    {
        $plaintext = 'JBSWY3DPEHPK3PXP'; // realistic TOTP secret
        $ciphertext = $this->service->encrypt($plaintext);
        $decrypted  = $this->service->decrypt($ciphertext);

        $this->assertSame($plaintext, $decrypted);
    }

    #[Test]
    public function encryptProducesDifferentCiphertextEachTime(): void
    {
        // Due to random IV, same plaintext should produce different ciphertext
        $plaintext  = 'same_secret';
        $cipher1    = $this->service->encrypt($plaintext);
        $cipher2    = $this->service->encrypt($plaintext);

        // Small probability of collision but practically impossible with random 12-byte IV
        $this->assertNotEquals($cipher1, $cipher2);
    }

    #[Test]
    public function decryptWithWrongKeyThrowsOrReturnsNull(): void
    {
        $cipher = $this->service->encrypt('secret_data');

        $wrongKeyService = new EncryptionService('completely_different_key');

        // decryptOrNull should return null on wrong key
        $result = $wrongKeyService->decryptOrNull($cipher);
        $this->assertNull($result);
    }

    #[Test]
    public function decryptInvalidCiphertextThrowsException(): void
    {
        $this->expectException(\Throwable::class);
        $this->service->decrypt('not_a_valid_ciphertext_at_all');
    }

    #[Test]
    public function decryptOrNullReturnsNullOnInvalidInput(): void
    {
        $result = $this->service->decryptOrNull('garbage_data_!!!');
        $this->assertNull($result);
    }

    #[Test]
    public function encryptEmptyStringSucceeds(): void
    {
        $cipher = $this->service->encrypt('');
        $this->assertSame('', $this->service->decrypt($cipher));
    }

    #[Test]
    public function encryptLongStringSucceeds(): void
    {
        $plaintext = str_repeat('A very long sensitive text. ', 100);
        $cipher    = $this->service->encrypt($plaintext);
        $this->assertSame($plaintext, $this->service->decrypt($cipher));
    }

    #[Test]
    public function encryptUnicodeStringSucceeds(): void
    {
        $plaintext = 'Contraseña con émojis 🔐 y caracteres especiales: ñáéíóú';
        $cipher    = $this->service->encrypt($plaintext);
        $this->assertSame($plaintext, $this->service->decrypt($cipher));
    }
}
