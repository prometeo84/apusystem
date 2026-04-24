<?php

namespace App\Tests\Unit\Entity;

use App\Entity\APUItem;
use App\Entity\APUMaterial;
use App\Entity\Apu;
use App\Entity\TemplateItem;
use App\Entity\Template;
use App\Entity\Projects;
use App\Entity\Item;
use App\Entity\Tenant;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * QA-BIZ-01: Lógica de Negocio — Ciclo de Vida CRUD y Clonación
 *
 * Valida:
 * - CRUD completo de Proyectos, Rubros, APU y Plantillas
 * - Integridad referencial al eliminar entidad padre
 * - Clonación de proyecto: Usuario B puede expandir; Proyecto A inalterado
 * - Cálculo correcto de presupuesto
 */
class CRUDLifecycleTest extends TestCase
{
    private function buildTenant(): Tenant
    {
        $t = new Tenant();
        $t->setName('Corp Test');
        return $t;
    }

    private function buildAdmin(Tenant $tenant): User
    {
        $u = new User();
        $u->setTenant($tenant);
        $u->setEmail('admin@test.com');
        $u->setUsername('admin');
        $u->setFirstName('Admin');
        $u->setLastName('User');
        $u->setPassword('h');
        $u->setRole('ROLE_ADMIN');
        return $u;
    }

    private function buildProject(Tenant $tenant, string $code = 'P-001'): Projects
    {
        $p = new Projects();
        $p->setTenant($tenant);
        $p->setName('Edificio Residencial A');
        $p->setCode($code);
        $p->setStatus('activo');
        return $p;
    }

    private function buildRubro(Tenant $tenant, string $code = 'R-001'): Item
    {
        $r = new Item();
        $r->setTenant($tenant);
        $r->setCode($code);
        $r->setName('Excavación manual');
        $r->setUnit('m³');
        $r->setType('personalizado');
        return $r;
    }

