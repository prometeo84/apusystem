<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TwoFactorAuthService;
use App\Service\SecurityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/security')]
#[IsGranted('ROLE_USER')]
class SecuritySettingsController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private TwoFactorAuthService $twoFactorService,
        private SecurityLogger $securityLogger,
        private \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $passwordHasher
    ) {}

    #[Route('', name: 'app_security')]
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Obtener sesiones activas con paginación
        $sessionRepo = $this->em->getRepository(\App\Entity\LoginSession::class);
        $sessionsPage = max(1, (int)$request->query->get('sessions_page', 1));
        $sessionsPerPage = 10;
        $totalSessions = $sessionRepo->count([
            'user' => $user,
            'isActive' => true
        ]);
        $sessionsOffset = ($sessionsPage - 1) * $sessionsPerPage;
        $activeSessions = $sessionRepo->findBy([
            'user' => $user,
            'isActive' => true
        ], ['lastActivityAt' => 'DESC'], $sessionsPerPage, $sessionsOffset);
        $sessionsTotalPages = $sessionsPerPage > 0 ? (int)ceil($totalSessions / $sessionsPerPage) : 1;


        // Obtener últimos eventos de seguridad con paginación
        $eventsRepo = $this->em->getRepository(\App\Entity\SecurityEvent::class);
        $eventsPage = max(1, (int)$request->query->get('events_page', 1));
        $eventsPerPage = 10;
        $totalEvents = $eventsRepo->count(['user' => $user]);
        $eventsOffset = ($eventsPage - 1) * $eventsPerPage;
        $securityEvents = $eventsRepo->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            $eventsPerPage,
            $eventsOffset
        );
        $eventsTotalPages = $eventsPerPage > 0 ? (int)ceil($totalEvents / $eventsPerPage) : 1;

        return $this->render('security/index.html.twig', [
            'user' => $user,
            'activeSessions' => $activeSessions,
            'securityEvents' => $securityEvents,
            'recoveryCodes' => $user->isTotpEnabled() ?
                $this->twoFactorService->getRemainingRecoveryCodesCount($user) : 0,
            'sessions_page' => $sessionsPage,
            'sessions_total_pages' => $sessionsTotalPages,
            'events_page' => $eventsPage,
            'events_total_pages' => $eventsTotalPages,
        ]);
    }

    #[Route('/2fa/enable', name: 'app_security_2fa_enable', methods: ['GET', 'POST'])]
    public function enable2FA(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user->isTotpEnabled()) {
            $this->addFlash('info', 'flash.2fa_already_enabled');
            return $this->redirectToRoute('app_security');
        }

        if ($request->isMethod('POST')) {
            // Validar CSRF
            if (!$this->isCsrfTokenValid('2fa_enable', $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_security_2fa_enable');
            }

            // POST: Validar el código con el secret de la sesión
            $secret = $request->getSession()->get('totp_secret');
            $code = $request->request->get('verification_code');

            if (!$secret) {
                $this->addFlash('error', 'flash.session_expired');
                return $this->redirectToRoute('app_security_2fa_enable');
            }

            if ($this->twoFactorService->enableTotp($user, $secret, $code)) {
                // Generar códigos de recuperación
                $recoveryCodes = $this->twoFactorService->generateRecoveryCodes($user, null);

                $request->getSession()->remove('totp_secret');
                $request->getSession()->set('recovery_codes', $recoveryCodes);

                $this->addFlash('success', 'flash.2fa_enabled');
                return $this->redirectToRoute('app_security_2fa_recovery_codes');
            }

            $this->addFlash('error', 'flash.code_incorrect_try_again');

            // Regenerar QR code para mostrar en caso de error
            $qrCode = $this->twoFactorService->generateQrCode($user, $secret);

            return $this->render('security/enable_2fa.html.twig', [
                'user' => $user,
                'qrCode' => $qrCode,
                'secret' => $secret,
            ]);
        }

        // GET: Generar nuevo secret y QR code
        $secret = $this->twoFactorService->generateTotpSecret();
        $request->getSession()->set('totp_secret', $secret);

        // Generar QR code
        $qrCode = $this->twoFactorService->generateQrCode($user, $secret);

        return $this->render('security/enable_2fa.html.twig', [
            'user' => $user,
            'qrCode' => $qrCode,
            'secret' => $secret,
        ]);
    }

    #[Route('/2fa/disable', name: 'app_security_2fa_disable', methods: ['POST'])]
    public function disable2FA(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$this->isCsrfTokenValid('2fa_disable', $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_security');
        }

        if (!$user->isTotpEnabled()) {
            $this->addFlash('info', 'flash.2fa_not_enabled');
            return $this->redirectToRoute('app_security');
        }

        $code = $request->request->get('verification_code');

        if (!$this->twoFactorService->verifyTotpCode($user->getTotpSecret(), $code)) {
            $this->addFlash('error', 'flash.code_incorrect');
            return $this->redirectToRoute('app_security');
        }

        $this->twoFactorService->disableTotp($user);
        $this->securityLogger->log('2fa_disabled', 'WARNING', $user);

        $this->addFlash('success', 'flash.2fa_disabled');
        return $this->redirectToRoute('app_security');
    }

    #[Route('/2fa/recovery-codes', name: 'app_security_2fa_recovery_codes')]
    public function showRecoveryCodes(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $recoveryCodes = $request->getSession()->get('recovery_codes', []);

        if (empty($recoveryCodes)) {
            $this->addFlash('error', 'flash.no_recovery_codes');
            return $this->redirectToRoute('app_security');
        }

        // Limpiar de la sesión después de mostrar
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('recovery_codes_dismiss', $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_security');
            }
            $request->getSession()->remove('recovery_codes');
            return $this->redirectToRoute('app_security');
        }

        return $this->render('security/recovery_codes.html.twig', [
            'user' => $user,
            'recoveryCodes' => $recoveryCodes,
        ]);
    }

    #[Route('/2fa/recovery-codes/regenerate', name: 'app_security_2fa_recovery_codes_regenerate', methods: ['GET', 'POST'])]
    public function regenerateRecoveryCodes(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('regenerate_recovery', $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_security');
            }

            $password = $request->request->get('current_password');
            if (!$this->passwordHasher->isPasswordValid($user, $password)) {
                $this->addFlash('error', 'flash.password_incorrect');
                return $this->redirectToRoute('app_security');
            }

            $recoveryCodes = $this->twoFactorService->generateRecoveryCodes($user, $user);
            $request->getSession()->set('recovery_codes', $recoveryCodes);
            $this->addFlash('success', 'flash.recovery_codes_generated');

            return $this->redirectToRoute('app_security_2fa_recovery_codes');
        }

        return $this->render('security/regenerate_recovery_codes.html.twig');
    }

    #[Route('/sessions/{id}/revoke', name: 'app_security_session_revoke', methods: ['POST'])]
    public function revokeSession(Request $request, int $id): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $session = $this->em->getRepository(\App\Entity\LoginSession::class)->find($id);

        if (!$session || $session->getUser()->getId() !== $user->getId()) {
            throw $this->createNotFoundException('Sesión no encontrada.');
        }

        // Verificar token CSRF
        $token = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('revoke_session' . $session->getId(), $token)) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_security');
        }

        $session->invalidate();
        $this->em->flush();

        $this->securityLogger->log('session_revoked', 'INFO', $user, [
            'session_id' => $session->getSessionId()
        ]);

        $this->addFlash('success', 'flash.session_revoked');
        return $this->redirectToRoute('app_security');
    }
}
