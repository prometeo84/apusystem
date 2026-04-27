<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Envía un correo de alerta cuando un usuario inicia sesión.
 * El envío es "best-effort": cualquier fallo se silencia para no interrumpir el login.
 */
class LoginAlertService
{
    public function __construct(
        private MailerInterface $mailer
    ) {}

    /**
     * @param array{ip: string, userAgent: string, dateTime: \DateTimeImmutable} $context
     */
    public function sendLoginAlert(User $user, array $context): void
    {
        // En entorno de test omitir el envío
        if (in_array(getenv('APP_ENV'), ['test', 'testing'], true)) {
            return;
        }

        try {
            $from = new Address(
                getenv('MAILER_FROM_ADDRESS') ?: 'noreply@apusystem.com',
                getenv('MAILER_FROM_NAME') ?: 'APU System'
            );

            $email = (new TemplatedEmail())
                ->from($from)
                ->to(new Address($user->getEmail(), $user->getFullName()))
                ->subject('Nuevo inicio de sesión detectado — APU System')
                ->htmlTemplate('emails/login_alert.html.twig')
                ->textTemplate('emails/login_alert.txt.twig')
                ->context([
                    'user'       => $user,
                    'ip'         => $context['ip'],
                    'userAgent'  => $context['userAgent'],
                    'dateTime'   => $context['dateTime'],
                    'primary_color'   => $user->getThemePrimaryColor() ?? '#667eea',
                    'secondary_color' => $user->getThemeSecondaryColor() ?? '#764ba2',
                ]);

            $this->mailer->send($email);
        } catch (\Throwable) {
            // No interrumpir el flujo de autenticación por fallos del mailer
        }
    }
}
