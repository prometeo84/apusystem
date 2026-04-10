<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'tenants')]
class Tenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    private string $slug;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $domain = null;

    #[ORM\Column(type: 'string', length: 500, nullable: true)]
    private ?string $logoUrl = null;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $timezone = null;

    #[ORM\Column(type: 'string', length: 3)]
    private string $currency = 'COP';

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = true;

    #[ORM\Column(type: 'string', length: 50)]
    private string $plan = 'basic';

    #[ORM\Column(type: 'integer')]
    private int $maxUsers = 5;

    #[ORM\Column(type: 'integer')]
    private int $maxProjects = 10;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $planExpiresAt = null;

    #[ORM\Column(type: 'boolean')]
    private bool $planAutoRenew = false;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    #[ORM\OneToMany(mappedBy: 'tenant', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(type: 'string', length: 7, nullable: true)]
    private ?string $themePrimaryColor = null;

    #[ORM\Column(type: 'string', length: 7, nullable: true)]
    private ?string $themeSecondaryColor = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $themeMode = null;

    public function __construct()
    {
        $this->uuid = $this->generateUuid();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->users = new ArrayCollection();
    }

    private function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant RFC 4122
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUuid(): string
    {
        return $this->uuid;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getSlug(): string
    {
        return $this->slug;
    }
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getDomain(): ?string
    {
        return $this->domain;
    }
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }
    public function setLogoUrl(?string $logoUrl): self
    {
        $this->logoUrl = $logoUrl;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getTimezone(): ?string
    {
        return $this->timezone;
    }
    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getCurrency(): string
    {
        return $this->currency;
    }
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function isActive(): bool
    {
        return $this->isActive;
    }
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getPlan(): string
    {
        return $this->plan;
    }
    public function setPlan(string $plan): self
    {
        $this->plan = $plan;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getMaxUsers(): int
    {
        return $this->maxUsers;
    }
    public function setMaxUsers(int $maxUsers): self
    {
        $this->maxUsers = $maxUsers;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getMaxProjects(): int
    {
        return $this->maxProjects;
    }
    public function setMaxProjects(int $maxProjects): self
    {
        $this->maxProjects = $maxProjects;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getPlanExpiresAt(): ?\DateTimeInterface
    {
        return $this->planExpiresAt;
    }
    public function setPlanExpiresAt(?\DateTimeInterface $planExpiresAt): self
    {
        $this->planExpiresAt = $planExpiresAt;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function isPlanAutoRenew(): bool
    {
        return $this->planAutoRenew;
    }
    public function setPlanAutoRenew(bool $planAutoRenew): self
    {
        $this->planAutoRenew = $planAutoRenew;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function isPlanExpired(): bool
    {
        return $this->planExpiresAt && $this->planExpiresAt < new \DateTime();
    }
    public function getDaysUntilExpiration(): ?int
    {
        if (!$this->planExpiresAt) return null;
        $now = new \DateTime();
        return $now->diff($this->planExpiresAt)->days * ($now < $this->planExpiresAt ? 1 : -1);
    }
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getThemePrimaryColor(): ?string
    {
        return $this->themePrimaryColor;
    }

    public function setThemePrimaryColor(?string $color): self
    {
        $this->themePrimaryColor = $color;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getThemeSecondaryColor(): ?string
    {
        return $this->themeSecondaryColor;
    }

    public function setThemeSecondaryColor(?string $color): self
    {
        $this->themeSecondaryColor = $color;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getThemeMode(): ?string
    {
        return $this->themeMode;
    }

    public function setThemeMode(?string $mode): self
    {
        $this->themeMode = $mode;
        $this->updatedAt = new \DateTime();
        return $this;
    }
}
