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
        $rubro->setCodigo('R-001');
        $rubro->setNombre('Excavación manual');
        $rubro->setUnidad('m³');
        $rubro->setTipo($tipo);
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
        $this->assertTrue($rubro->isActivo());
    }

    #[Test]
    public function rubroAceptaTipoPersonalizado(): void
    {
        $rubro = $this->buildRubro('personalizado');
        $this->assertSame('personalizado', $rubro->getTipo());
    }

    #[Test]
    public function rubroAceptaTipoGeneral(): void
    {
        $rubro = $this->buildRubro('general');
        $this->assertSame('general', $rubro->getTipo());
    }

    // ---- Getters / Setters ----

    #[Test]
    public function getterSetterFuncionanCorrectamente(): void
    {
        $rubro = $this->buildRubro();

        $this->assertSame('R-001', $rubro->getCodigo());
        $this->assertSame('Excavación manual', $rubro->getNombre());
        $this->assertSame('m³', $rubro->getUnidad());

        $rubro->setCodigo('R-002');
        $rubro->setNombre('Hormigón f\'c=210 kg/cm²');
        $rubro->setUnidad('m³');
        $rubro->setActivo(false);

        $this->assertSame('R-002', $rubro->getCodigo());
        $this->assertSame('Hormigón f\'c=210 kg/cm²', $rubro->getNombre());
        $this->assertFalse($rubro->isActivo());
    }

    #[Test]
    public function descripcionEsOpcional(): void
    {
        $rubro = $this->buildRubro();
        $this->assertNull($rubro->getDescripcion());

        $rubro->setDescripcion('Rubro de excavación en suelo normal');
        $this->assertSame('Rubro de excavación en suelo normal', $rubro->getDescripcion());
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
