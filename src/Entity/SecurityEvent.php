<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'security_events')]
#[ORM\Index(columns: ['event_type'], name: 'idx_event_type')]
#[ORM\Index(columns: ['user_id'], name: 'idx_user_id')]
#[ORM\Index(columns: ['created_at'], name: 'idx_created_at')]
class SecurityEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private ?Tenant $tenant = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $user = null;

    #[ORM\Column(type: 'string', length: 100)]
    private string $eventType;

    #[ORM\Column(type: 'string', length: 20)]
    private string $severity = 'INFO'; // INFO, WARNING, CRITICAL

    #[ORM\Column(type: 'string', length: 45)]
    private string $ipAddress;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $userAgent = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $eventData = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function __construct(
        string $eventType,
        string $ipAddress,
        string $severity = 'INFO',
        ?User $user = null,
        ?Tenant $tenant = null
    ) {
        $this->eventType = $eventType;
        $this->ipAddress = $ipAddress;
        $this->severity = $severity;
        $this->user = $user;
        $this->tenant = $tenant;
        $this->createdAt = new \DateTime();
    }

    // Getters and Setters
    public function getId(): ?int { return $this->id; }
    public function getTenant(): ?Tenant { return $this->tenant; }
    public function getUser(): ?User { return $this->user; }
    public function getEventType(): string { return $this->eventType; }
    public function getSeverity(): string { return $this->severity; }
    public function getIpAddress(): string { return $this->ipAddress; }
    public function getUserAgent(): ?string { return $this->userAgent; }
    public function setUserAgent(?string $userAgent): self { $this->userAgent = $userAgent; return $this; }
    public function getEventData(): ?array { return $this->eventData; }
    public function setEventData(?array $eventData): self { $this->eventData = $eventData; return $this; }
    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
}
