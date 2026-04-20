<?php

namespace App\Service;

use App\Entity\SecurityEvent;
use App\Entity\User;
use App\Entity\Tenant;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SecurityLogger
{
    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $requestStack
    ) {}

    public function log(
        string $eventType,
        string $severity = 'INFO',
        ?UserInterface $user = null,
        ?array $eventData = null
    ): void {
        $request   = $this->requestStack->getCurrentRequest();
        $ipAddress = $request ? ($request->getClientIp() ?? '0.0.0.0') : '0.0.0.0';
        $userAgent = $request ? $request->headers->get('User-Agent') : null;

        // Use raw DBAL INSERT to avoid forcing an ORM flush that could persist
        // unrelated pending entity changes and incur a full unit-of-work traversal.
        $conn = $this->em->getConnection();
        $tenantId = null;
        $userId = null;
        if ($user instanceof User) {
            $tenantId = $user->getTenant()?->getId();
            $userId = $user->getId();
        }

        $conn->insert('security_events', [
            'tenant_id'  => $tenantId,
            'user_id'    => $userId,
            'event_type' => $eventType,
            'severity'   => $severity,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'event_data' => $eventData ? json_encode($eventData, \JSON_UNESCAPED_UNICODE) : null,
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
        ]);
    }

    // Convenience methods for common events
    public function logLoginSuccess(UserInterface $user): void
    {
        $this->log('login_success', 'INFO', $user);
    }

    public function logLoginFailed(string $email, string $reason): void
    {
        $this->log('login_failed', 'WARNING', null, [
            'email' => $email,
            'reason' => $reason
        ]);
    }

    public function log2FASuccess(UserInterface $user, string $method): void
    {
        $this->log('2fa_success', 'INFO', $user, ['method' => $method]);
    }

    public function log2FAFailed(UserInterface $user, string $method, string $reason): void
    {
        $this->log('2fa_failed', 'WARNING', $user, [
            'method' => $method,
            'reason' => $reason
        ]);
    }

    public function logSessionAnomalyDetected(UserInterface $user, array $anomalyDetails): void
    {
        $this->log('session_anomaly_detected', 'CRITICAL', $user, $anomalyDetails);
    }

    public function logAdminTotpVerificationFailed(UserInterface $admin, string $action): void
    {
        $this->log('admin_totp_verification_failed', 'CRITICAL', $admin, [
            'action' => $action
        ]);
    }

    public function logAdminRateLimitExceeded(UserInterface $admin, string $action): void
    {
        $this->log('admin_rate_limit_exceeded', 'WARNING', $admin, [
            'action' => $action
        ]);
    }

    public function logRecoveryCodesRegenerated(UserInterface $user, UserInterface $admin): void
    {
        $adminId = null;
        $adminEmail = null;
        if ($admin instanceof User) {
            $adminId = $admin->getId();
            $adminEmail = $admin->getEmail();
        }
        $this->log('recovery_codes_regenerated_by_admin', 'INFO', $user, [
            'admin_id' => $adminId,
            'admin_email' => $adminEmail
        ]);
    }

    public function logWebAuthnRegistered(UserInterface $user, string $deviceName): void
    {
        $this->log('webauthn_registered', 'INFO', $user, [
            'device_name' => $deviceName
        ]);
    }

    public function logWebAuthnFailed(UserInterface $user, string $reason): void
    {
        $this->log('webauthn_failed', 'WARNING', $user, [
            'reason' => $reason
        ]);
    }

    public function logTrustedDeviceAdded(UserInterface $user): void
    {
        $this->log('trusted_device_added', 'INFO', $user);
    }

    public function logTrustedDeviceRevoked(UserInterface $user): void
    {
        $this->log('trusted_device_revoked', 'INFO', $user);
    }
}
