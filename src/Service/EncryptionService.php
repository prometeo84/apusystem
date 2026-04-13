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
    private bool $useDefuse = false;

    // For OpenSSL fallback
    private string $opensslKey;

    public function __construct(string $appSecret)
    {
        // Si el valor pasado parece una clave ascii-safe (formato producido por defuse), intentar cargarla
        // Una ascii-safe string típica contiene caracteres base64-like y suele ser larga; intentamos cargarla y, si falla, utilizamos OpenSSL fallback.
        try {
            // Intentar cargar directamente como ascii-safe string
            $this->key = Key::loadFromAsciiSafeString($appSecret);
            $this->useDefuse = true;
            return;
        } catch (\Throwable $e) {
            // No es una ascii-safe string válida para defuse; usar fallback OpenSSL con derivación de clave
        }

        // Derivar clave binaria para OpenSSL AES-256-GCM
        $this->opensslKey = hash('sha256', $appSecret, true);
        $this->useDefuse = false;
    }

    /**
     * Encripta un string (ej: TOTP secret)
     *
     * @throws CryptoException
     */
    public function encrypt(string $plaintext): string
    {
        if ($this->useDefuse) {
            return Crypto::encrypt($plaintext, $this->key);
        }

        // OpenSSL AES-256-GCM: store as base64(iv|tag|ciphertext)
        $iv = \random_bytes(12);
        $tag = '';
        $ciphertext = openssl_encrypt($plaintext, 'aes-256-gcm', $this->opensslKey, OPENSSL_RAW_DATA, $iv, $tag);
        if ($ciphertext === false) {
            throw new CryptoException('OpenSSL encryption failed');
        }

        return base64_encode($iv . $tag . $ciphertext);
    }

    /**
     * Desencripta un string encriptado
     *
     * @throws CryptoException
     */
    public function decrypt(string $ciphertext): string
    {
        if ($this->useDefuse) {
            return Crypto::decrypt($ciphertext, $this->key);
        }

        $data = base64_decode($ciphertext, true);
        if ($data === false || strlen($data) < 28) {
            throw new CryptoException('Invalid ciphertext format');
        }

        $iv = substr($data, 0, 12);
        $tag = substr($data, 12, 16);
        $enc = substr($data, 28);

        $plaintext = openssl_decrypt($enc, 'aes-256-gcm', $this->opensslKey, OPENSSL_RAW_DATA, $iv, $tag);
        if ($plaintext === false) {
            throw new CryptoException('OpenSSL decryption failed');
        }

        return $plaintext;
    }

    /**
     * Intenta desencriptar, retorna null si falla (para migración)
     */
    public function decryptOrNull(string $ciphertext): ?string
    {
        try {
            return $this->decrypt($ciphertext);
        } catch (CryptoException $e) {
            // Intento de respaldo: si la clave usada para construir este servicio no funcionó,
            // intentar leer un APP_SECRET desde el archivo .env del proyecto (útil en entornos
            // donde la variable de entorno no esté presente para procesos CLI/worker).
            try {
                $rootEnv = @file_get_contents(__DIR__ . '/../../.env');
                if ($rootEnv !== false && preg_match('/APP_SECRET=([^\n\r]+)/', $rootEnv, $m)) {
                    $fallback = trim($m[1]);
                    if ($fallback !== '') {
                        try {
                            // intentar con defuse format
                            $k = Key::loadFromAsciiSafeString($fallback);
                            return Crypto::decrypt($ciphertext, $k);
                        } catch (\Throwable $_) {
                            // fallback OpenSSL derivation
                            $opensslKey = hash('sha256', $fallback, true);
                            $data = base64_decode($ciphertext, true);
                            if ($data !== false && strlen($data) >= 28) {
                                $iv = substr($data, 0, 12);
                                $tag = substr($data, 12, 16);
                                $enc = substr($data, 28);
                                $plaintext = openssl_decrypt($enc, 'aes-256-gcm', $opensslKey, OPENSSL_RAW_DATA, $iv, $tag);
                                if ($plaintext !== false) {
                                    return $plaintext;
                                }
                            }
                        }
                    }
                }
            } catch (\Throwable $_) {
                // swallow fallback errors
            }

            return null;
        }
    }
}
