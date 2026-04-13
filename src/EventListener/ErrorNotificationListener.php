<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Escucha excepciones no manejadas (HTTP 500+) y envía un correo
 * a todos los superadmins activos con el detalle del error y la traza.
 *
 * - Throttle: misma excepción (clase+archivo+línea) se notifica como máximo
 *   una vez cada THROTTLE_SECONDS segundos para evitar tormentas de emails.
 * - Falla silenciosamente si el mailer no está disponible.
 */
class ErrorNotificationListener implements EventSubscriberInterface
{
    private const THROTTLE_SECONDS = 300; // 5 minutos

    public function __construct(
        private EntityManagerInterface $em,
        private MailerInterface $mailer,
        private string $appEnv,
        private string $projectDir
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', -100],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        // Ignorar errores HTTP que no sean 5xx (404, 403, etc.)
        if ($exception instanceof HttpExceptionInterface && $exception->getStatusCode() < 500) {
            return;
        }

        // Throttle: no inundar el correo con el mismo error repetido
        if ($this->isThrottled($exception)) {
            return;
        }

        try {
            $superAdmins = $this->findSuperAdmins();
            if (empty($superAdmins)) {
                return;
            }

            // Validar que el mailer esté configurado mínimo
            // $_ENV cubre vars cargadas por Symfony DotEnv; getenv() cubre vars del SO en producción
            $mailerDsn = $_ENV['MAILER_DSN'] ?? $_SERVER['MAILER_DSN'] ?? getenv('MAILER_DSN') ?: '';
            if (empty($mailerDsn)) {
                $this->recordEmailFailure('mailer_not_configured', 'MAILER_DSN not set');
                return;
            }

            $request    = $event->getRequest();
            $occurredAt = new \DateTime();
            $fromAddr   = getenv('MAILER_FROM_ADDRESS') ?: 'noreply@apusystem.com';
            $fromName   = getenv('MAILER_FROM_NAME') ?: 'APU System';
            $subject    = sprintf(
                '[APU System ERROR][%s] %s',
                strtoupper($this->appEnv),
                mb_substr(get_class($exception) . ': ' . $exception->getMessage(), 0, 120)
            );

            // Sanitizar la traza: quitar líneas del vendor para reducir ruido
            $trace = $this->sanitizeTrace($exception->getTraceAsString());

            foreach ($superAdmins as $admin) {
                $toEmail = $admin['email'] ?? null;
                if (!$this->isValidEmail($toEmail)) {
                    $this->recordEmailFailure('invalid_recipient', sprintf('Invalid email for user %s %s: %s', $admin['first_name'] ?? '', $admin['last_name'] ?? '', (string)$toEmail));
                    continue;
                }

                try {
                    $email = (new TemplatedEmail())
                        ->from(new Address($fromAddr, $fromName))
                        ->to(new Address($toEmail, trim(($admin['first_name'] ?? '') . ' ' . ($admin['last_name'] ?? ''))))
                        ->subject($subject)
                        ->htmlTemplate('emails/error_notification.html.twig')
                        ->context([
                            'admin_name'      => trim(($admin['first_name'] ?? '') . ' ' . ($admin['last_name'] ?? '')),
                            'exception_class' => get_class($exception),
                            'message'         => $exception->getMessage(),
                            'code'            => $exception->getCode(),
                            'file'            => str_replace($this->projectDir . '/', '', $exception->getFile()),
                            'line'            => $exception->getLine(),
                            'trace'           => $trace,
                            'url'             => $request->getUri(),
                            'method'          => $request->getMethod(),
                            'ip'              => $request->getClientIp() ?? 'unknown',
                            'user_agent'      => mb_substr($request->headers->get('User-Agent', 'unknown'), 0, 200),
                            'occurred_at'     => $occurredAt,
                            'env'             => $this->appEnv,
                            'previous'        => $exception->getPrevious()?->getMessage(),
                        ]);

                    $this->mailer->send($email);
                } catch (\Throwable $e) {
                    $this->recordEmailFailure('send_failed', sprintf('Failed to send to %s: %s', $toEmail, $e->getMessage()));
                }
            }
        } catch (\Throwable) {
            // No permitir que el listener cause una segunda excepción
        }
    }

    private function isValidEmail(?string $email): bool
    {
        if (empty($email)) {
            return false;
        }
        if (strlen($email) > 255) {
            return false;
        }
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function recordEmailFailure(string $type, string $message): void
    {
        try {
            $dir = $this->projectDir . '/var/error_notifications';
            if (!is_dir($dir)) {
                mkdir($dir, 0750, true);
            }
            $logFile = $dir . '/failed_emails.log';
            $line = sprintf("%s\t%s\t%s\n", (new \DateTime())->format('c'), $type, $message);
            file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
        } catch (\Throwable) {
            // silence
        }
    }

    /**
     * Consulta DBAL directa para evitar disparar el ORM completo durante manejo de error.
     */
    private function findSuperAdmins(): array
    {
        try {
            $conn = $this->em->getConnection();
            return $conn->executeQuery(
                "SELECT email, first_name, last_name
                   FROM users
                  WHERE role = 'super_admin'
                    AND is_active = 1"
            )->fetchAllAssociative();
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Evita notificaciones repetitivas del mismo error usando un lock-file en var/.
     */
    private function isThrottled(\Throwable $exception): bool
    {
        try {
            $lockDir = $this->projectDir . '/var/error_notifications';
            if (!is_dir($lockDir)) {
                mkdir($lockDir, 0750, true);
            }

            $key      = md5(get_class($exception) . $exception->getFile() . $exception->getLine());
            $lockFile = $lockDir . '/' . $key . '.lock';

            if (file_exists($lockFile)) {
                $lastSent = (int) file_get_contents($lockFile);
                if (time() - $lastSent < self::THROTTLE_SECONDS) {
                    return true;
                }
            }

            file_put_contents($lockFile, (string) time(), LOCK_EX);
            return false;
        } catch (\Throwable) {
            return false; // Si falla el throttle, notificar igual
        }
    }

    /**
     * Acorta la traza quitando líneas repetitivas de vendor/ para no saturar el email.
     */
    private function sanitizeTrace(string $trace): string
    {
        $lines    = explode("\n", $trace);
        $filtered = [];
        $vendorSkipped = 0;

        foreach ($lines as $line) {
            if (str_contains($line, '/vendor/')) {
                $vendorSkipped++;
                if ($vendorSkipped === 1) {
                    $filtered[] = $line; // La primera línea de vendor sí se incluye
                } elseif ($vendorSkipped === 2) {
                    $filtered[] = '    ... (vendor frames omitidos) ...';
                }
            } else {
                $vendorSkipped = 0;
                $filtered[]    = $line;
            }
        }

        return implode("\n", $filtered);
    }
}
