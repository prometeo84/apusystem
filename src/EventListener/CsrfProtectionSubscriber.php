<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Validates _token on every POST request that is not:
 *  - A JSON API endpoint (/api/*, /webauthn/login/* since those are handled by WebAuthn API flow)
 *  - Symfony profiler routes
 *
 * Prevents CSRF on all form-based routes automatically without touching each controller.
 */
class CsrfProtectionSubscriber implements EventSubscriberInterface
{
    /** Routes or prefixes that must NOT be CSRF-checked (JSON/API, Symfony internals) */
    private const EXCLUDED_PREFIXES = [
        '/_',             // Symfony profiler / wdt
        '/api/',          // REST API
        '/webauthn/login/', // WebAuthn API flow (uses its own challenge mechanism)
        '/webauthn/register/', // WebAuthn registration (challenge-based)
        '/cron/',         // Cron endpoints
        '/login',         // Handled by security.yaml form_login
        '/logout',        // Handled by security.yaml logout
    ];

    public function __construct(
        private CsrfTokenManagerInterface $csrfTokenManager
    ) {}

    public static function getSubscribedEvents(): array
    {
        // Priority > 0 so we run before the controller
        return [KernelEvents::REQUEST => ['onRequest', 10]];
    }

    public function onRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        if ($request->getMethod() !== Request::METHOD_POST) {
            return;
        }

        // Skip excluded paths
        $path = $request->getPathInfo();
        foreach (self::EXCLUDED_PREFIXES as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return;
            }
        }

        // Skip if request content type is JSON (API/Ajax without form token)
        $contentType = $request->headers->get('Content-Type', '');
        if (str_contains($contentType, 'application/json')) {
            return;
        }

        $submittedToken = $request->request->get('_token')
            ?? $request->headers->get('X-CSRF-Token');

        if (!$submittedToken || !$this->csrfTokenManager->isTokenValid(new CsrfToken('submit', $submittedToken))) {
            $event->setResponse(new Response('Invalid or missing CSRF token.', Response::HTTP_FORBIDDEN));
        }
    }
}
