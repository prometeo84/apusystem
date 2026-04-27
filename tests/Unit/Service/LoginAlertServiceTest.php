<?php

namespace App\Tests\Unit\Service;

use App\Entity\User;
use App\Entity\Tenant;
use App\Service\LoginAlertService;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\Mailer\MailerInterface;

/**
 * UC-LOGIN-ALERT-01: LoginAlertService — envío de alerta de login
 */
class LoginAlertServiceTest extends TestCase
{
    private function buildUser(): User
    {
        $tenant = new Tenant();
        $tenant->setName('Test Corp');

        $user = new User();
        $user->setTenant($tenant);
        $user->setEmail('user@example.com');
        $user->setFirstName('Jane');
        $user->setLastName('Doe');
        $user->setUsername('janedoe');

        return $user;
    }

    #[Test]
    public function doesNotSendEmailInTestEnv(): void
    {
        putenv('APP_ENV=test');

        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects($this->never())->method('send');

        $service = new LoginAlertService($mailer);
        $service->sendLoginAlert($this->buildUser(), [
            'ip'       => '192.168.1.1',
            'userAgent' => 'PHPUnit',
            'dateTime' => new \DateTimeImmutable('now'),
        ]);
    }

    #[Test]
    public function sendEmailWhenNotInTestEnv(): void
    {
        putenv('APP_ENV=dev');

        $mailer = $this->createMock(MailerInterface::class);
        // En dev debería intentar enviar; pero el transport puede fallar — el servicio lo silencia
        // Verificamos que se llame al mailer exactamente una vez
        $mailer->expects($this->once())
            ->method('send')
            ->willThrowException(new \RuntimeException('SMTP not available'));

        $service = new LoginAlertService($mailer);
        // No debe lanzar excepción aunque el mailer falle
        $service->sendLoginAlert($this->buildUser(), [
            'ip'        => '10.0.0.1',
            'userAgent' => 'Mozilla/5.0',
            'dateTime'  => new \DateTimeImmutable('now'),
        ]);

        // Restaurar entorno
        putenv('APP_ENV=test');
    }
}
