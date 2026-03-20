<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'login_sessions')]
#[ORM\Index(columns: ['session_id'], name: 'idx_session_id')]
#[ORM\Index(columns: ['user_id', 'is_active'], name: 'idx_user_active')]
class LoginSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(type: 'string', length: 128, unique: true)]
    private string $sessionId;

    #[ORM\Column(type: 'string', length: 45)]
    private string $ipAddress;

    #[ORM\Column(type: 'text')]
    private string $userAgent;

    #[ORM\Column(type: 'string', length: 64)]
    private string $fingerprint;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $lastActivityAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $expiresAt;

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = true;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function __construct(
        User $user,
        string $sessionId,
        string $ipAddress,
        string $userAgent,
        int $lifetimeSeconds = 3600
    ) {
        $this->user = $user;
        $this->sessionId = $sessionId;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->fingerprint = $this->generateFingerprint($ipAddress, $userAgent);
        $this->createdAt = new \DateTime();
        $this->lastActivityAt = new \DateTime();
        $this->expiresAt = new \DateTime('+' . $lifetimeSeconds . ' seconds');
    }

    private function generateFingerprint(string $ipAddress, string $userAgent): string
    {
        return hash('sha256', $ipAddress . '|' . $userAgent);
    }

    public function updateActivity(): void
    {
        $this->lastActivityAt = new \DateTime();
    }

    public function isExpired(): bool
    {
        return $this->expiresAt < new \DateTime();
    }

    public function invalidate(): void
    {
        $this->isActive = false;
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getUser(): User { return $this->user; }
    public function getSessionId(): string { return $this->sessionId; }
    public function getIpAddress(): string { return $this->ipAddress; }
    public function getUserAgent(): string { return $this->userAgent; }
    public function getFingerprint(): string { return $this->fingerprint; }
    public function getLastActivityAt(): \DateTimeInterface { return $this->lastActivityAt; }
    public function getExpiresAt(): \DateTimeInterface { return $this->expiresAt; }
    public function isActive(): bool { return $this->isActive; }
    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
}
