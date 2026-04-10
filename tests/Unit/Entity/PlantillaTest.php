<?php

namespace App\Tests\Unit\Entity;

use App\Entity\APUItem;
use App\Entity\APUMaterial;
use App\Entity\Plantilla;
use App\Entity\PlantillaRubro;
use App\Entity\Projects;
use App\Entity\Rubro;
use App\Entity\Tenant;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Tests unitarios para Plantilla y PlantillaRubro.
 * Cubre: UC-PL1 (Estructura), UC-PL2 (Totales), UC-PL3 (PlantillaRubro)
 */
class PlantillaTest extends TestCase
{
    private function buildTenant(): Tenant
    {
        $tenant = new Tenant();
        $tenant->setName('Test Corp');
        return $tenant;
    }

    private function buildProject(Tenant $tenant): Projects
    {
        $project = new Projects();
        $project->setTenant($tenant);
        $project->setNombre('Edificio Residencial A');
        $project->setCodigo('P-2026-001');
        $project->setEstado('activo');
        return $project;
    }

    private function buildRubro(Tenant $tenant): Rubro
    {
        $rubro = new Rubro();
        $rubro->setTenant($tenant);
        $rubro->setCodigo('R-001');
        $rubro->setNombre('Excavación');
        $rubro->setUnidad('m³');
        $rubro->setTipo('personalizado');
        return $rubro;
    }

    private function buildAPUWithMaterialCost(Tenant $tenant, float $costPerUnit): APUItem
    {
        $item = new APUItem();
        $item->setTenant($tenant);
        $item->setDescription('APU Test');
        $item->setUnit('m³');
        $item->setKhu('1.0');
        $item->setRendimientoUh('1.0');

        $mat = new APUMaterial();
        $mat->setDescripcion('Material Test');
        $mat->setUnidad('u');
        $mat->setCantidad('1.0');
        $mat->setPrecioUnitario((string)$costPerUnit);
        $item->addMaterial($mat);
        $item->calculateCosts();

        return $item;
    }

    // ---- Plantilla ----

    #[Test]
    public function plantillaSeCreaSinRubros(): void
    {
        $tenant  = $this->buildTenant();
        $project = $this->buildProject($tenant);

        $plantilla = new Plantilla();
        $plantilla->setTenant($tenant);
        $plantilla->setProyecto($project);
        $plantilla->setNombre('Presupuesto Fondaciones');

        $this->assertNull($plantilla->getId());
        $this->assertCount(0, $plantilla->getPlantillaRubros());
    }

    #[Test]
    public function getTotalPresupuestoEsCeroCuandoNoHayRubros(): void
    {
        $tenant  = $this->buildTenant();
        $project = $this->buildProject($tenant);

        $plantilla = new Plantilla();
        $plantilla->setTenant($tenant);
        $plantilla->setProyecto($project);
        $plantilla->setNombre('Vacía');

        $this->assertSame(0.0, $plantilla->getTotalPresupuesto());
    }

    #[Test]
    public function activaEsTruePorDefecto(): void
    {
        $plantilla = new Plantilla();
        $this->assertTrue($plantilla->isActiva());
    }

    #[Test]
    public function createdAtSeInicializaEnConstructor(): void
    {
        $plantilla = new Plantilla();
        $this->assertInstanceOf(\DateTimeInterface::class, $plantilla->getCreatedAt());
    }

    // ---- PlantillaRubro ----

    #[Test]
    public function plantillaRubroCalculaTotalCostoCorrectamente(): void
    {
        $tenant  = $this->buildTenant();
        $rubro   = $this->buildRubro($tenant);
        $apu     = $this->buildAPUWithMaterialCost($tenant, 50.0); // costo unitario = 50

        $pr = new PlantillaRubro();
        $pr->setRubro($rubro);
        $pr->setApuItem($apu);
        $pr->setCantidad('3.0'); // 3 unidades

        // getTotalCosto = cantidad * totalCost = 3 * 50 = 150
        $this->assertEqualsWithDelta(150.0, $pr->getTotalCosto(), 0.001);
    }

    #[Test]
    public function plantillaRubroTotalCostoCeroCuandoNoHayApu(): void
    {
        $tenant = $this->buildTenant();
        $rubro  = $this->buildRubro($tenant);

        $pr = new PlantillaRubro();
        $pr->setRubro($rubro);
        $pr->setCantidad('5.0');
        // Sin APU

        $this->assertSame(0.0, $pr->getTotalCosto());
    }

    #[Test]
    public function plantillaRubroCantidadDefaultEsUno(): void
    {
        $pr = new PlantillaRubro();
        $this->assertSame('1.0000', $pr->getCantidad());
    }

    #[Test]
    public function plantillaRubroOrdenDefaultEsCero(): void
    {
        $pr = new PlantillaRubro();
        $this->assertSame(0, $pr->getOrden());
    }

    #[Test]
    public function plantillaRubroGetPrecioUnitarioCuandoTieneApu(): void
    {
        $tenant = $this->buildTenant();
        $rubro  = $this->buildRubro($tenant);
        $apu    = $this->buildAPUWithMaterialCost($tenant, 75.0);

        $pr = new PlantillaRubro();
        $pr->setRubro($rubro);
        $pr->setApuItem($apu);
        $pr->setCantidad('2.0');

        $this->assertEqualsWithDelta(75.0, $pr->getPrecioUnitario(), 0.001);
    }

    // ---- Integración Plantilla + PlantillaRubros ----

    #[Test]
    public function multiplasPlantillaRubrosCalculanTotalesIndependientes(): void
    {
        $tenant = $this->buildTenant();

        // Dos PlantillaRubros independientes sumando sus costos
        $total = 0.0;
        for ($i = 1; $i <= 2; $i++) {
            $rubro = new Rubro();
            $rubro->setTenant($tenant);
            $rubro->setCodigo('R-00' . $i);
            $rubro->setNombre('Rubro ' . $i);
            $rubro->setUnidad('m²');
            $rubro->setTipo('general');

            $apu = $this->buildAPUWithMaterialCost($tenant, 100.0); // 100 por unidad

            $pr = new PlantillaRubro();
            $pr->setRubro($rubro);
            $pr->setApuItem($apu);
            $pr->setCantidad('5.0'); // 5 unidades => 500 cada uno

            $total += $pr->getTotalCosto();
        }

        // total = 500 + 500 = 1000
        $this->assertEqualsWithDelta(1000.0, $total, 0.001);
    }
}
