<?php

namespace App\Tests\Unit\Entity;

use App\Entity\APUEquipment;
use App\Entity\APUItem;
use App\Entity\APULabor;
use App\Entity\APUMaterial;
use App\Entity\APUTransport;
use App\Entity\Tenant;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Tests unitarios para APUItem (incluyendo utilidadPct y precioOfertado).
 * Cubre: UC-A1 (Campos), UC-A2 (Cálculo costos), UC-A3 (Utilidad/Precio)
 */
class APUItemTest extends TestCase
{
    private function buildTenant(): Tenant
    {
        $tenant = new Tenant();
        $tenant->setName('Test Corp');
        return $tenant;
    }

    private function buildAPUItem(): APUItem
    {
        $item = new APUItem();
        $item->setTenant($this->buildTenant());
        $item->setDescription('Excavación manual en suelo normal');
        $item->setUnit('m³');
        $item->setKhu('0.2500');
        $item->setRendimientoUh('4.0000');
        return $item;
    }

    // ---- Creación básica ----

    #[Test]
    public function apuItemTieneUuidAlCrearse(): void
    {
        $item = $this->buildAPUItem();
        $uuid = $item->getUuid();

        $this->assertNotEmpty($uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
            $uuid
        );
    }

    #[Test]
    public function costosTotalEsNullSinCalcular(): void
    {
        $item = $this->buildAPUItem();
        $this->assertNull($item->getTotalCost());
    }

    // ---- Cálculo de costos ----

    #[Test]
    public function calculateCostsSumaEquipo(): void
    {
        $item = $this->buildAPUItem();

        $equip = new APUEquipment();
        $equip->setDescripcion('Retroexcavadora');
        $equip->setNumero(1);
        $equip->setTarifa('50.00');
        $equip->setCHora('8.0000');
        $item->addEquipment($equip);

        $item->calculateCosts();

        // equipmentCost = tarifa * cHora = 50 * 8 = 400
        $this->assertSame('400', $item->getEquipmentCost());
        $this->assertSame('400', $item->getTotalCost());
    }

    #[Test]
    public function calculateCostsSumaLabor(): void
    {
        $item = $this->buildAPUItem();

        $labor = new APULabor();
        $labor->setDescripcion('Peón');
        $labor->setNumero(2);
        $labor->setJorHora('3.75');
        $labor->setCHora('8.0000');
        $item->addLabor($labor);

        $item->calculateCosts();

        // laborCost = jorHora * cHora = 3.75 * 8 = 30
        $this->assertSame('30', $item->getLaborCost());
    }

    #[Test]
    public function calculateCostsSumaMateriales(): void
    {
        $item = $this->buildAPUItem();

        $mat = new APUMaterial();
        $mat->setDescripcion('Cemento Portland');
        $mat->setUnidad('saco');
        $mat->setCantidad('10.5');
        $mat->setPrecioUnitario('8.50');
        $item->addMaterial($mat);

        $item->calculateCosts();

        // materialCost = cantidad * precio = 10.5 * 8.50 = 89.25
        $this->assertEqualsWithDelta(89.25, (float)$item->getMaterialCost(), 0.001);
    }

    #[Test]
    public function calculateCostsTotalSumaTodasLasSecciones(): void
    {
        $item = $this->buildAPUItem();

        $equip = new APUEquipment();
        $equip->setDescripcion('Compresor');
        $equip->setNumero(1);
        $equip->setTarifa('20.00');
        $equip->setCHora('5.0000');
        $item->addEquipment($equip);

        $mat = new APUMaterial();
        $mat->setDescripcion('Arena fina');
        $mat->setUnidad('m³');
        $mat->setCantidad('2.0');
        $mat->setPrecioUnitario('15.00');
        $item->addMaterial($mat);

        $item->calculateCosts();

        // total = 100 (equipo) + 30 (materiales) = 130
        $this->assertEqualsWithDelta(130.0, (float)$item->getTotalCost(), 0.001);
    }

