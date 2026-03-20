<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Security\Core\Exception\TooManyRequestsException;

/**
 * Rate Limiting global para rutas sensibles (OWASP A04:2026)
 */
class RateLimitSubscriber implements EventSubscriberInterface
{
    private array $limitedRoutes = [
        'app_login' => [
            'limit' => 5,
            'interval' => '15 minutes',
        ],
        'app_password_reset_request' => [
            'limit' => 3,
            'interval' => '1 hour',
        ],
        'app_2fa_verify' => [
            'limit' => 3,
            'interval' => '5 minutes',
        ],
        'app_registration' => [
            'limit' => 3,
            'interval' => '1 hour',
        ],
    ];

    public function __construct(
        private RateLimiterFactory $anonymousApiLimiter,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 10],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        // Verificar si la ruta está limitada
        if (!isset($this->limitedRoutes[$route])) {
            return;
        }

        // Obtener IP del cliente
        $clientIp = $request->getClientIp() ?? 'unknown';

        // Excluir localhost y redes privadas (desarrollo)
        if ($this->isExcludedIp($clientIp)) {
            return;
        }

        // Consumir rate limit
        $limiter = $this->anonymousApiLimiter->create($clientIp . '_' . $route);
        $limit = $limiter->consume(1);

        if (!$limit->isAccepted()) {
            $event->setResponse(new JsonResponse(
                [
                    'error' => 'Demasiados intentos. Intente nuevamente más tarde.',
                    'retry_after' => $limit->getRetryAfter()->getTimestamp(),
                ],
                Response::HTTP_TOO_MANY_REQUESTS
            ));
        }
    }

    /**
     * Verifica si la IP está excluida del rate limiting (localhost, redes privadas)
     */
    private function isExcludedIp(string $ip): bool
    {
        // IPs de localhost
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return true;
        }

        // Redes privadas (Docker, redes locales)
        $privateRanges = [
            '10.0.0.0/8',      // Clase A privada
            '172.16.0.0/12',   // Clase B privada (incluye Docker)
            '192.168.0.0/16',  // Clase C privada
        ];

        foreach ($privateRanges as $range) {
            if ($this->ipInRange($ip, $range)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verifica si una IP está en un rango CIDR
     */
    private function ipInRange(string $ip, string $range): bool
    {
        if (strpos($ip, ':') !== false) {
            // IPv6 - por simplicidad, no soportamos rangos IPv6
            return false;
        }

        list($subnet, $mask) = explode('/', $range);

        $ipLong = ip2long($ip);
        $subnetLong = ip2long($subnet);
        $maskLong = -1 << (32 - (int)$mask);

        return ($ipLong & $maskLong) === ($subnetLong & $maskLong);
    }
}
