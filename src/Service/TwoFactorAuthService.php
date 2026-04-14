<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use App\Service\SecurityLogger;
use App\Service\EncryptionService;

class TwoFactorAuthService
{
    private const RECOVERY_CODES_COUNT = 10;
    private const RECOVERY_CODE_LENGTH = 16;

    public function __construct(
        private EntityManagerInterface $em,
        private Google2FA $google2fa,
        private SecurityLogger $securityLogger,
        private \App\Service\RateLimitingService $rateLimiting,
        private \Symfony\Component\Mailer\MailerInterface $mailer,
        private EncryptionService $encryptionService
    ) {}

    /**
     * Genera un secreto TOTP para el usuario
     */
    public function generateTotpSecret(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * Genera el QR code para TOTP
     */
    public function generateQrCode(User $user, string $secret): string
    {
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            'APU System',
            $user->getEmail(),
            $secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $svgCode = $writer->writeString($qrCodeUrl);

        // Convertir SVG a data URI para evitar problemas de interpretación
        return 'data:image/svg+xml;base64,' . base64_encode($svgCode);
    }

    /**
     * Verifica un código TOTP
     */
    public function verifyTotpCode(string $secret, string $code): bool
    {
        // Si el secret está encriptado, desencriptarlo antes de verificar
        $decrypted = $this->encryptionService->decryptOrNull($secret);
        $actualSecret = $decrypted !== null ? $decrypted : $secret;

        // Normalizar: eliminar espacios
        $actualSecret = trim($actualSecret);

        // Registro de depuración: usar SecurityLogger en lugar de escribir en archivo
        $now = (new \DateTime())->format(DATE_ATOM);
        $decryptedFlag = $decrypted !== null ? 'yes' : 'no';
        $secretLen = is_string($actualSecret) ? strlen($actualSecret) : 0;
        try {
            $this->securityLogger->log('totp_debug', 'DEBUG', null, [
                'time' => $now,
                'decrypted' => $decryptedFlag,
                'secret_len' => $secretLen,
                'provided_code' => $code,
            ]);
        } catch (\Throwable $_) {
            // ignore logging errors
        }

        $ok = false;
        $verifyException = null;
        try {
            // Si no se desencriptó y el valor parece un ciphertext, registrar y abortar
            if ($decrypted === null && is_string($secret) && $secretLen > 24 && preg_match('/^[A-Za-z0-9+\/]+=*$/', $secret)) {
                try {
                    $this->securityLogger->log('totp_decryption_failed', 'WARNING', null, [
                        'time' => $now,
                        'secret_len' => $secretLen,
                        'note' => 'input looks like ciphertext but decryptOrNull returned null'
                    ]);
                } catch (\Throwable $_) {
                    // ignore
                }

                $ok = false;
            } else {
                // Log expected OTP to help debugging
                try {
                    $expected = $this->google2fa->getCurrentOtp($actualSecret);
                    $this->securityLogger->log('totp_debug', 'DEBUG', null, ['expected_otp' => $expected, 'time' => $now]);
                } catch (\Throwable $_) {
                    $this->securityLogger->log('totp_debug', 'DEBUG', null, ['expected_otp' => 'ERROR', 'time' => $now]);
                }

                // Allow a small window (1 step = 30s) to tolerate minor clock skew
                $ok = $this->google2fa->verifyKey($actualSecret, $code, 1);
            }
        } catch (\Throwable $e) {
            $verifyException = $e->getMessage();
            $ok = false;
        }

        // Registrar resultado
        try {
            $this->securityLogger->log('totp_debug_result', 'DEBUG', null, [
                'time' => $now,
                'result' => $ok ? 'OK' : 'FAIL',
                'exception' => $verifyException ?? 'none'
            ]);
        } catch (\Throwable $_) {
            // ignore
        }

        return $ok;
    }

    /**
     * Habilita TOTP para un usuario
     */
    public function enableTotp(User $user, string $secret, string $verificationCode): bool
    {
        if (!$this->verifyTotpCode($secret, $verificationCode)) {
            $this->securityLogger->log2FAFailed($user, 'totp', 'Invalid verification code');
            return false;
        }

        $user->setTotpSecret($secret);
        $user->setTotpEnabled(true);

        $this->em->flush();

        $this->securityLogger->log2FASuccess($user, 'totp_enabled');

        return true;
    }

    /**
     * Deshabilita TOTP para un usuario
     */
    public function disableTotp(User $user): void
    {
        $user->setTotpSecret(null);
        $user->setTotpEnabled(false);

        $this->em->flush();
    }

    /**
     * Genera códigos de recuperación
     */
    public function generateRecoveryCodes(User $user, ?User $performedBy = null): array
    {
        $codes = [];

        // Eliminar códigos anteriores no usados
        $conn = $this->em->getConnection();
        $conn->executeStatement(
            'DELETE FROM recovery_codes WHERE user_id = ?',
            [$user->getId()]
        );

        // Generar nuevos códigos
        for ($i = 0; $i < self::RECOVERY_CODES_COUNT; $i++) {
            $code = $this->generateRandomCode();
            $codes[] = $code;

            // Guardar hash del código
            $hash = password_hash($code, PASSWORD_DEFAULT);
            $conn->executeStatement(
                'INSERT INTO recovery_codes (user_id, code_hash, created_at) VALUES (?, ?, NOW())',
                [$user->getId(), $hash]
            );
        }

        // Actualizar contador en user_2fa_settings
        $conn->executeStatement(
            'INSERT INTO user_2fa_settings (user_id, backup_codes_count, recovery_codes_last_generated, created_at, updated_at)
             VALUES (?, ?, NOW(), NOW(), NOW())
             ON DUPLICATE KEY UPDATE
             backup_codes_count = VALUES(backup_codes_count),
             recovery_codes_last_generated = VALUES(recovery_codes_last_generated),
             updated_at = VALUES(updated_at)',
            [$user->getId(), self::RECOVERY_CODES_COUNT]
        );

        // Auditoría: registrar quién generó los códigos
        if ($performedBy !== null) {
            // Administrador los regeneró
            try {
                $this->securityLogger->logRecoveryCodesRegenerated($user, $performedBy);
            } catch (\Throwable $e) {
                // no interrumpir el flujo por logging
            }
        } else {
            $this->securityLogger->log('recovery_codes_regenerated', 'INFO', $user);
        }

        // Revocar todas las sesiones activas del usuario tras regenerar códigos
        try {
            $conn->executeStatement('UPDATE login_sessions SET is_active = 0 WHERE user_id = ?', [$user->getId()]);
        } catch (\Throwable $e) {
            // ignorar errores de revocación para no bloquear la generación
        }

        return $codes;
    }

    /**
     * Verifica y consume un código de recuperación
     */
    public function verifyRecoveryCode(User $user, string $code): bool
    {
        $conn = $this->em->getConnection();

        // Rate limit para uso de recovery codes
        try {
            if (!$this->rateLimiting->checkRecoveryCodeRateLimit($user->getId())) {
                $this->securityLogger->log('recovery_code_rate_limited', 'WARNING', $user);
                return false;
            }
        } catch (\Throwable $e) {
            // En caso de fallo en rate limiter, continuar con verificación (no bloquear por error del servicio)
        }

        // Obtener códigos no usados
        $stmt = $conn->executeQuery(
            'SELECT id, code_hash FROM recovery_codes WHERE user_id = ? AND used_at IS NULL',
            [$user->getId()]
        );

        $recoveryCodes = $stmt->fetchAllAssociative();

        foreach ($recoveryCodes as $recoveryCode) {
            if (password_verify($code, $recoveryCode['code_hash'])) {
                // Marcar como usado
                $conn->executeStatement(
                    'UPDATE recovery_codes SET used_at = NOW() WHERE id = ?',
                    [$recoveryCode['id']]
                );

                // Actualizar contador
                $conn->executeStatement(
                    'UPDATE user_2fa_settings SET backup_codes_count = backup_codes_count - 1 WHERE user_id = ?',
                    [$user->getId()]
                );

                $this->securityLogger->log2FASuccess($user, 'recovery_code');

                // Cuando se usa un recovery code, revocar otras sesiones y alertar
                try {
                    $conn->executeStatement('UPDATE login_sessions SET is_active = 0 WHERE user_id = ?', [$user->getId()]);
                    $this->securityLogger->log('recovery_code_used_revoke_sessions', 'CRITICAL', $user);

                    // Enviar correo de alerta al usuario
                    try {
                        $email = (new \Symfony\Bridge\Twig\Mime\TemplatedEmail())
                            ->from(new \Symfony\Component\Mime\Address(getenv('MAILER_FROM_ADDRESS') ?: 'noreply@apusystem.com', getenv('MAILER_FROM_NAME') ?: 'APU System'))
                            ->to(new \Symfony\Component\Mime\Address($user->getEmail(), $user->getFullName()))
                            ->subject('Alerta: uso de código de recuperación')
                            ->htmlTemplate('emails/recovery_code_used.html.twig')
                            ->context(['user' => $user]);

                        $this->mailer->send($email);
                    } catch (\Throwable $e) {
                        // logging only
                        try {
                            $this->securityLogger->log('recovery_code_email_failed', 'WARNING', $user, ['error' => $e->getMessage()]);
                        } catch (\Throwable $_) {
                        }
                    }
                } catch (\Throwable $e) {
                    // ignore revocation errors
                }

                return true;
            }
        }

        $this->securityLogger->log2FAFailed($user, 'recovery_code', 'Invalid code');

        return false;
    }

    /**
     * Genera un código aleatorio hexadecimal
     */
    private function generateRandomCode(): string
    {
        return bin2hex(\random_bytes(self::RECOVERY_CODE_LENGTH / 2));
    }

    /**
     * Obtiene el número de códigos de recuperación restantes
     */
    public function getRemainingRecoveryCodesCount(User $user): int
    {
        $conn = $this->em->getConnection();
        $stmt = $conn->executeQuery(
            'SELECT COUNT(*) as count FROM recovery_codes WHERE user_id = ? AND used_at IS NULL',
            [$user->getId()]
        );

        $result = $stmt->fetchAssociative();
        return (int) ($result['count'] ?? 0);
    }
}
