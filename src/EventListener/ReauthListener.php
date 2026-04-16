<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReauthListener implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $router,
        private array $routes = [],
        private int $timeout = 300
    ) {}

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        if (!$route || !in_array($route, $this->routes, true)) {
            return;
        }

        $session = $request->getSession();
        $last = (int) $session->get('last_full_auth', 0);

        if (time() - $last <= $this->timeout) {
            return; // still fresh
        }

        // Save intended target and redirect to reauth
        $session->set('reauth_target', $request->getUri());

        $response = new RedirectResponse($this->router->generate('app_reauth'));
        $event->setController(function () use ($response) {
            return $response;
        });
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', 10],
        ];
    }
}
