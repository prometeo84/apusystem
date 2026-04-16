<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Item;
use App\Entity\Tenant;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Tests unitarios para la entidad Rubro.
 * Cubre: UC-R1 (Creación), UC-R2 (Campos), UC-R3 (Tipos válidos)
 */
class RubroTest extends TestCase
{
    private function buildTenant(): Tenant
    {
        $tenant = new Tenant();
        $tenant->setName('Test Corp');
        return $tenant;
    }

    private function buildRubro(string $tipo = 'personalizado'): Item
    {
        $rubro = new Item();
        $rubro->setTenant($this->buildTenant());
        $rubro->setCode('R-001');
        $rubro->setName('Excavación manual');
        $rubro->setUnit('m³');
        $rubro->setType($tipo);
        return $rubro;
    }

    // ---- Creación básica ----

    #[Test]
    public function rubroSeCreaSinId(): void
    {
        $rubro = $this->buildRubro();
        $this->assertNull($rubro->getId());
    }

    #[Test]
    public function rubroTieneActivoTrueByDefault(): void
    {
        $rubro = $this->buildRubro();
        $this->assertTrue($rubro->isActive());
    }

    #[Test]
    public function rubroAceptaTipoPersonalizado(): void
    {
        $rubro = $this->buildRubro('personalizado');
        $this->assertSame('personalizado', $rubro->getType());
    }

    #[Test]
    public function rubroAceptaTipoGeneral(): void
    {
        $rubro = $this->buildRubro('general');
        $this->assertSame('general', $rubro->getType());
    }

    // ---- Getters / Setters ----

    #[Test]
    public function getterSetterFuncionanCorrectamente(): void
    {
        $rubro = $this->buildRubro();

        $this->assertSame('R-001', $rubro->getCode());
        $this->assertSame('Excavación manual', $rubro->getName());
        $this->assertSame('m³', $rubro->getUnit());

        $rubro->setCode('R-002');
        $rubro->setName('Hormigón f\'c=210 kg/cm²');
        $rubro->setUnit('m³');
        $rubro->setActive(false);

        $this->assertSame('R-002', $rubro->getCode());
        $this->assertSame('Hormigón f\'c=210 kg/cm²', $rubro->getName());
        $this->assertFalse($rubro->isActive());
    }

    #[Test]
    public function descripcionEsOpcional(): void
    {
        $rubro = $this->buildRubro();
        $this->assertNull($rubro->getDescription());

        $rubro->setDescription('Rubro de excavación en suelo normal');
        $this->assertSame('Rubro de excavación en suelo normal', $rubro->getDescription());
    }

    // ---- Timestamps ----

    #[Test]
    public function createdAtSeInicializaEnConstructor(): void
    {
        $rubro = $this->buildRubro();
        $this->assertInstanceOf(\DateTimeInterface::class, $rubro->getCreatedAt());
    }

    #[Test]
    public function updatedAtSeInicializaEnConstructor(): void
    {
        $rubro = $this->buildRubro();
        $this->assertInstanceOf(\DateTimeInterface::class, $rubro->getUpdatedAt());
    }
}
