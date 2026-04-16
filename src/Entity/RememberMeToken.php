<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'remember_me_tokens')]
class RememberMeToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(type: 'string', length: 88, unique: true)]
    private string $series;

    #[ORM\Column(type: 'string', length: 88)]
    private string $tokenValue;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $lastUsed;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private ?string $ipAddress = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $userAgent = null;

    public function __construct(User $user, string $series, string $tokenValue, \DateTimeInterface $lastUsed)
    {
        $this->user = $user;
        $this->series = $series;
        $this->tokenValue = $tokenValue;
        $this->lastUsed = $lastUsed;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function getSeries(): string
    {
        return $this->series;
    }
    public function getTokenValue(): string
    {
        return $this->tokenValue;
    }
    public function setTokenValue(string $val): void
    {
        $this->tokenValue = $val;
    }
    public function getLastUsed(): \DateTimeInterface
    {
        return $this->lastUsed;
    }
    public function setLastUsed(\DateTimeInterface $dt): void
    {
        $this->lastUsed = $dt;
    }
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }
    public function setIpAddress(?string $ip): void
    {
        $this->ipAddress = $ip;
    }
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }
    public function setUserAgent(?string $ua): void
    {
        $this->userAgent = $ua;
    }
}
