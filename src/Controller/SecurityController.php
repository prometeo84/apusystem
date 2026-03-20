<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\LoginSession;
use App\Service\SecurityLogger;
use App\Service\RateLimitingService;
use App\Service\SessionAnomalyDetector;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SecurityLogger $securityLogger,
        private RateLimitingService $rateLimiting,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // Si ya está autenticado, redirigir al dashboard
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }

        // Obtener error de login si existe
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // Último username ingresado
        $lastUsername = $authenticationUtils->getLastUsername();

        // Verificar rate limiting por IP
        $ipAddress = $request->getClientIp();
        if (!$this->rateLimiting->checkLoginRateLimit($ipAddress)) {
            $this->addFlash('error', 'Demasiados intentos de inicio de sesión. Por favor, intente más tarde.');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Este método puede estar vacío - será interceptado por el firewall
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/2fa/verify', name: 'app_2fa_verify')]
    public function verify2FA(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Si no tiene 2FA habilitado, continuar normalmente
        if (!$user->isTwoFactorEnabled()) {
            return $this->redirectToRoute('app_dashboard');
        }

        // Verificar si ya pasó la verificación 2FA en esta sesión
        if ($request->getSession()->get('2fa_verified')) {
            return $this->redirectToRoute('app_dashboard');
        }

        if ($request->isMethod('POST')) {
            $code = $request->request->get('code');
            
            // Aquí se verificaría el código 2FA
            // Por ahora, simplificado
            
            $request->getSession()->set('2fa_verified', true);
            $this->securityLogger->log2FASuccess($user, 'totp');
            
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('security/2fa_verify.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/2fa/setup', name: 'app_2fa_setup')]
    public function setup2FA(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/2fa_setup.html.twig', [
            'user' => $user
        ]);
    }
}
