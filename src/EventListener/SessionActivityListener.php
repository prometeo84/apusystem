<?php

namespace App\EventListener;

use App\Entity\LoginSession;
use App\Service\SecurityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SessionActivityListener implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TokenStorageInterface $tokenStorage,
        private ?SecurityLogger $securityLogger = null
    ) {}

    public static function getSubscribedEvents(): array
    {
        // Prioridad baja para que otras cosas se ejecuten primero
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 0],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        if (!$session || !$session->isStarted()) {
            return;
        }

        $loginSessionId = $session->get('login_session_id');
        if (!$loginSessionId) {
            return;
        }

        $loginSession = $this->em->getRepository(LoginSession::class)->find($loginSessionId);
        if (!$loginSession) {
            // limpiar referencia de sesión si no existe en DB
            $session->remove('login_session_id');
            return;
        }

        // Si ya fue marcado inactivo, terminar sesión
        if (!$loginSession->isActive()) {
            $this->invalidateRequestSession($session);
            return;
        }

        $now = new \DateTime();

        // Si expiró, marcar inactivo y cerrar sesión
        if ($loginSession->getExpiresAt() < $now) {
            $loginSession->invalidate();
            $this->em->persist($loginSession);
            $this->em->flush();

            if ($this->securityLogger) {
                // Si hay usuario en token loguear evento
                $token = $this->tokenStorage->getToken();
                $user = $token?->getUser();
                $this->securityLogger->log('session_expired', 'INFO', $user, ['session_id' => $loginSession->getSessionId()]);
            }

            $this->invalidateRequestSession($session);
            return;
        }

        // Actualizar lastActivityAt y extender expiresAt
        $loginSession->updateActivity();

        $lifetime = (int) (getenv('SESSION_LIFETIME') ?: 3600);
        $expiresAt = (clone $now)->modify('+' . $lifetime . ' seconds');

        // Reflection or setter needed - update via property if method exists
        try {
            $method = new \ReflectionMethod(LoginSession::class, 'getExpiresAt');
            // Use existing methods: no setter available, so update by reflection
            $prop = new \ReflectionProperty(LoginSession::class, 'expiresAt');
            $prop->setAccessible(true);
            $prop->setValue($loginSession, $expiresAt);
        } catch (\ReflectionException $e) {
            // If reflection fails, skip updating expiresAt
        }

        $this->em->persist($loginSession);
        $this->em->flush();
    }

    private function invalidateRequestSession($session): void
    {
        // invalidate PHP session
        try {
            $session->invalidate();
        } catch (\Exception $e) {
            // ignore
        }
        // also clear token to force logout
        try {
            $this->tokenStorage->setToken(null);
        } catch (\Exception $e) {
            // ignore
        }
    }
}
