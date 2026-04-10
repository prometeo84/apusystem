<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Tenant;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * UC-04: Entidad User — lógica de negocio crítica
 * Cubre: account locking, roles, UUID generation, 2FA flags
 */
class UserTest extends TestCase
{
    private function buildUser(): User
    {
        $tenant = new Tenant();
        $tenant->setName('Test Corp');

        $user = new User();
        $user->setTenant($tenant);
        $user->setEmail('test@example.com');
        $user->setUsername('testuser');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setPassword('hashed_password_placeholder');

        return $user;
    }

    // ---- UUID ----

    #[Test]
    public function uuidIsGeneratedOnConstruct(): void
    {
        $user = $this->buildUser();
        $uuid = $user->getUuid();

        $this->assertNotEmpty($uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
            $uuid,
            'UUID should comply with RFC 4122 v4 format'
        );
    }

    #[Test]
    public function twoUsersHaveDifferentUuids(): void
    {
        $user1 = $this->buildUser();
        $user2 = $this->buildUser();

        $this->assertNotEquals($user1->getUuid(), $user2->getUuid());
    }

    // ---- Roles ----

    #[Test]
    public function defaultRoleIsRoleUser(): void
    {
        $user = $this->buildUser();
        $this->assertContains('ROLE_USER', $user->getRoles());
    }

    #[Test]
    public function adminRoleIncludesRoleUser(): void
    {
        $user = $this->buildUser();
        $user->setRole('ROLE_ADMIN');

        $roles = $user->getRoles();
        $this->assertContains('ROLE_ADMIN', $roles);
        $this->assertContains('ROLE_USER', $roles);
    }

    #[Test]
    public function superAdminRoleIncludesAdminAndUser(): void
    {
        $user = $this->buildUser();
        $user->setRole('ROLE_SUPER_ADMIN');

        $roles = $user->getRoles();
        $this->assertContains('ROLE_SUPER_ADMIN', $roles);
        $this->assertContains('ROLE_ADMIN', $roles);
        $this->assertContains('ROLE_USER', $roles);
    }

    // ---- Account Locking ----

    #[Test]
    public function newUserIsNotLocked(): void
    {
        $user = $this->buildUser();
        $this->assertFalse($user->isAccountLocked());
    }

    #[Test]
    public function fourFailedAttemptsDoNotLockAccount(): void
    {
        $user = $this->buildUser();
        for ($i = 0; $i < 4; $i++) {
            $user->incrementFailedLoginAttempts();
        }
        $this->assertFalse($user->isAccountLocked());
    }

    #[Test]
    public function fiveFailedAttemptsLockAccount(): void
    {
        $user = $this->buildUser();
        for ($i = 0; $i < 5; $i++) {
            $user->incrementFailedLoginAttempts();
        }
        $this->assertTrue($user->isAccountLocked());
    }

    #[Test]
    public function resetFailedAttemptsUnlocksAccount(): void
    {
        $user = $this->buildUser();
        for ($i = 0; $i < 5; $i++) {
            $user->incrementFailedLoginAttempts();
        }
        $this->assertTrue($user->isAccountLocked());

        $user->resetFailedLoginAttempts();
        $this->assertFalse($user->isAccountLocked());
    }

    #[Test]
    public function updateLastLoginResetsLockout(): void
    {
        $user = $this->buildUser();
        for ($i = 0; $i < 5; $i++) {
            $user->incrementFailedLoginAttempts();
        }
        $this->assertTrue($user->isAccountLocked());

        $user->updateLastLogin('192.168.1.1');
        $this->assertFalse($user->isAccountLocked());
    }

    // ---- 2FA ----

    #[Test]
    public function twoFactorEnabledIsFalseByDefault(): void
    {
        $user = $this->buildUser();
        $this->assertFalse($user->isTwoFactorEnabled());
    }

    #[Test]
    public function twoFactorEnabledWhenTotpIsEnabled(): void
    {
        $user = $this->buildUser();
        $user->setTotpEnabled(true);
        $this->assertTrue($user->isTwoFactorEnabled());
    }

    #[Test]
    public function twoFactorEnabledWhenWebAuthnIsEnabled(): void
    {
        $user = $this->buildUser();
        $user->setWebauthnEnabled(true);
        $this->assertTrue($user->isTwoFactorEnabled());
    }

    // ---- isActive ----

    #[Test]
    public function userIsActiveByDefault(): void
    {
        $user = $this->buildUser();
        $this->assertTrue($user->isActive());
    }

    #[Test]
    public function deactivatedUserIsNotActive(): void
    {
        $user = $this->buildUser();
        $user->setIsActive(false);
        $this->assertFalse($user->isActive());
    }

    // ---- fullName ----

    #[Test]
    public function getFullNameConcatenatesFirstAndLast(): void
    {
        $user = $this->buildUser();
        $this->assertSame('John Doe', $user->getFullName());
    }

    // ---- getUserIdentifier ----

    #[Test]
    public function getUserIdentifierReturnsEmail(): void
    {
        $user = $this->buildUser();
        $this->assertSame('test@example.com', $user->getUserIdentifier());
    }
}
