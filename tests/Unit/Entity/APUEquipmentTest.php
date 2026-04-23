<?php

namespace App\Tests\Unit\Entity;

use App\Entity\APUEquipment;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Tests unitarios para APUEquipment.
 * Fórmulas: C = A×B (número × tarifa); D = C×R (costo/hora × rendimiento u/h)
 */
class APUEquipmentTest extends TestCase
{
    #[Test]
    public function recalculaC_AxB(): void
    {
        $equip = new APUEquipment();
        $equip->setNumber(2);      // A = 2
        $equip->setRate(25.00);    // B = 25 $/h
        $equip->recalculate();

        // C = 2 × 25 = 50
        $this->assertEqualsWithDelta(50.0, (float)$equip->getCostPerHour(), 0.001);
    }

    #[Test]
    public function recalculaD_CxR(): void
    {
        $equip = new APUEquipment();
        $equip->setNumber(1);          // A = 1
        $equip->setRate(50.00);        // B = 50 => C = 50
        $equip->setRendimientoUh(8.0); // R = 8
        $equip->recalculate();

        // D = 50 × 8 = 400
        $this->assertEqualsWithDelta(400.0, (float)$equip->getCostTotal(), 0.001);
        $this->assertEqualsWithDelta(400.0, $equip->getTotalCost(), 0.001);
    }

    #[Test]
    public function getTotalCostConRendimientoNull(): void
    {
        $equip = new APUEquipment();
        $equip->setNumber(2);
        $equip->setRate(15.00); // C = 30
        $equip->setRendimientoUh(null);
        $equip->recalculate();

        // Sin rendimiento => costTotal null; getTotalCost usa costPerHour × 1
        $this->assertEqualsWithDelta(30.0, $equip->getTotalCost(), 0.001);
    }

    #[Test]
    public function aliasSetTarifaFunciona(): void
    {
        $equip = new APUEquipment();
        $equip->setTarifa(100.00);
        $equip->setNumber(1);
        $equip->recalculate();

        $this->assertEqualsWithDelta(100.0, (float)$equip->getCHora(), 0.001);
    }

    #[Test]
    public function aliasSetWorkHoursFunciona(): void
    {
        $equip = new APUEquipment();
        $equip->setWorkHours(6.0);
        $this->assertEqualsWithDelta(6.0, (float)$equip->getRendimientoUh(), 0.001);
    }
}
