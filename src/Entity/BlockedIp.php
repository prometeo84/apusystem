<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'blocked_ips')]
#[ORM\Index(columns: ['ip_address'], name: 'idx_ip')]
class BlockedIp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 45, unique: true)]
    private string $ipAddress;

    #[ORM\Column(type: 'integer')]
    private int $riskScore = 0;

    #[ORM\Column(type: 'string', length: 500)]
    private string $reason;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $blockedUntil = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $blockedBy; // manual, automatic, threat_intel

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct(string $ipAddress, string $reason, string $blockedBy = 'automatic')
    {
        $this->ipAddress = $ipAddress;
        $this->reason = $reason;
        $this->blockedBy = $blockedBy;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function isBlocked(): bool
    {
        if ($this->blockedUntil === null) {
            return true; // Permanent block
        }
        return $this->blockedUntil > new \DateTime();
    }

    // Getters and Setters
    public function getId(): ?int { return $this->id; }
    public function getIpAddress(): string { return $this->ipAddress; }
    public function getRiskScore(): int { return $this->riskScore; }
    public function setRiskScore(int $riskScore): self { 
        $this->riskScore = $riskScore; 
        $this->updatedAt = new \DateTime();
        return $this; 
    }
    public function getReason(): string { return $this->reason; }
    public function getBlockedUntil(): ?\DateTimeInterface { return $this->blockedUntil; }
    public function setBlockedUntil(?\DateTimeInterface $blockedUntil): self { 
        $this->blockedUntil = $blockedUntil; 
        $this->updatedAt = new \DateTime();
        return $this; 
    }
    public function getBlockedBy(): string { return $this->blockedBy; }
    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
    public function getUpdatedAt(): \DateTimeInterface { return $this->updatedAt; }
}
