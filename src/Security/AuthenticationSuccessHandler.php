<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\LoginSession;
use App\Service\SecurityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        private RouterInterface $router,
        private EntityManagerInterface $em,
        private SecurityLogger $securityLogger
    ) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof User) {
            return new RedirectResponse($this->router->generate('app_login'));
        }

        // Actualizar información de último login
        $ipAddress = $request->getClientIp() ?? '0.0.0.0';
        $user->updateLastLogin($ipAddress);

        // Crear sesión de login
        $sessionId = $request->getSession()->getId();
        $userAgent = $request->headers->get('User-Agent') ?? 'Unknown';

        $lifetime = (int) (getenv('SESSION_LIFETIME') ?: 3600);

        $loginSession = new LoginSession(
            $user,
            $sessionId,
            $ipAddress,
            $userAgent,
            $lifetime
        );

        $this->em->persist($loginSession);
        $this->em->persist($user);
        $this->em->flush();

        // Guardar info de sesión
        $request->getSession()->set('login_session_id', $loginSession->getId());
        $request->getSession()->set('fingerprint', $loginSession->getFingerprint());

        // Log de login exitoso
        $this->securityLogger->logLoginSuccess($user);

        // Si tiene 2FA habilitado, redirigir a verificación
        if ($user->isTwoFactorEnabled()) {
            return new RedirectResponse($this->router->generate('app_2fa_verify'));
        }

        // Marcar 2FA como verificado (ya que no está habilitado)
        $request->getSession()->set('2fa_verified', true);

        // Redirigir al dashboard
        return new RedirectResponse($this->router->generate('app_dashboard'));
    }
}
