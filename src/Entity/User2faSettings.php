<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'user_2fa_settings')]
class User2faSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, unique: true, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $backupCodesCount = 0;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $recoveryCodesLastGenerated = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getBackupCodesCount(): int
    {
        return $this->backupCodesCount;
    }

    public function setBackupCodesCount(int $backupCodesCount): self
    {
        $this->backupCodesCount = $backupCodesCount;
        return $this;
    }

    public function incrementBackupCodesCount(int $amount = 1): self
    {
        $this->backupCodesCount += $amount;
        return $this;
    }

    public function decrementBackupCodesCount(int $amount = 1): self
    {
        $this->backupCodesCount = max(0, $this->backupCodesCount - $amount);
        return $this;
    }

    public function getRecoveryCodesLastGenerated(): ?\DateTimeInterface
    {
        return $this->recoveryCodesLastGenerated;
    }

    public function setRecoveryCodesLastGenerated(?\DateTimeInterface $recoveryCodesLastGenerated): self
    {
        $this->recoveryCodesLastGenerated = $recoveryCodesLastGenerated;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
