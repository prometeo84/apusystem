<?php

namespace App\Tests\Unit\Service;

use App\Entity\Tenant;
use App\Entity\User;
use App\Service\UserTimezoneService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * QA-L10N-01: Servicio de Zona Horaria de Usuario
 *
 * Valida que:
 * - La jerarquía usuario → tenant → sistema funcione correctamente
 * - Las conversiones UTC → timezone sean precisas
 * - El formateo respete el timezone configurado
 * - Los timestamps en reportes coincidan con la zona horaria
 */
class UserTimezoneServiceTest extends TestCase
{
    private function buildServiceWithTimezone(?string $userTz, ?string $tenantTz, string $systemTz = 'UTC'): UserTimezoneService
    {
        $tenant = new Tenant();
        $tenant->setName('Corp Test');
        if ($tenantTz) {
            $tenant->setTimezone($tenantTz);
        }

        $user = new User();
        $user->setTenant($tenant);
        $user->setEmail('tz@test.com');
        $user->setUsername('tzuser');
        $user->setFirstName('TZ');
        $user->setLastName('User');
        $user->setPassword('h');
        if ($userTz) {
            $user->setTimezone($userTz);
        }

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($user);

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn($token);

        return new UserTimezoneService($tokenStorage, $systemTz);
    }

    private function buildServiceNoUser(string $systemTz = 'UTC'): UserTimezoneService
    {
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn(null);

        return new UserTimezoneService($tokenStorage, $systemTz);
    }

    // ── Jerarquía de resolución de timezone ─────────────────────────────────

    #[Test]
    public function priorizaTimezoneDelUsuario(): void
    {
        $service = $this->buildServiceWithTimezone('America/New_York', 'America/Guayaquil', 'UTC');
        $this->assertSame('America/New_York', $service->getUserTimezone());
    }

    #[Test]
    public function fallbackATenantSiUsuarioNoTieneTimezone(): void
    {
        $service = $this->buildServiceWithTimezone(null, 'America/Guayaquil', 'UTC');
        $this->assertSame('America/Guayaquil', $service->getUserTimezone());
    }

    #[Test]
    public function fallbackASistemaSiNiUsuarioNiTenantTienenTimezone(): void
    {
        $service = $this->buildServiceWithTimezone(null, null, 'America/Lima');
        $this->assertSame('America/Lima', $service->getUserTimezone());
    }

    #[Test]
    public function sinUsuarioAutenticadoUsaTimezoneDelSistema(): void
    {
        $service = $this->buildServiceNoUser('America/Bogota');
        $this->assertSame('America/Bogota', $service->getUserTimezone());
    }

    // ── Conversión de fechas UTC → timezone ─────────────────────────────────

    #[Test]
    public function conversionUTCaGuayaquilRestaCincoHoras(): void
    {
        $service = $this->buildServiceWithTimezone('America/Guayaquil', null, 'UTC');

        // 2026-04-14 20:00:00 UTC → 2026-04-14 15:00:00 ECT (UTC-5)
        $utcDate = new \DateTime('2026-04-14 20:00:00', new \DateTimeZone('UTC'));
        $converted = $service->convertToUserTimezone($utcDate);

        $this->assertSame('2026-04-14 15:00:00', $converted->format('Y-m-d H:i:s'));
        $this->assertSame('America/Guayaquil', $converted->getTimezone()->getName());
    }

    #[Test]
    public function conversionUTCaNewYorkRestaQuinceHorasEnVerano(): void
    {
        $service = $this->buildServiceWithTimezone('America/New_York', null, 'UTC');

        // 2026-07-01 20:00:00 UTC → 2026-07-01 16:00:00 EDT (UTC-4, verano)
        $utcDate = new \DateTime('2026-07-01 20:00:00', new \DateTimeZone('UTC'));
        $converted = $service->convertToUserTimezone($utcDate);

        $this->assertSame('America/New_York', $converted->getTimezone()->getName());
        // EDT = UTC-4 en verano
        $this->assertSame('2026-07-01 16:00:00', $converted->format('Y-m-d H:i:s'));
    }

    #[Test]
    public function conversionMantieneTimezoneUTC(): void
    {
        $service = $this->buildServiceWithTimezone('UTC', null, 'UTC');

        $utcDate = new \DateTime('2026-01-01 12:00:00', new \DateTimeZone('UTC'));
        $converted = $service->convertToUserTimezone($utcDate);

        $this->assertSame('2026-01-01 12:00:00', $converted->format('Y-m-d H:i:s'));
    }

    // ── Formateo con timezone ────────────────────────────────────────────────

    #[Test]
    public function formatInUserTimezoneDevuelveCadenaFormateada(): void
    {
        $service = $this->buildServiceWithTimezone('America/Guayaquil', null, 'UTC');
        $utcDate = new \DateTime('2026-04-14 20:00:00', new \DateTimeZone('UTC'));

        $formatted = $service->formatInUserTimezone($utcDate);

        // Default format: d/m/Y H:i:s → 14/04/2026 15:00:00
        $this->assertSame('14/04/2026 15:00:00', $formatted);
    }

    #[Test]
    public function formatInUserTimezoneRespetaFormatoPersonalizado(): void
    {
        $service = $this->buildServiceWithTimezone('America/Guayaquil', null, 'UTC');
        $utcDate = new \DateTime('2026-04-14 20:00:00', new \DateTimeZone('UTC'));

        $formatted = $service->formatInUserTimezone($utcDate, 'd/m/Y');
        $this->assertSame('14/04/2026', $formatted);
    }

    // ── Listado de timezones comunes ─────────────────────────────────────────

    #[Test]
    public function getCommonTimezonesDevuelveArray(): void
    {
        $timezones = UserTimezoneService::getCommonTimezones();
        $this->assertIsArray($timezones);
        $this->assertNotEmpty($timezones);
    }

    #[Test]
    public function getCommonTimezonesIncluyeGuayaquil(): void
    {
        // getCommonTimezones() devuelve ['AmericaId' => 'Nombre display', ...]
        $timezones = UserTimezoneService::getCommonTimezones();
        $this->assertArrayHasKey('America/Guayaquil', $timezones);
    }

    #[Test]
    public function cadaTimezoneEnListaEsValido(): void
    {
        // Las claves son IDs de PHP timezone; los valores son texto para mostrar
        $timezones = UserTimezoneService::getCommonTimezones();
        foreach (array_keys($timezones) as $tzId) {
            try {
                new \DateTimeZone($tzId);
                $valid = true;
            } catch (\Exception) {
                $valid = false;
            }
            $this->assertTrue($valid, "Timezone ID inválido en la lista: $tzId");
        }
    }

    // ── Reportes: timestamps respetan timezone ───────────────────────────────

    #[Test]
    public function timestampsDeReporteReflejanTimezoneConfigurado(): void
    {
        // Simula que un reporte genera un timestamp "ahora" en UTC
        // y lo convierte para el usuario en Guayaquil
        $service   = $this->buildServiceWithTimezone('America/Guayaquil', null, 'UTC');
        $nowUtc    = new \DateTime('2026-04-14 18:00:00', new \DateTimeZone('UTC'));
        $converted = $service->convertToUserTimezone($nowUtc);

        // Guayaquil = UTC-5 → debe mostrar 13:00:00
        $this->assertSame('13:00:00', $converted->format('H:i:s'));
        $this->assertNotSame('18:00:00', $converted->format('H:i:s'),
            'El reporte no debe mostrar UTC crudo cuando el usuario tiene timezone configurado');
    }
}
