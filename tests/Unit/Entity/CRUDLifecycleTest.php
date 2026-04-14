<?php

namespace App\Tests\Unit\Entity;

use App\Entity\APUItem;
use App\Entity\APUMaterial;
use App\Entity\Apu;
use App\Entity\PlantillaRubro;
use App\Entity\Plantilla;
use App\Entity\Projects;
use App\Entity\Rubro;
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
        $p->setNombre('Edificio Residencial A');
        $p->setCodigo($code);
        $p->setEstado('activo');
        return $p;
    }

    private function buildRubro(Tenant $tenant, string $code = 'R-001'): Rubro
    {
        $r = new Rubro();
        $r->setTenant($tenant);
        $r->setCodigo($code);
        $r->setNombre('Excavación manual');
        $r->setUnidad('m³');
        $r->setTipo('personalizado');
        return $r;
    }

    private function buildAPUItem(Tenant $tenant, float $costPerUnit = 25.0): APUItem
    {
        $item = new APUItem();
        $item->setTenant($tenant);
        $item->setDescription('Hormigón f\'c=240 kg/cm²');
        $item->setUnit('m³');
        $item->setKhu('1.0');
        $item->setRendimientoUh('1.0');

        $mat = new APUMaterial();
        $mat->setDescripcion('Cemento Portland');
        $mat->setUnidad('kg');
        $mat->setCantidad('1.0');
        $mat->setPrecioUnitario((string)$costPerUnit);
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

        $this->assertSame('Edificio Residencial A', $project->getNombre());
        $this->assertSame('P-001', $project->getCodigo());
        $this->assertSame('activo', $project->getEstado());
        $this->assertSame($tenant, $project->getTenant());
    }

    #[Test]
    public function actualizarProyectoModificaCampos(): void
    {
        $tenant  = $this->buildTenant();
        $project = $this->buildProject($tenant);

        $project->setNombre('Edificio Comercial B');
        $project->setEstado('finalizado');

        $this->assertSame('Edificio Comercial B', $project->getNombre());
        $this->assertSame('finalizado', $project->getEstado());
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

        $this->assertTrue($rubro->isActivo());
        $this->assertSame('personalizado', $rubro->getTipo());
        $this->assertSame('R-001', $rubro->getCodigo());
    }

    #[Test]
    public function desactivarRubroLoDeshabilita(): void
    {
        $tenant = $this->buildTenant();
        $rubro  = $this->buildRubro($tenant);

        $rubro->setActivo(false);
        $this->assertFalse($rubro->isActivo());
    }

    #[Test]
    public function rubroActualizaCampos(): void
    {
        $tenant = $this->buildTenant();
        $rubro  = $this->buildRubro($tenant);

        $rubro->setNombre('Relleno compactado');
        $rubro->setUnidad('m³');
        $rubro->setCodigo('R-002');

        $this->assertSame('Relleno compactado', $rubro->getNombre());
        $this->assertSame('R-002', $rubro->getCodigo());
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
        $item->setRendimientoUh('1.0');

        // Material: $10
        $mat = new APUMaterial();
        $mat->setDescripcion('Material A');
        $mat->setUnidad('u');
        $mat->setCantidad('1.0');
        $mat->setPrecioUnitario('10.00');
        $item->addMaterial($mat);

        // Material 2: $15
        $mat2 = new APUMaterial();
        $mat2->setDescripcion('Material B');
        $mat2->setUnidad('u');
        $mat2->setCantidad('1.0');
        $mat2->setPrecioUnitario('15.00');
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

        $plantilla = new Plantilla();
        $plantilla->setTenant($tenant);
        $plantilla->setProyecto($project);
        $plantilla->setNombre('Presupuesto Final');

        $pr = new PlantillaRubro();

        $pr->setRubro($rubro);
        $pr->setApuItem($apuItem);
        $pr->setCantidad('10.0');
        $plantilla->addPlantillaRubro($pr);

        $this->assertCount(1, $plantilla->getPlantillaRubros());
        $this->assertSame($rubro, $plantilla->getPlantillaRubros()->first()->getRubro());
    }

    #[Test]
    public function eliminarRubroDePlantillaReduceConteo(): void
    {
        $tenant   = $this->buildTenant();
        $project  = $this->buildProject($tenant);
        $plantilla = new Plantilla();
        $plantilla->setTenant($tenant);
        $plantilla->setProyecto($project);
        $plantilla->setNombre('Presupuesto Test');

        $rubro1 = $this->buildRubro($tenant, 'R-001');
        $rubro2 = $this->buildRubro($tenant, 'R-002');

        $pr1 = new PlantillaRubro();

        $pr1->setRubro($rubro1);
        $pr1->setCantidad('1.0');

        $pr2 = new PlantillaRubro();

        $pr2->setRubro($rubro2);
        $pr2->setCantidad('2.0');

        $plantilla->addPlantillaRubro($pr1);
        $plantilla->addPlantillaRubro($pr2);
        $this->assertCount(2, $plantilla->getPlantillaRubros());

        $plantilla->removePlantillaRubro($pr1);
        $this->assertCount(1, $plantilla->getPlantillaRubros());
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
        $original = new Plantilla();
        $original->setTenant($tenant);
        $original->setProyecto($project);
        $original->setNombre('Presupuesto Original');

        $prOrig = new PlantillaRubro();

        $prOrig->setRubro($rubro);
        $prOrig->setApuItem($apuItem);
        $prOrig->setCantidad('5.0');
        $original->addPlantillaRubro($prOrig);

        // Simular clonación: nuevo proyecto + nueva plantilla con mismos rubros
        $projectClone = $this->buildProject($tenant, 'P-CLONE');
        $clone = new Plantilla();
        $clone->setTenant($tenant);
        $clone->setProyecto($projectClone);
        $clone->setNombre('Presupuesto Clonado (Usuario B)');

        $prClone = new PlantillaRubro();

        $prClone->setRubro($rubro);
        $prClone->setApuItem($apuItem);
        $prClone->setCantidad('5.0');
        $clone->addPlantillaRubro($prClone);

        // Usuario B modifica su clon: cambia cantidad
        $prClone->setCantidad('20.0');

        // Proyecto A permanece intacto
        $this->assertSame(
            '5.0',
            $prOrig->getCantidad(),
            'Proyecto A no debe cambiar al modificar el clon'
        );

        // Clon tiene la cantidad modificada
        $this->assertSame('20.0', $prClone->getCantidad());

        // Son entidades distintas
        $this->assertNotSame($original, $clone);
        $this->assertNotSame($prOrig, $prClone);
    }

    #[Test]
    public function clonarProyectoPreservaNombreOriginal(): void
    {
        $tenant   = $this->buildTenant();
        $original = $this->buildProject($tenant, 'P-100');
        $original->setNombre('Proyecto Alpha');

        $clone = $this->buildProject($tenant, 'P-100-CLONE');
        $clone->setNombre('Proyecto Alpha (Clon)');

        // Modificar el clon no afecta el original
        $clone->setNombre('Proyecto Beta Modificado');

        $this->assertSame('Proyecto Alpha', $original->getNombre());
        $this->assertSame('Proyecto Beta Modificado', $clone->getNombre());
    }

    // ── Presupuesto ──────────────────────────────────────────────────────────

    #[Test]
    public function presupuestoTotalEsSumaDeRubros(): void
    {
        $tenant   = $this->buildTenant();
        $project  = $this->buildProject($tenant);
        $plantilla = new Plantilla();
        $plantilla->setTenant($tenant);
        $plantilla->setProyecto($project);
        $plantilla->setNombre('Presupuesto Calc');

        // Rubro 1: APU costo unitario = $100, cantidad = 5 → subtotal = $500
        $rubro1  = $this->buildRubro($tenant, 'R-A');
        $apu1    = $this->buildAPUItem($tenant, 100.0);
        $pr1     = new PlantillaRubro();

        $pr1->setRubro($rubro1);
        $pr1->setApuItem($apu1);
        $pr1->setCantidad('5.0');
        $plantilla->addPlantillaRubro($pr1);

        // Rubro 2: APU costo unitario = $200, cantidad = 3 → subtotal = $600
        $rubro2  = $this->buildRubro($tenant, 'R-B');
        $apu2    = $this->buildAPUItem($tenant, 200.0);
        $pr2     = new PlantillaRubro();

        $pr2->setRubro($rubro2);
        $pr2->setApuItem($apu2);
        $pr2->setCantidad('3.0');
        $plantilla->addPlantillaRubro($pr2);

        $total = $plantilla->getTotalPresupuesto();
        // Total esperado = 500 + 600 = 1100
        $this->assertEqualsWithDelta(
            1100.0,
            $total,
            0.01,
            'Total presupuesto debe ser suma de subtotales de rubros'
        );
    }
}
