<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\LoginSession;
use App\Service\SecurityLogger;
use App\Service\RateLimitingService;
use App\Service\SessionAnomalyDetector;
use App\Service\TwoFactorAuthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SecurityLogger $securityLogger,
        private RateLimitingService $rateLimiting,
        private UserPasswordHasherInterface $passwordHasher,
        private TwoFactorAuthService $twoFactorService
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
            $this->addFlash('error', 'auth.too_many_attempts');
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

            // Verificar el código TOTP usando el servicio inyectado
            if ($this->twoFactorService->verifyTotpCode($user->getTotpSecret() ?? '', $code)) {
                $request->getSession()->set('2fa_verified', true);
                $this->securityLogger->log2FASuccess($user, 'totp');

                // Si es superadmin y aún no verificó el correo, redirigir a verificación por email
                if ($request->getSession()->get('superadmin_email_code_hash')) {
                    return $this->redirectToRoute('app_superadmin_verify_email');
                }

                return $this->redirectToRoute('app_dashboard');
            }

            $this->securityLogger->log2FAFailed($user, 'totp', 'Invalid code');
            $this->addFlash('error', 'flash.2fa_invalid');
        }

        return $this->render('security/2fa_verify.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/superadmin/verify-email', name: 'app_superadmin_verify_email')]
    public function verifySuperAdminEmail(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $session = $request->getSession();
        $hash = $session->get('superadmin_email_code_hash');
        $expires = $session->get('superadmin_email_expires_at');

        // Convertir string ISO a DateTime para la plantilla y calcular tiempo restante
        $expiresAt = null;
        if ($expires) {
            try {
                $expiresAt = new \DateTimeImmutable($expires);
            } catch (\Throwable $_) {
                $expiresAt = null;
            }
        }

        if (!$hash) {
            return $this->redirectToRoute('app_dashboard');
        }

        if ($request->isMethod('POST')) {
            $code = $request->request->get('code');

            $ok = $code && $hash && password_verify((string)$code, $hash);

            if ($ok) {
                $session->set('superadmin_email_verified', true);
                // limpiar datos sensibles
                $session->remove('superadmin_email_code_hash');
                $session->remove('superadmin_email_expires_at');

                $this->securityLogger->log('superadmin_email_verified', 'INFO', $user);

                // Si la 2FA ya está verificada, ir al dashboard
                if ($session->get('2fa_verified')) {
                    return $this->redirectToRoute('app_dashboard');
                }

                // Si no, redirigir a verificación 2FA
                return $this->redirectToRoute('app_2fa_verify');
            }

            $this->addFlash('error', 'flash.code_invalid_or_expired');
        }

        return $this->render('security/superadmin_verify_email.html.twig', [
            'expires' => $expiresAt,
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
