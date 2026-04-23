<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Tenant;
use App\Entity\Equipment;
use App\Entity\Labor;
use App\Entity\Material;
use App\Entity\Transport;
use App\Entity\Projects;
use App\Entity\Template;
use App\Entity\TemplateItem;
use App\Entity\Item;
use App\Entity\APUItem;
use App\Entity\APUMaterial;
use App\Entity\APUEquipment;
use App\Entity\APULabor;
use App\Entity\APUTransport;

class CatalogCrudTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }
    private function getEntityManager()
    {
        self::bootKernel();
        $container = static::getContainer();
        $em = $container->get('doctrine')->getManager();
        $this->ensureSchema($em);
        return $em;
    }

    private function ensureSchema($em): void
    {
        $meta = $em->getMetadataFactory()->getAllMetadata();
        if (empty($meta)) {
            return;
        }
        $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
        try {
            $tool->createSchema($meta);
        } catch (\Exception $e) {
            // Schema probably exists; try to update it to add new columns
            try {
                $tool->updateSchema($meta, true);
            } catch (\Exception) {
                // Ignore — schema is up to date
            }
        }
    }

    private function createTenant($em, $slug = null): Tenant
    {
        $t = new Tenant();
        $t->setName('Tenant Test');
        $t->setSlug($slug ?? 'tenant-' . bin2hex(random_bytes(4)));
        $em->persist($t);
        $em->flush();
        return $t;
    }

    public function testEquipmentCrud(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $e = new Equipment();
        $e->setTenant($tenant)
            ->setCode('EQ-CR-1')
            ->setName('Test Equipment')
            ->setActive(true);

        $em->persist($e);
        $em->flush();

        $id = $e->getId();
        $this->assertNotNull($id);

        $found = $em->getRepository(Equipment::class)->find($id);
        $this->assertInstanceOf(Equipment::class, $found);
        $this->assertTrue($found->isActive());

        $found->setName('Updated Equipment');
        $found->setActive(false);
        $em->flush();

        $updated = $em->getRepository(Equipment::class)->find($id);
        $this->assertEquals('Updated Equipment', $updated->getName());
        $this->assertFalse($updated->isActive());

        $em->remove($updated);
        $em->flush();

        $deleted = $em->getRepository(Equipment::class)->find($id);
        $this->assertNull($deleted);
    }

    public function testLaborCrud(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $o = new Labor();
        $o->setTenant($tenant)
            ->setCode('LB-CR-1')
            ->setDescription('Test Labor')
            ->setActive(true);

        $em->persist($o);
        $em->flush();

        $id = $o->getId();
        $this->assertNotNull($id);

        $found = $em->getRepository(Labor::class)->find($id);
        $this->assertInstanceOf(Labor::class, $found);
        $this->assertTrue($found->isActive());

        $found->setDescription('Updated Labor');
        $found->setActive(false);
        $em->flush();

        $updated = $em->getRepository(Labor::class)->find($id);
        $this->assertEquals('Updated Labor', $updated->getDescription());
        $this->assertFalse($updated->isActive());

        $em->remove($updated);
        $em->flush();

        $deleted = $em->getRepository(Labor::class)->find($id);
        $this->assertNull($deleted);
    }

    public function testMaterialCrud(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $m = new Material();
        $m->setTenant($tenant)
            ->setCode('MT-CR-1')
            ->setName('Test Material')
            ->setUnit('kg');

        $em->persist($m);
        $em->flush();

        $id = $m->getId();
        $this->assertNotNull($id);

        $found = $em->getRepository(Material::class)->find($id);
        $this->assertInstanceOf(Material::class, $found);

        $found->setName('Updated Material');
        $em->flush();

        $updated = $em->getRepository(Material::class)->find($id);
        $this->assertEquals('Updated Material', $updated->getName());

        $em->remove($updated);
        $em->flush();

        $deleted = $em->getRepository(Material::class)->find($id);
        $this->assertNull($deleted);
    }

    public function testTransportCrud(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $t = new Transport();
        $t->setTenant($tenant)
            ->setCode('TR-CR-1')
            ->setName('Test Transport')
            ->setUnit('km');

        $em->persist($t);
        $em->flush();

        $id = $t->getId();
        $this->assertNotNull($id);

        $found = $em->getRepository(Transport::class)->find($id);
        $this->assertInstanceOf(Transport::class, $found);

        $found->setName('Updated Transport');
        $em->flush();

        $updated = $em->getRepository(Transport::class)->find($id);
        $this->assertEquals('Updated Transport', $updated->getName());

        $em->remove($updated);
        $em->flush();

        $deleted = $em->getRepository(Transport::class)->find($id);
        $this->assertNull($deleted);
    }

    public function testCascadeDeleteTenantRemovesProjectsTemplatesApus(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        // Project
        $project = new Projects();
        $project->setTenant($tenant)
            ->setName('Cascade Project')
            ->setCode('C-001')
            ->setStatus('activo');
        $em->persist($project);

        // APU
        $apu = new APUItem();
        $apu->setTenant($tenant)
            ->setDescription('Cascade APU')
            ->setUnit('u')
            ->setKhu('1.0')
            ->setProductivityUh('1.0');
        $em->persist($apu);

        // Template referencing project
        $template = new Template();
        $template->setTenant($tenant)
            ->setProject($project)
            ->setName('Cascade Template');
        $em->persist($template);

        $em->flush();

        $projId = $project->getId();
        $tplId = $template->getId();
        $apuId = $apu->getId();

        // Remove tenant -> database-level cascade should remove related rows
        $em->remove($tenant);
        $em->flush();
        $em->clear();

        $this->assertNull($em->getRepository(Projects::class)->find($projId));
        $this->assertNull($em->getRepository(Template::class)->find($tplId));
        $this->assertNull($em->getRepository(APUItem::class)->find($apuId));
    }

    public function testCascadeDeleteProjectRemovesTemplatesAndTemplateItems(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $project = new Projects();
        $project->setTenant($tenant)
            ->setName('Project Cascade 2')
            ->setCode('C-002')
            ->setStatus('activo');
        $em->persist($project);

        $template = new Template();
        $template->setTenant($tenant)
            ->setProject($project)
            ->setName('Template With Items');
        $em->persist($template);

        $rubro = new Item();
        $rubro->setTenant($tenant)
            ->setCode('R-999')
            ->setName('Rubro Cascade')
            ->setUnit('u')
            ->setType('personalizado');
        $em->persist($rubro);

        $apu = new APUItem();
        $apu->setTenant($tenant)
            ->setDescription('APU for template')
            ->setUnit('u')
            ->setKhu('1.0')
            ->setProductivityUh('1.0');
        $em->persist($apu);

        $titem = new TemplateItem();
        $titem->setTemplate($template)
            ->setItem($rubro)
            ->setApuItem($apu)
            ->setQuantity('2.0');
        $em->persist($titem);

        $em->flush();

        $tplId = $template->getId();
        $titemId = $titem->getId();

        // Remove project -> templates and their items should be removed
        $em->remove($project);
        $em->flush();
        $em->clear();

        $this->assertNull($em->getRepository(Template::class)->find($tplId));
        $this->assertNull($em->getRepository(TemplateItem::class)->find($titemId));
    }

    public function testCascadeDeleteAPURemovesChildEntities(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $apu = new APUItem();
        $apu->setTenant($tenant)
            ->setDescription('APU Children')
            ->setUnit('u')
            ->setKhu('1.0')
            ->setProductivityUh('1.0');
        $em->persist($apu);

        $mat = new APUMaterial();
        $mat->setQuantity('1')
            ->setUnitPrice('10.0');
        $mat->setApuItem($apu);
        $em->persist($mat);

        $equip = new APUEquipment();
        $equip->setDescription('Eq child')
            ->setNumber(1)
            ->setTarifa('5.0');
        $equip->setApuItem($apu);
        $em->persist($equip);

        $em->flush();

        $apuId = $apu->getId();
        $matId = $mat->getId();
        $eqId = $equip->getId();

        $em->remove($apu);
        $em->flush();
        $em->clear();

        $this->assertNull($em->getRepository(APUItem::class)->find($apuId));
        $this->assertNull($em->getRepository(APUMaterial::class)->find($matId));
        $this->assertNull($em->getRepository(APUEquipment::class)->find($eqId));
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Tests para visibility/project en Equipment y Labor (new feature)
    // ─────────────────────────────────────────────────────────────────────────

    public function testEquipmentCanBeAssignedToProject(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $project = new Projects();
        $project->setTenant($tenant)
            ->setName('Visibility Project Equipment')
            ->setCode('VP-EQ-' . bin2hex(random_bytes(3)))
            ->setStatus('activo');
        $em->persist($project);
        $em->flush();

        $e = new Equipment();
        $e->setTenant($tenant)
            ->setCode('EQ-VIS-1')
            ->setName('Visible Equipment')
            ->setActive(true)
            ->setProject($project);

        $em->persist($e);
        $em->flush();

        $id = $e->getId();
        $em->clear();

        $found = $em->getRepository(Equipment::class)->find($id);
        $this->assertNotNull($found);
        $this->assertNotNull($found->getProject(), 'Equipment must have a project assigned');
        $this->assertEquals($project->getId(), $found->getProject()->getId());

        // Clear project → visibility = tenant
        $found->setProject(null);
        $em->flush();
        $em->clear();

        $updated = $em->getRepository(Equipment::class)->find($id);
        $this->assertNull($updated->getProject(), 'Equipment project must be null after clearing');

        $em->remove($updated);
        $em->flush();
    }

    public function testLaborCanBeAssignedToProject(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $project = new Projects();
        $project->setTenant($tenant)
            ->setName('Visibility Project Labor')
            ->setCode('VP-LB-' . bin2hex(random_bytes(3)))
            ->setStatus('activo');
        $em->persist($project);
        $em->flush();

        $l = new Labor();
        $l->setTenant($tenant)
            ->setCode('LB-VIS-1')
            ->setDescription('Visible Labor')
            ->setActive(true)
            ->setProject($project);

        $em->persist($l);
        $em->flush();

        $id = $l->getId();
        $em->clear();

        $found = $em->getRepository(Labor::class)->find($id);
        $this->assertNotNull($found);
        $this->assertNotNull($found->getProject(), 'Labor must have a project assigned');
        $this->assertEquals($project->getId(), $found->getProject()->getId());

        // Unassign project
        $found->setProject(null);
        $em->flush();
        $em->clear();

        $updated = $em->getRepository(Labor::class)->find($id);
        $this->assertNull($updated->getProject(), 'Labor project must be null after clearing');

        $em->remove($updated);
        $em->flush();
    }

    public function testEquipmentProjectNullableByDefault(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $e = new Equipment();
        $e->setTenant($tenant)
            ->setCode('EQ-NOVIS-1')
            ->setName('No Visibility Equipment')
            ->setActive(true);

        $em->persist($e);
        $em->flush();

        $id = $e->getId();
        $em->clear();

        $found = $em->getRepository(Equipment::class)->find($id);
        $this->assertNull($found->getProject(), 'Equipment project must be null when not set (tenant visibility)');

        $em->remove($found);
        $em->flush();
    }

    public function testLaborProjectNullableByDefault(): void
    {
        $em = $this->getEntityManager();
        $tenant = $this->createTenant($em);

        $l = new Labor();
        $l->setTenant($tenant)
            ->setCode('LB-NOVIS-1')
            ->setDescription('No Visibility Labor')
            ->setActive(true);

        $em->persist($l);
        $em->flush();

        $id = $l->getId();
        $em->clear();

        $found = $em->getRepository(Labor::class)->find($id);
        $this->assertNull($found->getProject(), 'Labor project must be null when not set (tenant visibility)');

        $em->remove($found);
        $em->flush();
    }
}
