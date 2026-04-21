<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * DeviceSubscriber
 *
 * Detecta de forma ligera el tipo de dispositivo a partir del User-Agent
 * y expone globals en Twig: `device.is_mobile`, `device.is_tablet`, `device.is_desktop`.
 */
class DeviceSubscriber implements EventSubscriberInterface
{
    private Environment $twig;
    private ParameterBagInterface $params;
    private string $linkDisplayMode = 'both';

    public function __construct(Environment $twig, ParameterBagInterface $params)
    {
        $this->twig = $twig;
        $this->params = $params;
        $this->linkDisplayMode = (string) ($this->params->get('app.link_display_mode') ?? 'both');
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $ua = (string) $request->headers->get('User-Agent', '');

        // Detección simple basada en User-Agent (suficiente para decidir mostrar/ocultar elementos)
        $tabletPattern = '/\b(iPad|Tablet|PlayBook|Silk|Kindle)\b/i';
        $mobilePattern = '/\b(Mobile|Android|iPhone|IEMobile|BlackBerry|Opera Mini|Windows Phone)\b/i';

        $isTablet = preg_match($tabletPattern, $ua) === 1;
        $isMobile = preg_match($mobilePattern, $ua) === 1 && !$isTablet;
        $isDesktop = !$isMobile && !$isTablet;

        // Decide whether to show the auxiliary 'new-item' link according to config
        $showLink = false;
        switch ($this->linkDisplayMode) {
            case 'mobile':
                $showLink = $isMobile;
                break;
            case 'desktop':
                $showLink = $isDesktop;
                break;
            case 'both':
            default:
                $showLink = true;
        }

        $this->twig->addGlobal('device', [
            'is_mobile' => $isMobile,
            'is_tablet' => $isTablet,
            'is_desktop' => $isDesktop,
            'user_agent' => $ua,
            'show_new_item_link' => $showLink,
        ]);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // Prioridad baja para correr después de autenticación y otros subscribers
            KernelEvents::REQUEST => [['onKernelRequest', -10]],
        ];
    }
}
