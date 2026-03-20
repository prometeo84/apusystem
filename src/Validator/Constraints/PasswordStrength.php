<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD)]
class PasswordStrength extends Constraint
{
    public string $messageTooShort = 'La contraseña debe tener al menos {{ minLength }} caracteres.';
    public string $messageNoUppercase = 'La contraseña debe contener al menos una letra mayúscula.';
    public string $messageNoLowercase = 'La contraseña debe contener al menos una letra minúscula.';
    public string $messageNoNumber = 'La contraseña debe contener al menos un número.';
    public string $messageNoSpecial = 'La contraseña debe contener al menos un carácter especial (!@#$%^&*).';

    public int $minLength = 8;
    public bool $requireUppercase = true;
    public bool $requireLowercase = true;
    public bool $requireNumber = true;
    public bool $requireSpecial = true;
}
