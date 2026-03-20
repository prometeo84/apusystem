<?php

namespace App\Service;

use App\Entity\SecurityEvent;
use App\Entity\User;
use App\Entity\Tenant;
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
        ?User $user = null,
        ?array $eventData = null
    ): void {
        $request = $this->requestStack->getCurrentRequest();
        $ipAddress = $request ? $request->getClientIp() : '0.0.0.0';
        $userAgent = $request ? $request->headers->get('User-Agent') : null;

        $tenant = $user ? $user->getTenant() : null;

        $event = new SecurityEvent($eventType, $ipAddress, $severity, $user, $tenant);
        
        if ($userAgent) {
            $event->setUserAgent($userAgent);
        }
        
        if ($eventData) {
            $event->setEventData($eventData);
        }

        $this->em->persist($event);
        $this->em->flush();
    }

    // Convenience methods for common events
    public function logLoginSuccess(User $user): void
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

    public function log2FASuccess(User $user, string $method): void
    {
        $this->log('2fa_success', 'INFO', $user, ['method' => $method]);
    }

    public function log2FAFailed(User $user, string $method, string $reason): void
    {
        $this->log('2fa_failed', 'WARNING', $user, [
            'method' => $method,
            'reason' => $reason
        ]);
    }

    public function logSessionAnomalyDetected(User $user, array $anomalyDetails): void
    {
        $this->log('session_anomaly_detected', 'CRITICAL', $user, $anomalyDetails);
    }

    public function logAdminTotpVerificationFailed(User $admin, string $action): void
    {
        $this->log('admin_totp_verification_failed', 'CRITICAL', $admin, [
            'action' => $action
        ]);
    }

    public function logAdminRateLimitExceeded(User $admin, string $action): void
    {
        $this->log('admin_rate_limit_exceeded', 'WARNING', $admin, [
            'action' => $action
        ]);
    }

    public function logRecoveryCodesRegenerated(User $user, User $admin): void
    {
        $this->log('recovery_codes_regenerated_by_admin', 'INFO', $user, [
            'admin_id' => $admin->getId(),
            'admin_email' => $admin->getEmail()
        ]);
    }

    public function logWebAuthnRegistered(User $user, string $deviceName): void
    {
        $this->log('webauthn_registered', 'INFO', $user, [
            'device_name' => $deviceName
        ]);
    }

    public function logWebAuthnFailed(User $user, string $reason): void
    {
        $this->log('webauthn_failed', 'WARNING', $user, [
            'reason' => $reason
        ]);
    }

    public function logTrustedDeviceAdded(User $user): void
    {
        $this->log('trusted_device_added', 'INFO', $user);
    }

    public function logTrustedDeviceRevoked(User $user): void
    {
        $this->log('trusted_device_revoked', 'INFO', $user);
    }
}
