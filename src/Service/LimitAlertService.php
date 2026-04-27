<?php

namespace App\Service;

use App\Entity\Tenant;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Envía correos de alerta cuando un tenant se acerca o alcanza sus límites de recursos.
 * Umbral de "cerca": ≥ 80 % del máximo.
 */
class LimitAlertService
{
    private const THRESHOLD = 0.8;

    public function __construct(
        private MailerInterface $mailer
    ) {}

    /**
     * Comprueba proyectos, usuarios y APUs; envía UN correo consolidado si algún
     * recurso supera el umbral.  Debe llamarse sólo cuando ya se sabe que $user
     * es ROLE_ADMIN o ROLE_SUPER_ADMIN.
     *
     * @param array{projects: int, users: int, apus: int, maxApus: int} $counts
     */
    public function checkAndAlert(User $user, Tenant $tenant, array $counts): void
    {
        // En entorno de test omitir el envío
        if (in_array(getenv('APP_ENV'), ['test', 'testing'], true)) {
            return;
        }

        $alerts = $this->buildAlerts($tenant, $counts);

        if (empty($alerts)) {
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
                ->subject('Alerta de límite de recursos — APU System')
                ->htmlTemplate('emails/limit_alert.html.twig')
                ->textTemplate('emails/limit_alert.txt.twig')
                ->context([
                    'user'           => $user,
                    'tenant'         => $tenant,
                    'alerts'         => $alerts,
                    'primary_color'  => $user->getThemePrimaryColor() ?? '#667eea',
                    'secondary_color' => $user->getThemeSecondaryColor() ?? '#764ba2',
                ]);

            $this->mailer->send($email);
        } catch (\Throwable) {
            // No interrumpir el flujo normal por fallos del mailer
        }
    }

    /**
     * @param array{projects: int, users: int, apus: int, maxApus: int} $counts
     * @return array<array{resource: string, current: int, max: int, percent: int}>
     */
    public function buildAlerts(Tenant $tenant, array $counts): array
    {
        $alerts = [];

        // Proyectos
        $maxProjects = $tenant->getMaxProjects();
        if ($maxProjects > 0 && $counts['projects'] / $maxProjects >= self::THRESHOLD) {
            $alerts[] = [
                'resource' => 'projects',
                'current'  => $counts['projects'],
                'max'      => $maxProjects,
                'percent'  => (int) round($counts['projects'] / $maxProjects * 100),
            ];
        }

        // Usuarios
        $maxUsers = $tenant->getMaxUsers();
        if ($maxUsers > 0 && $counts['users'] / $maxUsers >= self::THRESHOLD) {
            $alerts[] = [
                'resource' => 'users',
                'current'  => $counts['users'],
                'max'      => $maxUsers,
                'percent'  => (int) round($counts['users'] / $maxUsers * 100),
            ];
        }

        // APUs (límite opcional por configuración)
        $maxApus = $counts['maxApus'] ?? 0;
        if ($maxApus > 0 && $counts['apus'] / $maxApus >= self::THRESHOLD) {
            $alerts[] = [
                'resource' => 'apus',
                'current'  => $counts['apus'],
                'max'      => $maxApus,
                'percent'  => (int) round($counts['apus'] / $maxApus * 100),
            ];
        }

        return $alerts;
    }
}
