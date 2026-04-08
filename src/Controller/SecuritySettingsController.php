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
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Obtener sesiones activas
        $activeSessions = $this->em->getRepository(\App\Entity\LoginSession::class)
            ->findBy([
                'user' => $user,
                'isActive' => true
            ], ['lastActivityAt' => 'DESC']);

        // Obtener últimos eventos de seguridad
        $securityEvents = $this->em->getRepository(\App\Entity\SecurityEvent::class)
            ->findBy(
                ['user' => $user],
                ['createdAt' => 'DESC'],
                10
            );

        return $this->render('security/index.html.twig', [
            'user' => $user,
            'activeSessions' => $activeSessions,
            'securityEvents' => $securityEvents,
            'recoveryCodes' => $user->isTotpEnabled() ?
                $this->twoFactorService->getRemainingRecoveryCodesCount($user) : 0,
        ]);
    }

    #[Route('/2fa/enable', name: 'app_security_2fa_enable', methods: ['GET', 'POST'])]
    public function enable2FA(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user->isTotpEnabled()) {
            $this->addFlash('info', 'La autenticación 2FA ya está habilitada.');
            return $this->redirectToRoute('app_security');
        }

        if ($request->isMethod('POST')) {
            // POST: Validar el código con el secret de la sesión
            $secret = $request->getSession()->get('totp_secret');
            $code = $request->request->get('verification_code');

            if (!$secret) {
                $this->addFlash('error', 'Sesión expirada. Por favor, inicia el proceso nuevamente.');
                return $this->redirectToRoute('app_security_2fa_enable');
            }

            if ($this->twoFactorService->enableTotp($user, $secret, $code)) {
                // Generar códigos de recuperación
                $recoveryCodes = $this->twoFactorService->generateRecoveryCodes($user, null);

                $request->getSession()->remove('totp_secret');
                $request->getSession()->set('recovery_codes', $recoveryCodes);

                $this->addFlash('success', 'Autenticación 2FA habilitada exitosamente.');
                return $this->redirectToRoute('app_security_2fa_recovery_codes');
            }

            $this->addFlash('error', 'Código de verificación incorrecto. Intenta nuevamente.');

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

        if (!$user->isTotpEnabled()) {
            $this->addFlash('info', 'La autenticación 2FA no está habilitada.');
            return $this->redirectToRoute('app_security');
        }

        $code = $request->request->get('verification_code');

        if (!$this->twoFactorService->verifyTotpCode($user->getTotpSecret(), $code)) {
            $this->addFlash('error', 'Código de verificación incorrecto.');
            return $this->redirectToRoute('app_security');
        }

        $this->twoFactorService->disableTotp($user);
        $this->securityLogger->log('2fa_disabled', 'WARNING', $user);

        $this->addFlash('success', 'Autenticación 2FA deshabilitada.');
        return $this->redirectToRoute('app_security');
    }

    #[Route('/2fa/recovery-codes', name: 'app_security_2fa_recovery_codes')]
    public function showRecoveryCodes(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $recoveryCodes = $request->getSession()->get('recovery_codes', []);

        if (empty($recoveryCodes)) {
            $this->addFlash('error', 'No hay códigos de recuperación para mostrar.');
            return $this->redirectToRoute('app_security');
        }

        // Limpiar de la sesión después de mostrar
        if ($request->isMethod('POST')) {
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
            $password = $request->request->get('current_password');
            if (!$this->passwordHasher->isPasswordValid($user, $password)) {
                $this->addFlash('error', 'Contraseña incorrecta.');
                return $this->redirectToRoute('app_security');
            }

            $recoveryCodes = $this->twoFactorService->generateRecoveryCodes($user, $user);
            $request->getSession()->set('recovery_codes', $recoveryCodes);
            $this->addFlash('success', 'Se han generado nuevos códigos de recuperación. Revisa tu panel.');

            return $this->redirectToRoute('app_security_2fa_recovery_codes');
        }

        return $this->render('security/regenerate_recovery_codes.html.twig');
    }

    #[Route('/sessions/{id}/revoke', name: 'app_security_session_revoke', methods: ['POST'])]
    public function revokeSession(int $id): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $session = $this->em->getRepository(\App\Entity\LoginSession::class)->find($id);

        if (!$session || $session->getUser()->getId() !== $user->getId()) {
            throw $this->createNotFoundException('Sesión no encontrada.');
        }

        $session->invalidate();
        $this->em->flush();

        $this->securityLogger->log('session_revoked', 'INFO', $user, [
            'session_id' => $session->getSessionId()
        ]);

        $this->addFlash('success', 'Sesión revocada exitosamente.');
        return $this->redirectToRoute('app_security');
    }
}
