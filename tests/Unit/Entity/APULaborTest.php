<?php

namespace App\Tests\Unit\Entity;

use App\Entity\APULabor;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Tests unitarios para APULabor.
 * Fórmulas: C = A×B (número × JOR/HORA); D = C×R (costo/hora × rendimiento u/h)
 */
class APULaborTest extends TestCase
{
    #[Test]
    public function recalculaC_AxB(): void
    {
        $labor = new APULabor();
        $labor->setNumber(3);          // A = 3
        $labor->setJorHora(10.00);     // B = 10 $/h
        $labor->recalculate();

        // C = 3 × 10 = 30
        $this->assertEqualsWithDelta(30.0, (float)$labor->getCostPerHour(), 0.001);
    }

    #[Test]
    public function recalculaD_CxR(): void
    {
        $labor = new APULabor();
        $labor->setNumber(2);          // A = 2
        $labor->setJorHora(5.00);      // B = 5 $/h  => C = 10
        $labor->setRendimientoUh(4.0); // R = 4 u/h
        $labor->recalculate();

        // D = 10 × 4 = 40
        $this->assertEqualsWithDelta(40.0, (float)$labor->getCostTotal(), 0.001);
        $this->assertEqualsWithDelta(40.0, $labor->getTotalCost(), 0.001);
    }

    #[Test]
    public function getTotalCostConRendimientoNull_UsaCostPerHour(): void
    {
        $labor = new APULabor();
        $labor->setNumber(1);
        $labor->setJorHora(20.00); // C = 20
        $labor->setRendimientoUh(null);
        $labor->recalculate();

        // Sin rendimiento => costTotal null; getTotalCost usa costPerHour × 1
        $this->assertEqualsWithDelta(20.0, $labor->getTotalCost(), 0.001);
    }

    #[Test]
    public function aliasSetJorHoraFunciona(): void
    {
        $labor = new APULabor();
        $labor->setJorHora(7.50);
        $labor->recalculate();

        $this->assertEqualsWithDelta(0.0, (float)$labor->getCostPerHour(), 0.001); // number=0 por defecto
    }

    #[Test]
    public function aliasCHoraFunciona(): void
    {
        $labor = new APULabor();
        $labor->setNumber(4);
        $labor->setJorHora(2.50); // C = 10
        $labor->recalculate();

        $this->assertEqualsWithDelta(10.0, (float)$labor->getCHora(), 0.001);
    }
}
