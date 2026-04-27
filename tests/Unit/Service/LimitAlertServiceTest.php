<?php

namespace App\Tests\Unit\Service;

use App\Entity\Tenant;
use App\Entity\User;
use App\Service\LimitAlertService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Mailer\MailerInterface;

/**
 * UC-LIMIT-01: LimitAlertService — lógica de cálculo de alertas
 */
class LimitAlertServiceTest extends TestCase
{
    private function buildTenant(int $maxProjects = 10, int $maxUsers = 5): Tenant
    {
        $tenant = new Tenant();
        $tenant->setName('Test Corp');
        $tenant->setMaxProjects($maxProjects);
        $tenant->setMaxUsers($maxUsers);
        return $tenant;
    }

    private function buildService(): LimitAlertService
    {
        $mailer = $this->createMock(MailerInterface::class);
        return new LimitAlertService($mailer);
    }

    // ---- buildAlerts: sin alertas bajo el umbral ----

    #[Test]
    public function noAlertsWhenBelowThreshold(): void
    {
        $tenant = $this->buildTenant(10, 5);
        $service = $this->buildService();

        $alerts = $service->buildAlerts($tenant, [
            'projects' => 7,  // 70 %
            'users'    => 3,  // 60 %
            'apus'     => 0,
            'maxApus'  => 0,
        ]);

        $this->assertCount(0, $alerts);
    }

    #[Test]
    public function alertWhenProjectsAtExactlyThreshold(): void
    {
        $tenant = $this->buildTenant(10, 5);
        $service = $this->buildService();

        // 8/10 = 80 % — exactamente en el umbral, debe disparar alerta
        $alerts = $service->buildAlerts($tenant, [
            'projects' => 8,
            'users'    => 1,
            'apus'     => 0,
            'maxApus'  => 0,
        ]);

        $this->assertCount(1, $alerts);
        $this->assertSame('projects', $alerts[0]['resource']);
        $this->assertSame(8, $alerts[0]['current']);
        $this->assertSame(10, $alerts[0]['max']);
        $this->assertSame(80, $alerts[0]['percent']);
    }

    #[Test]
    public function alertWhenUsersAboveThreshold(): void
    {
        $tenant = $this->buildTenant(10, 5);
        $service = $this->buildService();

        // 5/5 = 100 %
        $alerts = $service->buildAlerts($tenant, [
            'projects' => 1,
            'users'    => 5,
            'apus'     => 0,
            'maxApus'  => 0,
        ]);

        $this->assertCount(1, $alerts);
        $this->assertSame('users', $alerts[0]['resource']);
        $this->assertSame(100, $alerts[0]['percent']);
    }

    #[Test]
    public function alertForApusWhenMaxConfigured(): void
    {
        $tenant = $this->buildTenant(100, 50);
        $service = $this->buildService();

        // 90/100 = 90 %
        $alerts = $service->buildAlerts($tenant, [
            'projects' => 1,
            'users'    => 1,
            'apus'     => 90,
            'maxApus'  => 100,
        ]);

        $this->assertCount(1, $alerts);
        $this->assertSame('apus', $alerts[0]['resource']);
        $this->assertSame(90, $alerts[0]['percent']);
    }

    #[Test]
    public function multipleAlertsWhenAllAboveThreshold(): void
    {
        $tenant = $this->buildTenant(5, 5);
        $service = $this->buildService();

        $alerts = $service->buildAlerts($tenant, [
            'projects' => 5,   // 100 %
            'users'    => 5,   // 100 %
            'apus'     => 90,
            'maxApus'  => 100, // 90 %
        ]);

        $this->assertCount(3, $alerts);

        $resources = array_column($alerts, 'resource');
        $this->assertContains('projects', $resources);
        $this->assertContains('users', $resources);
        $this->assertContains('apus', $resources);
    }

    #[Test]
    public function noApuAlertWhenMaxApusIsZero(): void
    {
        $tenant = $this->buildTenant(100, 100);
        $service = $this->buildService();

        $alerts = $service->buildAlerts($tenant, [
            'projects' => 0,
            'users'    => 0,
            'apus'     => 9999,
            'maxApus'  => 0,  // sin límite configurado
        ]);

        $this->assertCount(0, $alerts);
    }

    #[Test]
    public function percentIsCapCorrectly(): void
    {
        $tenant = $this->buildTenant(10, 5);
        $service = $this->buildService();

        // 9/10 = 90 %
        $alerts = $service->buildAlerts($tenant, [
            'projects' => 9,
            'users'    => 0,
            'apus'     => 0,
            'maxApus'  => 0,
        ]);

        $this->assertSame(90, $alerts[0]['percent']);
    }

    // ---- checkAndAlert: omite envío en entorno test ----

    #[Test]
    public function checkAndAlertDoesNotSendInTestEnv(): void
    {
        putenv('APP_ENV=test');

        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects($this->never())->method('send');

        $service = new LimitAlertService($mailer);
        $tenant  = $this->buildTenant(5, 5);

        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setFirstName('Admin');
        $user->setLastName('Test');

        $service->checkAndAlert($user, $tenant, [
            'projects' => 5,
            'users'    => 5,
            'apus'     => 0,
            'maxApus'  => 0,
        ]);
    }
}
