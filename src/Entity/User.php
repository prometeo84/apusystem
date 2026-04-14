<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(
    name: 'users',
    uniqueConstraints: [
        new \Doctrine\ORM\Mapping\UniqueConstraint(name: 'uuid', columns: ['uuid']),
        new \Doctrine\ORM\Mapping\UniqueConstraint(name: 'unique_username_per_tenant', columns: ['tenant_id', 'username'])
    ]
)]
#[ORM\Index(name: 'unique_username_per_tenant', columns: ['tenant_id', 'username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Tenant::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Tenant $tenant;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 100)]
    private string $username;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'string', length: 100)]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 100)]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', length: 20)]
    private string $role = 'user';

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = true;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $emailVerifiedAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lastLoginAt = null;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    private ?string $lastLoginIp = null;

    #[ORM\Column(type: 'integer')]
    private int $failedLoginAttempts = 0;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lockedUntil = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $passwordChangedAt = null;

    #[ORM\Column(type: 'boolean')]
    private bool $requirePasswordChange = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    // 2FA fields - will be moved to separate entity but kept here for quick access
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $totpSecret = null;

    #[ORM\Column(type: 'boolean')]
    private bool $totpEnabled = false;

    #[ORM\Column(type: 'boolean')]
    private bool $webauthnEnabled = false;

    // Personalization fields
    #[ORM\Column(type: 'string', length: 5)]
    private string $locale = 'es';

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $timezone = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(type: 'string', length: 7, nullable: true)]
    private ?string $themePrimaryColor = '#667eea';

    #[ORM\Column(type: 'string', length: 7, nullable: true)]
    private ?string $themeSecondaryColor = '#764ba2';

    #[ORM\Column(type: 'string', length: 10)]
    private string $themeMode = 'light';

    public function __construct()
    {
        $this->uuid = $this->generateUuid();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    private function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant RFC 4122
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    // UserInterface methods
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];

        if ($this->role === 'manager') {
            $roles[] = 'ROLE_MANAGER';
        } elseif ($this->role === 'admin') {
            $roles[] = 'ROLE_ADMIN';
        } elseif ($this->role === 'super_admin') {
            $roles[] = 'ROLE_SUPER_ADMIN';
            $roles[] = 'ROLE_ADMIN';
        }

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // Nothing to erase
    }

    public function isCredentialsNonExpired(): bool
    {
        return !$this->isAccountLocked();
    }

    // PasswordAuthenticatedUserInterface
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        $this->passwordChangedAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        return $this;
    }

    // Account locking
    public function isAccountLocked(): bool
    {
        if ($this->lockedUntil === null) {
            return false;
        }
        return $this->lockedUntil > new \DateTime();
    }

    public function incrementFailedLoginAttempts(): void
    {
        $this->failedLoginAttempts++;
        $this->updatedAt = new \DateTime();

        // Lock after 5 failed attempts for 15 minutes
        if ($this->failedLoginAttempts >= 5) {
            $this->lockedUntil = new \DateTime('+15 minutes');
        }
    }

    public function resetFailedLoginAttempts(): void
    {
        $this->failedLoginAttempts = 0;
        $this->lockedUntil = null;
        $this->updatedAt = new \DateTime();
    }

    public function updateLastLogin(string $ipAddress): void
    {
        $this->lastLoginAt = new \DateTime();
        $this->lastLoginIp = $ipAddress;
        $this->resetFailedLoginAttempts();
    }

    // 2FA methods
    public function isTwoFactorEnabled(): bool
    {
        return $this->totpEnabled || $this->webauthnEnabled;
    }

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTenant(): Tenant
    {
        return $this->tenant;
    }
    public function setTenant(Tenant $tenant): self
    {
        $this->tenant = $tenant;
        return $this;
    }
    public function getUuid(): string
    {
        return $this->uuid;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function setRole(string $role): self
    {
        // Normalize: accept both 'ROLE_ADMIN' and 'admin' formats
        $map = [
            'ROLE_USER'        => 'user',
            'ROLE_MANAGER'     => 'manager',
            'ROLE_ADMIN'       => 'admin',
            'ROLE_SUPER_ADMIN' => 'super_admin',
        ];
        $this->role = $map[$role] ?? strtolower(str_replace('ROLE_', '', $role));
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
    public function getEmailVerifiedAt(): ?\DateTimeInterface
    {
        return $this->emailVerifiedAt;
    }
    public function setEmailVerifiedAt(?\DateTimeInterface $emailVerifiedAt): self
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
        return $this;
    }
    public function getLastLoginAt(): ?\DateTimeInterface
    {
        return $this->lastLoginAt;
    }
    public function getLastLoginIp(): ?string
    {
        return $this->lastLoginIp;
    }
    public function getFailedLoginAttempts(): int
    {
        return $this->failedLoginAttempts;
    }

    public function setFailedLoginAttempts(int $failedLoginAttempts): self
    {
        $this->failedLoginAttempts = $failedLoginAttempts;
        return $this;
    }

    public function getLockedUntil(): ?\DateTimeInterface
    {
        return $this->lockedUntil;
    }

    public function setLockedUntil(?\DateTimeInterface $lockedUntil): self
    {
        $this->lockedUntil = $lockedUntil;
        return $this;
    }

    public function setAccountLockedUntil(?\DateTimeInterface $lockedUntil): self
    {
        return $this->setLockedUntil($lockedUntil);
    }

    public function getPasswordChangedAt(): ?\DateTimeInterface
    {
        return $this->passwordChangedAt;
    }

    public function setPasswordChangedAt(?\DateTimeInterface $passwordChangedAt): self
    {
        $this->passwordChangedAt = $passwordChangedAt;
        return $this;
    }
    public function requiresPasswordChange(): bool
    {
        return $this->requirePasswordChange;
    }
    public function setRequirePasswordChange(bool $requirePasswordChange): self
    {
        $this->requirePasswordChange = $requirePasswordChange;
        return $this;
    }
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
    public function getTotpSecret(): ?string
    {
        return $this->totpSecret;
    }
    public function setTotpSecret(?string $totpSecret): self
    {
        $this->totpSecret = $totpSecret;
        return $this;
    }
    public function isTotpEnabled(): bool
    {
        return $this->totpEnabled;
    }
    public function setTotpEnabled(bool $totpEnabled): self
    {
        $this->totpEnabled = $totpEnabled;
        return $this;
    }
    public function isWebauthnEnabled(): bool
    {
        return $this->webauthnEnabled;
    }
    public function setWebauthnEnabled(bool $webauthnEnabled): self
    {
        $this->webauthnEnabled = $webauthnEnabled;
        return $this;
    }

    // Personalization getters and setters
    public function getLocale(): string
    {
        return $this->locale;
    }
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;
        $this->updatedAt = new \DateTime();
        return $this;
    }

    public function getThemePrimaryColor(): ?string
    {
        return $this->themePrimaryColor;
    }
    public function setThemePrimaryColor(?string $themePrimaryColor): self
    {
        $this->themePrimaryColor = $themePrimaryColor;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getThemeSecondaryColor(): ?string
    {
        return $this->themeSecondaryColor;
    }
    public function setThemeSecondaryColor(?string $themeSecondaryColor): self
    {
        $this->themeSecondaryColor = $themeSecondaryColor;
        $this->updatedAt = new \DateTime();
        return $this;
    }
    public function getThemeMode(): string
    {
        return $this->themeMode;
    }
    public function setThemeMode(string $themeMode): self
    {
        $this->themeMode = $themeMode;
        $this->updatedAt = new \DateTime();
        return $this;
    }
}
