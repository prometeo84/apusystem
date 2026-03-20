<?php

namespace App\Service;

/**
 * Servicio para hashear y verificar recovery codes
 * Usa Argon2ID (lo más seguro actualmente)
 */
class RecoveryCodeHasher
{
    /**
     * Hashea un recovery code
     */
    public function hash(string $code): string
    {
        return password_hash(
            $code,
            PASSWORD_ARGON2ID,
            [
                'memory_cost' => 65536,  // 64MB
                'time_cost' => 4,
                'threads' => 2,
            ]
        );
    }

    /**
     * Verifica un recovery code contra su hash
     */
    public function verify(string $code, string $hash): bool
    {
        return password_verify($code, $hash);
    }

    /**
     * Verifica si un hash necesita ser rehashed (parámetros cambiaron)
     */
    public function needsRehash(string $hash): bool
    {
        return password_needs_rehash(
            $hash,
            PASSWORD_ARGON2ID,
            [
                'memory_cost' => 65536,
                'time_cost' => 4,
                'threads' => 2,
            ]
        );
    }
}
