<?php

namespace App\Service;

class PasswordPolicyService
{
    /**
     * Comprueba fortaleza mínima de contraseña.
     * Reglas: >=12 chars, mayúscula, minúscula, dígito y símbolo
     */
    public function isStrongPassword(string $password): bool
    {
        if (strlen($password) < 12) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $password)) return false;
        if (!preg_match('/[a-z]/', $password)) return false;
        if (!preg_match('/[0-9]/', $password)) return false;
        if (!preg_match('/[\W_]/', $password)) return false;

        return true;
    }
}