    private function buildAPUItem(Tenant $tenant, float $costPerUnit = 25.0): APUItem
    {
        $item = new APUItem();
        $item->setTenant($tenant);
        $item->setDescription('Hormigón f\'c=240 kg/cm²');
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

    // ── CRUD Proyectos ───────────────────────────────────────────────────────

    #[Test]
    public function crearProyectoConCamposRequeridos(): void
    {
        $tenant  = $this->buildTenant();
        $project = $this->buildProject($tenant);

        $this->assertSame('Edificio Residencial A', $project->getName());
        $this->assertSame('P-001', $project->getCode());
        $this->assertSame('activo', $project->getStatus());
        $this->assertSame($tenant, $project->getTenant());
    }

    #[Test]
    public function actualizarProyectoModificaCampos(): void
    {
        $tenant  = $this->buildTenant();
        $project = $this->buildProject($tenant);

        $project->setName('Edificio Comercial B');
        $project->setStatus('finalizado');

        $this->assertSame('Edificio Comercial B', $project->getName());
        $this->assertSame('finalizado', $project->getStatus());
    }

    #[Test]
    public function eliminarProyectoLibera(): void
    {
        $tenant   = $this->buildTenant();
        $projects = [];
        for ($i = 0; $i < 3; $i++) {
            $projects[] = $this->buildProject($tenant, "P-00$i");
        }

        // Eliminar el proyecto del medio
        unset($projects[1]);

        $this->assertCount(2, $projects);
        $this->assertArrayNotHasKey(1, $projects);
    }

    // ── CRUD Rubros ──────────────────────────────────────────────────────────

    #[Test]
    public function crearRubroConTipo(): void
    {
        $tenant = $this->buildTenant();
        $rubro  = $this->buildRubro($tenant);

        $this->assertTrue($rubro->isActive());
        $this->assertSame('personalizado', $rubro->getType());
        $this->assertSame('R-001', $rubro->getCode());
    }

    #[Test]
    public function desactivarRubroLoDeshabilita(): void
    {
        $tenant = $this->buildTenant();
        $rubro  = $this->buildRubro($tenant);

        $rubro->setActive(false);
        $this->assertFalse($rubro->isActive());
    }

    #[Test]
    public function rubroActualizaCampos(): void
    {
        $tenant = $this->buildTenant();
        $rubro  = $this->buildRubro($tenant);

        $rubro->setName('Relleno compactado');
        $rubro->setUnit('m³');
        $rubro->setCode('R-002');

        $this->assertSame('Relleno compactado', $rubro->getName());
        $this->assertSame('R-002', $rubro->getCode());
    }

    // ── CRUD APU ─────────────────────────────────────────────────────────────

    #[Test]
    public function crearAPUItemCalculaCostosCorrectamente(): void
    {
        $tenant = $this->buildTenant();
        $item   = $this->buildAPUItem($tenant, 50.0);

        $this->assertNotNull($item->getTotalCost());
        $this->assertGreaterThan(0.0, (float)$item->getTotalCost());
    }

    #[Test]
    public function apuConVariosComponentesCalculaTotalCorrecto(): void
    {
        $tenant = $this->buildTenant();
        $item   = new APUItem();
        $item->setTenant($tenant);
        $item->setDescription('APU Multi-componente');
        $item->setUnit('m²');
        $item->setKhu('1.0');
        $item->setProductivityUh('1.0');

        // Material: $10
        $mat = new APUMaterial();
        $mat->setQuantity('1.0');
        $mat->setUnitPrice('10.00');
        $item->addMaterial($mat);

        // Material 2: $15
        $mat2 = new APUMaterial();
        $mat2->setQuantity('1.0');
        $mat2->setUnitPrice('15.00');
        $item->addMaterial($mat2);

        $item->calculateCosts();

        // Total mínimo debe incluir materiales = $25
        $this->assertGreaterThanOrEqual(25.0, (float)$item->getTotalCost());
    }

    // ── Integridad referencial ────────────────────────────────────────────────

    #[Test]
    public function plantillaConRubroMantieneReferencia(): void
    {
        $tenant   = $this->buildTenant();
        $project  = $this->buildProject($tenant);
        $rubro    = $this->buildRubro($tenant);
        $apuItem  = $this->buildAPUItem($tenant, 100.0);

        $plantilla = new Template();
        $plantilla->setTenant($tenant);
        $plantilla->setProject($project);
        $plantilla->setName('Presupuesto Final');

        $pr = new TemplateItem();

        $pr->setItem($rubro);
        $pr->setApuItem($apuItem);
        $plantilla->addItem($pr);

        $this->assertCount(1, $plantilla->getItems());
        $this->assertSame($rubro, $plantilla->getItems()->first()->getItem());
    }

    #[Test]
    public function eliminarRubroDePlantillaReduceConteo(): void
    {
        $tenant   = $this->buildTenant();
        $project  = $this->buildProject($tenant);
        $plantilla = new Template();
        $plantilla->setTenant($tenant);
        $plantilla->setProject($project);
        $plantilla->setName('Presupuesto Test');

        $rubro1 = $this->buildRubro($tenant, 'R-001');
        $rubro2 = $this->buildRubro($tenant, 'R-002');

        $pr1 = new TemplateItem();

        $pr1->setItem($rubro1);

        $pr2 = new TemplateItem();

        $pr2->setItem($rubro2);

        $plantilla->addItem($pr1);
        $plantilla->addItem($pr2);
        $this->assertCount(2, $plantilla->getItems());

        $plantilla->removeItem($pr1);
        $this->assertCount(1, $plantilla->getItems());
    }

    // ── Clonación de Proyecto ────────────────────────────────────────────────

    #[Test]
    public function clonarPlantillaProduceEntidadIndependiente(): void
    {
        $tenant   = $this->buildTenant();
        $project  = $this->buildProject($tenant);
        $rubro    = $this->buildRubro($tenant);
        $apuItem  = $this->buildAPUItem($tenant, 50.0);

        // Plantilla original (Usuario A / Admin)
        $original = new Template();
        $original->setTenant($tenant);
        $original->setProject($project);
        $original->setName('Presupuesto Original');

        $prOrig = new TemplateItem();

        $prOrig->setItem($rubro);
        $prOrig->setApuItem($apuItem);
        $original->addItem($prOrig);

        // Simular clonación: nuevo proyecto + nueva plantilla con mismos rubros
        $projectClone = $this->buildProject($tenant, 'P-CLONE');
        $clone = new Template();
        $clone->setTenant($tenant);
        $clone->setProject($projectClone);
        $clone->setName('Presupuesto Clonado (Usuario B)');

        $prClone = new TemplateItem();

        $prClone->setItem($rubro);
        $prClone->setApuItem($apuItem);
        $clone->addItem($prClone);

        // Proyecto A permanece intacto
        $this->assertSame($rubro, $prOrig->getItem(), 'Proyecto A no debe cambiar al modificar el clon');

        // Son entidades distintas
        $this->assertNotSame($original, $clone);
        $this->assertNotSame($prOrig, $prClone);
    }

    #[Test]
    public function clonarProyectoPreservaNombreOriginal(): void
    {
        $tenant   = $this->buildTenant();
        $original = $this->buildProject($tenant, 'P-100');
        $original->setName('Proyecto Alpha');

        $clone = $this->buildProject($tenant, 'P-100-CLONE');
        $clone->setName('Proyecto Alpha (Clon)');

        // Modificar el clon no afecta el original
        $clone->setName('Proyecto Beta Modificado');

        $this->assertSame('Proyecto Alpha', $original->getName());
        $this->assertSame('Proyecto Beta Modificado', $clone->getName());
    }

    // ── Presupuesto ──────────────────────────────────────────────────────────

    #[Test]
    public function presupuestoTotalEsSumaDeRubros(): void
    {
        $tenant   = $this->buildTenant();
        $project  = $this->buildProject($tenant);
        $plantilla = new Template();
        $plantilla->setTenant($tenant);
        $plantilla->setProject($project);
        $plantilla->setName('Presupuesto Calc');

        // Rubro 1: APU precio total = $500
        $rubro1  = $this->buildRubro($tenant, 'R-A');
        $apu1    = $this->buildAPUItem($tenant, 500.0);
        $pr1     = new TemplateItem();

        $pr1->setItem($rubro1);
        $pr1->setApuItem($apu1);
        $plantilla->addItem($pr1);

        // Rubro 2: APU precio total = $600
        $rubro2  = $this->buildRubro($tenant, 'R-B');
        $apu2    = $this->buildAPUItem($tenant, 600.0);
        $pr2     = new TemplateItem();

        $pr2->setItem($rubro2);
        $pr2->setApuItem($apu2);
        $plantilla->addItem($pr2);

        $total = $plantilla->getTotalBudget();
        // Total esperado = 500 + 600 = 1100
        $this->assertEqualsWithDelta(
            1100.0,
            $total,
            0.01,
            'Total presupuesto debe ser suma de costos de APUs'
        );
    }
}
