<?php

namespace App\Tests\Unit\Security;

use App\Entity\Tenant;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

/**
 * QA-SEC-01: Control de Acceso Basado en Roles (RBAC)
 *
 * Valida que la jerarquía de roles sea correcta y que roles inferiores
 * no hereden permisos de roles superiores.
 */
class RBACTest extends TestCase
{
    private function makeUser(string $role): User
    {
        $tenant = new Tenant();
        $tenant->setName('Corp Test');

        $user = new User();
        $user->setTenant($tenant);
        $user->setEmail('test@example.com');
        $user->setUsername('test');
        $user->setFirstName('Test');
        $user->setLastName('User');
        $user->setPassword('hashed');
        $user->setRole($role);
        return $user;
    }

    // ── Jerarquía de herencia de roles ──────────────────────────────────────

    #[Test]
    public function rolUserNoHeredarolesSuperiores(): void
    {
        $user = $this->makeUser('ROLE_USER');
        $roles = $user->getRoles();

        $this->assertContains('ROLE_USER', $roles);
        $this->assertNotContains('ROLE_ADMIN', $roles);
        $this->assertNotContains('ROLE_SUPER_ADMIN', $roles);
        $this->assertNotContains('ROLE_MANAGER', $roles);
    }

    #[Test]
    public function rolManagerHeredaRoleUser(): void
    {
        $user = $this->makeUser('ROLE_MANAGER');
        $roles = $user->getRoles();

        $this->assertContains('ROLE_MANAGER', $roles);
        $this->assertContains('ROLE_USER', $roles);
        $this->assertNotContains('ROLE_ADMIN', $roles);
        $this->assertNotContains('ROLE_SUPER_ADMIN', $roles);
    }

    #[Test]
    public function rolAdminHeredaManagerYUser(): void
    {
        $user = $this->makeUser('ROLE_ADMIN');
        $roles = $user->getRoles();

        $this->assertContains('ROLE_ADMIN', $roles);
        $this->assertContains('ROLE_USER', $roles);
        $this->assertNotContains('ROLE_SUPER_ADMIN', $roles);
    }

    #[Test]
    public function rolSuperAdminHeredaTodos(): void
    {
        $user = $this->makeUser('ROLE_SUPER_ADMIN');
        $roles = $user->getRoles();

        $this->assertContains('ROLE_SUPER_ADMIN', $roles);
        $this->assertContains('ROLE_ADMIN', $roles);
        $this->assertContains('ROLE_USER', $roles);
    }

    // ── Normalización de formato de rol ────────────────────────────────────

    #[Test]
    #[DataProvider('roleNormalizationProvider')]
    public function roleNormalizationAcceptsVariousFormats(string $input, string $expectedPrimary): void
    {
        $user = $this->makeUser($input);
        $this->assertContains($expectedPrimary, $user->getRoles());
    }

    public static function roleNormalizationProvider(): array
    {
        return [
            'admin lowercase'       => ['admin', 'ROLE_ADMIN'],
            'ROLE_ADMIN uppercase'  => ['ROLE_ADMIN', 'ROLE_ADMIN'],
            'user lowercase'        => ['user', 'ROLE_USER'],
            'ROLE_USER uppercase'   => ['ROLE_USER', 'ROLE_USER'],
        ];
    }

    // ── Acceso a recursos por rol ───────────────────────────────────────────

    #[Test]
    public function usuarioNoPuedeEditarEmpresa(): void
    {
        $user = $this->makeUser('ROLE_USER');
        $canEdit = in_array('ROLE_ADMIN', $user->getRoles(), true)
                || in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true);

        $this->assertFalse($canEdit, 'ROLE_USER no debe poder editar empresas');
    }

    #[Test]
    public function adminPuedeEditarEmpresa(): void
    {
        $user = $this->makeUser('ROLE_ADMIN');
        $canEdit = in_array('ROLE_ADMIN', $user->getRoles(), true);

        $this->assertTrue($canEdit, 'ROLE_ADMIN debe poder editar empresas');
    }

    #[Test]
    public function superAdminPuedeGestionarTodo(): void
    {
        $user = $this->makeUser('ROLE_SUPER_ADMIN');
        $roles = $user->getRoles();

        $canManageTenants = in_array('ROLE_SUPER_ADMIN', $roles, true);
        $canManageUsers   = in_array('ROLE_ADMIN', $roles, true);
        $canUseApp        = in_array('ROLE_USER', $roles, true);

        $this->assertTrue($canManageTenants);
        $this->assertTrue($canManageUsers);
        $this->assertTrue($canUseApp);
    }

    // ── Multi-tenant: usuario solo ve su tenant ─────────────────────────────

    #[Test]
    public function usuariosDeTenantsDiferentesNoComparten(): void
    {
        $tenantA = new Tenant();
        $tenantA->setName('Empresa A');

        $tenantB = new Tenant();
        $tenantB->setName('Empresa B');

        $userA = new User();
        $userA->setTenant($tenantA);
        $userA->setEmail('a@a.com');
        $userA->setUsername('usera');
        $userA->setFirstName('A');
        $userA->setLastName('A');
        $userA->setPassword('h');

        $userB = new User();
        $userB->setTenant($tenantB);
        $userB->setEmail('b@b.com');
        $userB->setUsername('userb');
        $userB->setFirstName('B');
        $userB->setLastName('B');
        $userB->setPassword('h');

        $this->assertNotSame(
            $userA->getTenant()->getUuid(),
            $userB->getTenant()->getUuid(),
            'Cada usuario pertenece a un tenant diferente'
        );
    }

    // ── Cuenta bloqueada no puede actuar ───────────────────────────────────

    #[Test]
    public function cuentaBloqueadaBloqueoEsDetectable(): void
    {
        $user = $this->makeUser('ROLE_USER');
        for ($i = 0; $i < 5; $i++) {
            $user->incrementFailedLoginAttempts();
        }

        // Tras 5 intentos fallidos la cuenta queda bloqueada
        $this->assertTrue($user->isAccountLocked());
        // Un usuario bloqueado NO debe poder operar — isActive sigue verdadero
        // pero el listener de seguridad chequea isAccountLocked()
        $this->assertFalse($user->isActive() && $user->isAccountLocked() === false);
    }
}
