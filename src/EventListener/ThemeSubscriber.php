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
        $primaryHex = '#667eea';
        $secondaryHex = '#764ba2';
        $mode = 'light';

        if ($token && $token->getUser() instanceof User) {
            $user = $token->getUser();

            // Prefer user settings; fallback to tenant; then system defaults
            $tenant = $user->getTenant();

            $primaryHex = $user->getThemePrimaryColor() ?? ($tenant?->getThemePrimaryColor() ?? $primaryHex);
            $secondaryHex = $user->getThemeSecondaryColor() ?? ($tenant?->getThemeSecondaryColor() ?? $secondaryHex);
            $mode = $user->getThemeMode() ?? ($tenant?->getThemeMode() ?? $mode);
        }

        // Compute RGB values for darker overlays
        $primaryRgb = $this->hexToRgb($primaryHex);
        $secondaryRgb = $this->hexToRgb($secondaryHex);

        // Inyectar variables globales en Twig
        $this->twig->addGlobal('user_theme', [
            'primary_color' => $primaryHex,
            'secondary_color' => $secondaryHex,
            'primary_rgb' => $primaryRgb,
            'secondary_rgb' => $secondaryRgb,
            'mode' => $mode,
        ]);
    }

    private function hexToRgb(string $hex): string
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $r = hexdec(str_repeat($hex[0], 2));
            $g = hexdec(str_repeat($hex[1], 2));
            $b = hexdec(str_repeat($hex[2], 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return sprintf('%d, %d, %d', $r, $g, $b);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // Bajar prioridad para que el firewall y el token de seguridad
            // estén disponibles antes de leer el usuario autenticado.
            KernelEvents::REQUEST => [['onKernelRequest', 0]],
        ];
    }
}
