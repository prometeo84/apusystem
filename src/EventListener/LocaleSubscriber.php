<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\User;

/**
 * LocaleSubscriber
 *
 * Establece el locale (idioma) del usuario autenticado en cada request.
 * Permite que cada usuario vea la interfaz en su idioma preferido.
 */
class LocaleSubscriber implements EventSubscriberInterface
{
    private TokenStorageInterface $tokenStorage;
    private string $defaultLocale;

    public function __construct(TokenStorageInterface $tokenStorage, string $defaultLocale = 'es')
    {
        $this->tokenStorage = $tokenStorage;
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Si el locale ya está en la sesión, usarlo
        $sessionLocale = $request->getSession()->get('_locale');
        if ($sessionLocale) {
            $request->setLocale($sessionLocale);

            // Removed ad-hoc debug logging for session locale read.

            return;
        }

        // Si hay un usuario autenticado, usar su locale preferido
        $token = $this->tokenStorage->getToken();
        if ($token && $token->getUser() instanceof User) {
            $user = $token->getUser();
            $locale = $user->getLocale();
            $request->setLocale($locale);
            $request->getSession()->set('_locale', $locale);
            return;
        }

        // Por defecto, usar español
        $request->setLocale($this->defaultLocale);

        // Removed ad-hoc debug logging for default locale fallback.
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
