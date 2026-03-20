<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Validator para complejidad de contraseña (OWASP compliance)
 */
class PasswordStrengthValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof PasswordStrength) {
            throw new UnexpectedTypeException($constraint, PasswordStrength::class);
        }

        // Null y string vacío se consideran válidos (usa NotBlank para requerido)
        if (null === $value || '' === $value) {
            return;
        }

        if (!\is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        // 1. Longitud mínima
        if (strlen($value) < $constraint->minLength) {
            $this->context->buildViolation($constraint->messageTooShort)
                ->setParameter('{{ minLength }}', (string) $constraint->minLength)
                ->addViolation();
            return;
        }

        // 2. Al menos una mayúscula
        if ($constraint->requireUppercase && !preg_match('/[A-Z]/', $value)) {
            $this->context->buildViolation($constraint->messageNoUppercase)
                ->addViolation();
        }

        // 3. Al menos una minúscula
        if ($constraint->requireLowercase && !preg_match('/[a-z]/', $value)) {
            $this->context->buildViolation($constraint->messageNoLowercase)
                ->addViolation();
        }

        // 4. Al menos un número
        if ($constraint->requireNumber && !preg_match('/[0-9]/', $value)) {
            $this->context->buildViolation($constraint->messageNoNumber)
                ->addViolation();
        }

        // 5. Al menos un carácter especial
        if ($constraint->requireSpecial && !preg_match('/[!@#$%^&*(),.?":{}|<>_\-+=\[\]\/\\\\]/', $value)) {
            $this->context->buildViolation($constraint->messageNoSpecial)
                ->addViolation();
        }
    }
}
