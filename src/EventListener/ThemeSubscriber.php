<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;
use App\Entity\User;

/**
 * ThemeSubscriber
 *
 * Inyecta las preferencias de tema del usuario en Twig para aplicar colores personalizados.
 */
class ThemeSubscriber implements EventSubscriberInterface
{
    private TokenStorageInterface $tokenStorage;
    private Environment $twig;

    public function __construct(TokenStorageInterface $tokenStorage, Environment $twig)
    {
        $this->tokenStorage = $tokenStorage;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        if ($token && $token->getUser() instanceof User) {
            $user = $token->getUser();

            // Inyectar variables globales en Twig
            $this->twig->addGlobal('user_theme', [
                'primary_color' => $user->getThemePrimaryColor() ?? '#667eea',
                'secondary_color' => $user->getThemeSecondaryColor() ?? '#764ba2',
                'mode' => $user->getThemeMode() ?? 'light',
            ]);
        } else {
            // Valores por defecto para usuarios no autenticados
            $this->twig->addGlobal('user_theme', [
                'primary_color' => '#667eea',
                'secondary_color' => '#764ba2',
                'mode' => 'light',
            ]);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 15]],
        ];
    }
}
