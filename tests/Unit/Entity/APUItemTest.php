<?php

namespace App\Tests\Unit\Entity;

use App\Entity\APUEquipment;
use App\Entity\APUItem;
use App\Entity\APULabor;
use App\Entity\APUMaterial;
use App\Entity\APUTransport;
use App\Entity\Tenant;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Tests unitarios para APUItem.
 * Fórmulas: C = A×B; D = C×R (equipo/mano de obra)
 * UC-A1 (Campos), UC-A2 (Cálculo costos), UC-A3 (Utilidad/Precio)
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
        $item->setProductivityUh('4.0000');
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

        // A=1, B=50 $/h => C=50; R=8 u/h => D=400
        $equip = new APUEquipment();
        $equip->setDescription('Retroexcavadora');
        $equip->setNumber(1);
        $equip->setRate(50.00);
        $equip->setRendimientoUh(8.0);
        $item->addEquipment($equip);

        $item->calculateCosts();

        $this->assertEqualsWithDelta(400.0, (float)$item->getEquipmentCost(), 0.01);
        $this->assertEqualsWithDelta(400.0, (float)$item->getTotalCost(), 0.01);
    }

    #[Test]
    public function calculateCostsSumaLabor(): void
    {
        $item = $this->buildAPUItem();

        // A=2, B=3.75 $/h => C=7.50; R=4 u/h => D=30
        $labor = new APULabor();
        $labor->setNumber(2);
        $labor->setJorHora(3.75);
        $labor->setRendimientoUh(4.0);
        $item->addLabor($labor);

        $item->calculateCosts();

        $this->assertEqualsWithDelta(30.0, (float)$item->getLaborCost(), 0.01);
    }

    #[Test]
    public function calculateCostsSumaMateriales(): void
    {
        $item = $this->buildAPUItem();

        // cantidad=10.5, precio=8.50 => total=89.25
        $mat = new APUMaterial();
        $mat->setQuantity(10.5);
        $mat->setUnitPrice(8.50);
        $item->addMaterial($mat);

        $item->calculateCosts();

        $this->assertEqualsWithDelta(89.25, (float)$item->getMaterialCost(), 0.001);
    }

    #[Test]
    public function calculateCostsTotalSumaTodasLasSecciones(): void
    {
        $item = $this->buildAPUItem();

        // Equipo: A=1, B=20, R=5 => D=100
        $equip = new APUEquipment();
        $equip->setDescription('Compresor');
        $equip->setNumber(1);
        $equip->setRate(20.00);
        $equip->setRendimientoUh(5.0);
        $item->addEquipment($equip);

        // Material: 2 × 15 = 30
        $mat = new APUMaterial();
        $mat->setQuantity(2.0);
        $mat->setUnitPrice(15.00);
        $item->addMaterial($mat);

        $item->calculateCosts();

        $this->assertEqualsWithDelta(130.0, (float)$item->getTotalCost(), 0.001);
    }

    #[Test]
    public function calculateCostsCalculationPriceSeGuarda(): void
    {
        $item = $this->buildAPUItem();
        $item->setProfitPct('20.00');

        $mat = new APUMaterial();
        $mat->setQuantity(100.0);
        $mat->setUnitPrice(1.00);
        $item->addMaterial($mat);

        $item->calculateCosts();

        // totalCost=100, profitPct=20% => calculationPrice=120
        $this->assertEqualsWithDelta(120.0, $item->getCalculationPrice(), 0.001);
        $this->assertNotNull($item->getCalculationPriceStored());
        $this->assertEqualsWithDelta(120.0, (float)$item->getCalculationPriceStored(), 0.001);
    }

    // ---- UtilidadPct y PrecioOfertado ----

    #[Test]
    public function utilidadPctEsNullPorDefecto(): void
    {
        $item = $this->buildAPUItem();
        $this->assertNull($item->getProfitPct());
    }

    #[Test]
    public function precioOfertadoEsNullPorDefecto(): void
    {
        $item = $this->buildAPUItem();
        $this->assertNull($item->getOfferedPrice());
    }

    #[Test]
    public function setUtilidadPctGuardaElValor(): void
    {
        $item = $this->buildAPUItem();
        $item->setProfitPct('20.00');
        $this->assertSame('20.00', $item->getProfitPct());
    }

    #[Test]
    public function setPrecioOfertadoGuardaElValor(): void
    {
        $item = $this->buildAPUItem();
        $item->setOfferedPrice('150.00');
        $this->assertSame('150.00', $item->getOfferedPrice());
    }

    #[Test]
    public function getPrecioCalculoConUtilidad20Pct(): void
    {
        $item = $this->buildAPUItem();

        $mat = new APUMaterial();
        $mat->setQuantity(100.0);
        $mat->setUnitPrice(1.00);
        $item->addMaterial($mat);
        $item->calculateCosts(); // totalCost = 100

        $item->setProfitPct('20.00');
        $item->calculateCosts(); // must re-run to update calculationPriceStored

        $this->assertEqualsWithDelta(120.0, $item->getCalculationPrice(), 0.001);
    }

    #[Test]
    public function getPrecioCalculoSinUtilidadRetornaTotalCost(): void
    {
        $item = $this->buildAPUItem();

        $mat = new APUMaterial();
        $mat->setQuantity(1.0);
        $mat->setUnitPrice(50.00);
        $item->addMaterial($mat);
        $item->calculateCosts();

        $this->assertEqualsWithDelta(50.0, $item->getCalculationPrice(), 0.001);
    }

    #[Test]
    public function utilidadPctNullNoCausaError(): void
    {
        $item = $this->buildAPUItem();
        $item->setProfitPct(null);

        $mat = new APUMaterial();
        $mat->setQuantity(1.0);
        $mat->setUnitPrice(100.00);
        $item->addMaterial($mat);
        $item->calculateCosts();

        $precioCalculo = $item->getCalculationPrice();
        $this->assertIsFloat($precioCalculo);
        $this->assertEqualsWithDelta(100.0, $precioCalculo, 0.001);
    }

    // ---- Transporte ----

    #[Test]
    public function calculateCostsSumaTransporte(): void
    {
        $item = $this->buildAPUItem();

        // cantidad=5, dmt=10, tarifa=0.50 => 5×10×0.5=25
        $transport = new APUTransport();
        $transport->setDescription('Volqueta');
        $transport->setUnit('m³');
        $transport->setQuantity(5.0);
        $transport->setDmt(10.0);
        $transport->setTarifaKm(0.50);
        $item->addTransport($transport);

        $item->calculateCosts();

        $this->assertEqualsWithDelta(25.0, (float)$item->getTransportCost(), 0.001);
    }

    // ---- Collections ----

    #[Test]
    public function removeEquipmentFunciona(): void
    {
        $item = $this->buildAPUItem();

        $equip = new APUEquipment();
        $equip->setDescription('Grúa');
        $equip->setNumber(1);
        $equip->setRate(100.00);
        $equip->setRendimientoUh(4.0);
        $item->addEquipment($equip);

        $this->assertCount(1, $item->getEquipment());
        $item->removeEquipment($equip);
        $this->assertCount(0, $item->getEquipment());
    }

    #[Test]
    public function createdByEsNullPorDefectoYSetterFunciona(): void
    {
        $item = $this->buildAPUItem();
        $this->assertNull($item->getCreatedBy());

        $user = new User();
        $item->setCreatedBy($user);
        $this->assertSame($user, $item->getCreatedBy());
    }
}


/**
 * Tests unitarios para APUItem (incluyendo utilidadPct y precioOfertado).
 * Cubre: UC-A1 (Campos), UC-A2 (Cálculo costos), UC-A3 (Utilidad/Precio)
 */
