<?php

namespace App\Service;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Defuse\Crypto\Exception\CryptoException;

/**
 * Servicio de encriptación para datos sensibles (TOTP secrets, etc.)
 * Usa defuse/php-encryption (authenticated encryption)
 */
class EncryptionService
{
    private Key $key;

    public function __construct(string $appSecret)
    {
        // Generar clave desde APP_SECRET (debe ser >= 32 caracteres)
        $keyMaterial = hash('sha256', $appSecret, true);
        $this->key = Key::loadFromAsciiSafeString(
            base64_encode($keyMaterial . str_repeat("\0", 32 - strlen($keyMaterial)))
        );
    }

    /**
     * Encripta un string (ej: TOTP secret)
     *
     * @throws CryptoException
     */
    public function encrypt(string $plaintext): string
    {
        return Crypto::encrypt($plaintext, $this->key);
    }

    /**
     * Desencripta un string encriptado
     *
     * @throws CryptoException
     */
    public function decrypt(string $ciphertext): string
    {
        return Crypto::decrypt($ciphertext, $this->key);
    }

    /**
     * Intenta desencriptar, retorna null si falla (para migración)
     */
    public function decryptOrNull(string $ciphertext): ?string
    {
        try {
            return $this->decrypt($ciphertext);
        } catch (CryptoException $e) {
            return null;
        }
    }
}
