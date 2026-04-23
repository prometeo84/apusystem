<?php

namespace App\Tests\Unit\Entity;

use App\Entity\APUItem;
use App\Entity\APUMaterial;
use App\Entity\Template;
use App\Entity\TemplateItem;
use App\Entity\Projects;
use App\Entity\Item;
use App\Entity\Tenant;
use App\Entity\User;
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
        $project->setName('Edificio Residencial A');
        $project->setCode('P-2026-001');
        $project->setStatus('activo');
        return $project;
    }

    private function buildRubro(Tenant $tenant): Item
    {
        $rubro = new Item();
        $rubro->setTenant($tenant);
        $rubro->setCode('R-001');
        $rubro->setName('Excavación');
        $rubro->setUnit('m³');
        $rubro->setType('personalizado');
        return $rubro;
    }

    private function buildAPUWithMaterialCost(Tenant $tenant, float $costPerUnit): APUItem
    {
        $item = new APUItem();
        $item->setTenant($tenant);
        $item->setDescription('APU Test');
        $item->setUnit('m³');
        $item->setKhu('1.0');
        $item->setProductivityUh('1.0');

        $mat = new APUMaterial();
        $mat->setQuantity('1.0');
        $mat->setUnitPrice((string)$costPerUnit);
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

        $plantilla = new Template();
        $plantilla->setTenant($tenant);
        $plantilla->setProject($project);
        $plantilla->setName('Presupuesto Fondaciones');

        $this->assertNull($plantilla->getId());
        $this->assertCount(0, $plantilla->getItems());
    }

    #[Test]
    public function createdByEsNullPorDefectoYSetterFunciona(): void
    {
        $plantilla = new Template();
        $this->assertNull($plantilla->getCreatedBy());

        $user = new User();
        $plantilla->setCreatedBy($user);
        $this->assertSame($user, $plantilla->getCreatedBy());
    }

    #[Test]
    public function getTotalPresupuestoEsCeroCuandoNoHayRubros(): void
    {
        $tenant  = $this->buildTenant();
        $project = $this->buildProject($tenant);

        $plantilla = new Template();
        $plantilla->setTenant($tenant);
        $plantilla->setProject($project);
        $plantilla->setName('Vacía');

        $this->assertSame(0.0, $plantilla->getTotalBudget());
    }

    #[Test]
    public function activaEsTruePorDefecto(): void
    {
        $plantilla = new Template();
        $this->assertTrue($plantilla->isActive());
    }

    #[Test]
    public function createdAtSeInicializaEnConstructor(): void
    {
        $plantilla = new Template();
        $this->assertInstanceOf(\DateTimeInterface::class, $plantilla->getCreatedAt());
    }

    // ---- PlantillaRubro ----

    #[Test]
    public function plantillaRubroCalculaTotalCostoCorrectamente(): void
    {
        $tenant  = $this->buildTenant();
        $rubro   = $this->buildRubro($tenant);
        $apu     = $this->buildAPUWithMaterialCost($tenant, 50.0); // costo unitario = 50

        $pr = new TemplateItem();
        $pr->setItem($rubro);
        $pr->setApuItem($apu);
        $pr->setQuantity('3.0'); // 3 unidades

        // getTotalCosto = cantidad * totalCost = 3 * 50 = 150
        $this->assertEqualsWithDelta(150.0, $pr->getTotalCost(), 0.001);
    }

    #[Test]
    public function plantillaRubroTotalCostoCeroCuandoNoHayApu(): void
    {
        $tenant = $this->buildTenant();
        $rubro  = $this->buildRubro($tenant);

        $pr = new TemplateItem();
        $pr->setItem($rubro);
        $pr->setQuantity('5.0');
        // Sin APU

        $this->assertSame(0.0, $pr->getTotalCost());
    }

    #[Test]
    public function plantillaRubroCantidadDefaultEsUno(): void
    {
        $pr = new TemplateItem();
        $this->assertSame('1.0000', $pr->getQuantity());
    }

    #[Test]
    public function plantillaRubroOrdenDefaultEsCero(): void
    {
        $pr = new TemplateItem();
        $this->assertSame(0, $pr->getOrder());
    }

    #[Test]
    public function plantillaRubroGetPrecioUnitarioCuandoTieneApu(): void
    {
        $tenant = $this->buildTenant();
        $rubro  = $this->buildRubro($tenant);
        $apu    = $this->buildAPUWithMaterialCost($tenant, 75.0);

        $pr = new TemplateItem();
        $pr->setItem($rubro);
        $pr->setApuItem($apu);
        $pr->setQuantity('2.0');

        $this->assertEqualsWithDelta(75.0, $pr->getUnitPrice(), 0.001);
    }

    // ---- Integración Plantilla + PlantillaRubros ----

    #[Test]
    public function multiplasPlantillaRubrosCalculanTotalesIndependientes(): void
    {
        $tenant = $this->buildTenant();

        // Dos PlantillaRubros independientes sumando sus costos
        $total = 0.0;
        for ($i = 1; $i <= 2; $i++) {
            $rubro = new Item();
            $rubro->setTenant($tenant);
            $rubro->setCode('R-00' . $i);
            $rubro->setName('Rubro ' . $i);
            $rubro->setUnit('m²');
            $rubro->setType('general');

            $apu = $this->buildAPUWithMaterialCost($tenant, 100.0); // 100 por unidad

            $pr = new TemplateItem();
            $pr->setItem($rubro);
            $pr->setApuItem($apu);
            $pr->setQuantity('5.0'); // 5 unidades => 500 cada uno

            $total += $pr->getTotalCost();
        }

        // total = 500 + 500 = 1000
        $this->assertEqualsWithDelta(1000.0, $total, 0.001);
    }
}
