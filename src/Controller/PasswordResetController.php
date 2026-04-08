<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\PasswordResetToken;
use App\Service\SecurityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/password')]
class PasswordResetController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private MailerInterface $mailer,
        private SecurityLogger $securityLogger,
        private UserPasswordHasherInterface $passwordHasher,
        private LoggerInterface $logger,
        private \App\Service\PasswordPolicyService $passwordPolicy
    ) {}

    #[Route('/forgot', name: 'app_password_forgot', methods: ['GET', 'POST'])]
    public function forgotPassword(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            if (!$email) {
                $this->addFlash('error', 'Por favor ingrese su correo electrónico.');
                return $this->redirectToRoute('app_password_forgot');
            }

            try {
                $user = $this->em->getRepository(User::class)
                    ->findOneBy(['email' => $email]);

                if ($user) {
                    // Invalidar tokens anteriores
                    $this->invalidatePreviousTokens($user);

                    // Crear nuevo token
                    $resetToken = new PasswordResetToken();
                    $resetToken->setUser($user);

                    $this->em->persist($resetToken);
                    $this->em->flush();

                    // Enviar email
                    $this->sendResetEmail($user, $resetToken);

                    $this->securityLogger->log('password_reset_requested', 'INFO', $user, [
                        'email' => $email
                    ]);

                    $this->logger->info('Password reset requested', [
                        'user_id' => $user->getId(),
                        'email' => $email,
                        'timezone' => date_default_timezone_get()
                    ]);
                }

                // Siempre mostrar el mismo mensaje por seguridad
                $this->addFlash('success', 'Si el correo existe, recibirás instrucciones para restablecer tu contraseña.');
                return $this->redirectToRoute('app_login');
            } catch (\Exception $e) {
                $this->logger->error('Error al solicitar restablecimiento de contraseña', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'timezone' => date_default_timezone_get()
                ]);

                $this->addFlash('error', 'Ocurrió un error. Por favor intenta nuevamente.');
                return $this->redirectToRoute('app_password_forgot');
            }
        }

        return $this->render('password/forgot.html.twig');
    }

    #[Route('/reset/{token}', name: 'app_password_reset', methods: ['GET', 'POST'])]
    public function resetPassword(string $token, Request $request): Response
    {
        try {
            $resetToken = $this->em->getRepository(PasswordResetToken::class)
                ->findOneBy(['token' => $token]);

            if (!$resetToken || !$resetToken->isValid()) {
                $this->logger->warning('Token de restablecimiento inválido o expirado', [
                    'token' => substr($token, 0, 10) . '...',
                    'timezone' => date_default_timezone_get()
                ]);

                $this->addFlash('error', 'El enlace de restablecimiento es inválido o ha expirado.');
                return $this->redirectToRoute('app_password_forgot');
            }

            $user = $resetToken->getUser();

            if ($request->isMethod('POST')) {
                $password = $request->request->get('password');
                $passwordConfirm = $request->request->get('password_confirm');

                if (!$password || !$passwordConfirm) {
                    $this->addFlash('error', 'Por favor complete todos los campos.');
                    return $this->redirectToRoute('app_password_reset', ['token' => $token]);
                }

                if ($password !== $passwordConfirm) {
                    $this->addFlash('error', 'Las contraseñas no coinciden.');
                    return $this->redirectToRoute('app_password_reset', ['token' => $token]);
                }

                if (!$this->passwordPolicy->isStrongPassword($password)) {
                    $this->addFlash('error', 'La contraseña no cumple la política de seguridad. Debe tener al menos 12 caracteres, incluir mayúsculas, minúsculas, números y símbolos.');
                    return $this->redirectToRoute('app_password_reset', ['token' => $token]);
                }

                // Actualizar contraseña
                $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
                $user->setPasswordChangedAt(new \DateTime());
                $user->setFailedLoginAttempts(0);
                $user->setAccountLockedUntil(null);

                // Marcar token como usado
                $resetToken->setUsed(true);

                $this->em->flush();

                $this->securityLogger->log('password_reset_completed', 'INFO', $user);

                $this->logger->info('Contraseña restablecida exitosamente', [
                    'user_id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'timezone' => date_default_timezone_get()
                ]);

                $this->addFlash('success', 'Tu contraseña ha sido restablecida exitosamente. Ya puedes iniciar sesión.');
                return $this->redirectToRoute('app_login');
            }

            return $this->render('password/reset.html.twig', [
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            $this->logger->error('Error al restablecer contraseña', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'token' => substr($token, 0, 10) . '...',
                'timezone' => date_default_timezone_get()
            ]);

            $this->addFlash('error', 'Ocurrió un error. Por favor intenta nuevamente.');
            return $this->redirectToRoute('app_password_forgot');
        }
    }

    private function invalidatePreviousTokens(User $user): void
    {
        $previousTokens = $this->em->getRepository(PasswordResetToken::class)
            ->findBy(['user' => $user, 'used' => false]);

        foreach ($previousTokens as $token) {
            $token->setUsed(true);
        }

        $this->em->flush();
    }

    private function sendResetEmail(User $user, PasswordResetToken $resetToken): void
    {
        try {
            $resetUrl = $this->generateUrl('app_password_reset', [
                'token' => $resetToken->getToken()
            ], UrlGeneratorInterface::ABSOLUTE_URL);

            $email = (new TemplatedEmail())
                ->from(new Address('noreply@apusystem.com', 'APU System'))
                ->to(new Address($user->getEmail(), $user->getFullName()))
                ->subject('Restablecimiento de Contraseña - APU System')
                ->htmlTemplate('emails/password_reset.html.twig')
                ->context([
                    'user' => $user,
                    'resetUrl' => $resetUrl,
                    'expiresAt' => $resetToken->getExpiresAt(),
                ]);

            $this->mailer->send($email);

            $this->logger->info('Email de restablecimiento enviado', [
                'user_id' => $user->getId(),
                'email' => $user->getEmail(),
                'timezone' => date_default_timezone_get()
            ]);
        } catch (\Exception $e) {
            $this->logger->error('Error al enviar email de restablecimiento', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->getId(),
                'timezone' => date_default_timezone_get()
            ]);

            throw new \RuntimeException('No se pudo enviar el correo de restablecimiento.');
        }
    }
}
