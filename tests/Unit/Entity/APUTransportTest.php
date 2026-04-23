<?php

namespace App\Tests\Unit\Entity;

use App\Entity\APUTransport;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Tests unitarios para APUTransport.
 * Fórmula: cost_total = cantidad × DMT × tarifa_km
 */
class APUTransportTest extends TestCase
{
    #[Test]
    public function recalculaCostTotal(): void
    {
        $transport = new APUTransport();
        $transport->setQuantity(5.0);   // 5 m³
        $transport->setDmt(10.0);       // 10 km
        $transport->setTarifaKm(0.50);  // 0.50 $/km
        $transport->recalculate();

        // 5 × 10 × 0.5 = 25
        $this->assertEqualsWithDelta(25.0, (float)$transport->getCostTotal(), 0.001);
        $this->assertEqualsWithDelta(25.0, $transport->getTotalCost(), 0.001);
    }

    #[Test]
    public function recalculaCuandoDmtEsCero(): void
    {
        $transport = new APUTransport();
        $transport->setQuantity(3.0);
        $transport->setDmt(0.0);
        $transport->setTarifaKm(1.00);
        $transport->recalculate();

        $this->assertEqualsWithDelta(0.0, $transport->getTotalCost(), 0.001);
    }

    #[Test]
    public function aliasSetDmtFunciona(): void
    {
        $transport = new APUTransport();
        $transport->setDmt(15.5);
        $this->assertEqualsWithDelta(15.5, (float)$transport->getAvgDistance(), 0.001);
    }

    #[Test]
    public function aliasSetTarifaKmFunciona(): void
    {
        $transport = new APUTransport();
        $transport->setTarifaKm(2.50);
        $this->assertEqualsWithDelta(2.50, (float)$transport->getRatePerKm(), 0.001);
    }

    #[Test]
    public function camposLegacyDescriptionYUnit(): void
    {
        $transport = new APUTransport();
        $transport->setDescription('Volqueta 8m³');
        $transport->setUnit('m³');

        $this->assertSame('Volqueta 8m³', $transport->getDescription());
        $this->assertSame('m³', $transport->getUnit());
    }
}
