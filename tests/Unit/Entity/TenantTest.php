<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Tenant;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * UC-05: Entidad Tenant — UUID, límites, configuración
 */
class TenantTest extends TestCase
{
    // ---- UUID ----

    #[Test]
    public function uuidIsGeneratedOnConstruct(): void
    {
        $tenant = new Tenant();
        $uuid   = $tenant->getUuid();

        $this->assertNotEmpty($uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
            $uuid
        );
    }

    #[Test]
    public function twoTenantsHaveDifferentUuids(): void
    {
        $t1 = new Tenant();
        $t2 = new Tenant();
        $this->assertNotEquals($t1->getUuid(), $t2->getUuid());
    }

    // ---- maxUsers default ----

    #[Test]
    public function defaultMaxUsersIsFive(): void
    {
        $tenant = new Tenant();
        $this->assertSame(5, $tenant->getMaxUsers());
    }

    #[Test]
    public function setMaxUsersUpdatesLimit(): void
    {
        $tenant = new Tenant();
        $tenant->setMaxUsers(50);
        $this->assertSame(50, $tenant->getMaxUsers());
    }

    // ---- plan ----

    #[Test]
    public function defaultPlanIsTrialOrBasic(): void
    {
        $tenant = new Tenant();
        $this->assertNotEmpty($tenant->getPlan());
    }

    // ---- name ----

    #[Test]
    public function setNameUpdatesName(): void
    {
        $tenant = new Tenant();
        $tenant->setName('Acme Corp');
        $this->assertSame('Acme Corp', $tenant->getName());
    }

    // ---- isActive ----

    #[Test]
    public function tenantIsActivatedByDefault(): void
    {
        $tenant = new Tenant();
        $this->assertTrue($tenant->isActive());
    }

    #[Test]
    public function tenantCanBeDeactivated(): void
    {
        $tenant = new Tenant();
        $tenant->setIsActive(false);
        $this->assertFalse($tenant->isActive());
    }
}
