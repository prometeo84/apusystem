<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\RateLimiter\RateLimiterFactory;

class RateLimitingService
{
    public function __construct(
        private EntityManagerInterface $em,
        private SecurityLogger $securityLogger,
        private RequestStack $requestStack
    ) {}

    /**
     * Verifica si se excedió el límite de intentos de login
     */
    public function checkLoginRateLimit(string $identifier): bool
    {
        return $this->checkRateLimit('login', $identifier, 5, 900); // 5 intentos en 15 min
    }

    /**
     * Verifica límite de acciones de administrador
     */
    public function checkAdminActionRateLimit(UserInterface $admin, string $action): bool
    {
        /** @var \App\Entity\User $admin */
        $identifier = 'admin_' . $admin->getId() . '_' . $action;
        $exceeded = !$this->checkRateLimit('admin_action', $identifier, 10, 3600); // 10 en 1 hora

        if ($exceeded) {
            $this->securityLogger->logAdminRateLimitExceeded($admin, $action);
        }

        return !$exceeded;
    }

    /**
     * Verifica límite de acceso a datos sensibles
     */
    public function checkSensitiveDataAccessRateLimit(string $ipAddress, string $dataType): bool
    {
        $identifier = 'sensitive_' . $ipAddress . '_' . $dataType;
        return $this->checkRateLimit('sensitive_data', $identifier, 20, 3600); // 20 en 1 hora
    }

    /**
     * Verifica límite general de API
     */
    public function checkApiRateLimit(string $identifier): bool
    {
        return $this->checkRateLimit('api', $identifier, 100, 3600); // 100 en 1 hora
    }

    /**
     * Límite específico para uso de recovery codes por usuario
     */
    public function checkRecoveryCodeRateLimit(int $userId): bool
    {
        $identifier = 'recovery_user_' . $userId;
        return $this->checkRateLimit('recovery_code', $identifier, 5, 3600); // 5 usos en 1 hora
    }

    /**
     * Método general de rate limiting
     * Retorna true si está dentro del límite, false si se excedió
     */
    private function checkRateLimit(
        string $endpoint,
        string $identifier,
        int $maxAttempts,
        int $windowSeconds
    ): bool {
        $now = new \DateTime();
        $windowStart = new \DateTime('-' . $windowSeconds . ' seconds');
        $windowEnd = clone $now;
        $windowEnd->modify('+' . $windowSeconds . ' seconds');

        $conn = $this->em->getConnection();

        // Verificar intentos existentes en la ventana
        $stmt = $conn->executeQuery(
            'SELECT attempts, exceeded_at FROM rate_limit_logs
             WHERE identifier = ?
             AND endpoint = ?
             AND window_end > ?
             ORDER BY id DESC
             LIMIT 1',
            [$identifier, $endpoint, $windowStart->format('Y-m-d H:i:s')]
        );

        $existing = $stmt->fetchAssociative();

        if ($existing) {
            $attempts = (int) $existing['attempts'];

            // Si ya se excedió y aún está en la ventana
            if ($existing['exceeded_at'] !== null) {
                return false;
            }

            // Incrementar intentos
            $attempts++;

            $conn->executeStatement(
                'UPDATE rate_limit_logs
                 SET attempts = ?, exceeded_at = ?
                 WHERE identifier = ? AND endpoint = ? AND window_end > ?',
                [
                    $attempts,
                    $attempts > $maxAttempts ? $now->format('Y-m-d H:i:s') : null,
                    $identifier,
                    $endpoint,
                    $windowStart->format('Y-m-d H:i:s')
                ]
            );

            return $attempts <= $maxAttempts;
        }

        // Crear nuevo registro
        $conn->executeStatement(
            'INSERT INTO rate_limit_logs (identifier, endpoint, attempts, window_start, window_end, created_at)
             VALUES (?, ?, 1, ?, ?, ?)',
            [
                $identifier,
                $endpoint,
                $now->format('Y-m-d H:i:s'),
                $windowEnd->format('Y-m-d H:i:s'),
                $now->format('Y-m-d H:i:s')
            ]
        );

        return true;
    }

    /**
     * Resetea el rate limit para un identificador
     */
    public function resetRateLimit(string $endpoint, string $identifier): void
    {
        $conn = $this->em->getConnection();
        $conn->executeStatement(
            'DELETE FROM rate_limit_logs WHERE identifier = ? AND endpoint = ?',
            [$identifier, $endpoint]
        );
    }

    /**
     * Limpia registros antiguos de rate limiting (mantenimiento)
     */
    public function cleanOldRecords(): int
    {
        $cutoff = new \DateTime('-24 hours');
        $conn = $this->em->getConnection();

        return $conn->executeStatement(
            'DELETE FROM rate_limit_logs WHERE window_end < ?',
            [$cutoff->format('Y-m-d H:i:s')]
        );
    }
}