    // ---- UtilidadPct y PrecioOfertado ----

    #[Test]
    public function utilidadPctEsNullPorDefecto(): void
    {
        $item = $this->buildAPUItem();
        $this->assertNull($item->getUtilidadPct());
    }

    #[Test]
    public function precioOfertadoEsNullPorDefecto(): void
    {
        $item = $this->buildAPUItem();
        $this->assertNull($item->getPrecioOfertado());
    }

    #[Test]
    public function setUtilidadPctGuardaElValor(): void
    {
        $item = $this->buildAPUItem();
        $item->setUtilidadPct('20.00');
        $this->assertSame('20.00', $item->getUtilidadPct());
    }

    #[Test]
    public function setPrecioOfertadoGuardaElValor(): void
    {
        $item = $this->buildAPUItem();
        $item->setPrecioOfertado('150.00');
        $this->assertSame('150.00', $item->getPrecioOfertado());
    }

    #[Test]
    public function getPrecioCalculoConUtilidad20Pct(): void
    {
        $item = $this->buildAPUItem();

        $mat = new APUMaterial();
        $mat->setDescripcion('Bloques de concreto');
        $mat->setUnidad('u');
        $mat->setCantidad('100.0');
        $mat->setPrecioUnitario('1.00');
        $item->addMaterial($mat);
        $item->calculateCosts(); // totalCost = 100

        $item->setUtilidadPct('20.00');

        // precioCalculo = 100 * (1 + 20/100) = 120
        $this->assertEqualsWithDelta(120.0, $item->getPrecioCalculo(), 0.001);
    }

    #[Test]
    public function getPrecioCalculoSinUtilidadRetornaTotalCost(): void
    {
        $item = $this->buildAPUItem();

        $mat = new APUMaterial();
        $mat->setDescripcion('Test mat');
        $mat->setUnidad('u');
        $mat->setCantidad('1.0');
        $mat->setPrecioUnitario('50.00');
        $item->addMaterial($mat);
        $item->calculateCosts();

        // Sin utilidadPct debería retornar totalCost
        $this->assertEqualsWithDelta(50.0, $item->getPrecioCalculo(), 0.001);
    }

    #[Test]
    public function utilidadPctNullNoCausaError(): void
    {
        $item = $this->buildAPUItem();
        $item->setUtilidadPct(null);

        $mat = new APUMaterial();
        $mat->setDescripcion('Test');
        $mat->setUnidad('u');
        $mat->setCantidad('1.0');
        $mat->setPrecioUnitario('100.00');
        $item->addMaterial($mat);
        $item->calculateCosts();

        $precioCalculo = $item->getPrecioCalculo();
        $this->assertIsFloat($precioCalculo);
        $this->assertEqualsWithDelta(100.0, $precioCalculo, 0.001);
    }

    // ---- Transporte ----

    #[Test]
    public function calculateCostsSumaTransporte(): void
    {
        $item = $this->buildAPUItem();

        $transport = new APUTransport();
        $transport->setDescripcion('Volqueta');
        $transport->setUnidad('m³');
        $transport->setCantidad('5.0');
        $transport->setDmt('10.0');
        $transport->setTarifaKm('0.50');
        $item->addTransport($transport);

        $item->calculateCosts();

        // transportCost = cantidad * dmt * tarifaKm = 5 * 10 * 0.5 = 25
        $this->assertEqualsWithDelta(25.0, (float)$item->getTransportCost(), 0.001);
    }

    // ---- Collections ----

    #[Test]
    public function removeEquipmentFunciona(): void
    {
        $item = $this->buildAPUItem();

        $equip = new APUEquipment();
        $equip->setDescripcion('Grúa');
        $equip->setNumero(1);
        $equip->setTarifa('100.00');
        $equip->setCHora('4.0000');
        $item->addEquipment($equip);

        $this->assertCount(1, $item->getEquipment());
        $item->removeEquipment($equip);
        $this->assertCount(0, $item->getEquipment());
    }
}
