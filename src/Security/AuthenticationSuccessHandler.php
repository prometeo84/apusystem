<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\LoginSession;
use App\Service\SecurityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
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
        private SecurityLogger $securityLogger,
        private MailerInterface $mailer
    ) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof User) {
            return new RedirectResponse($this->router->generate('app_login'));
        }

        // Antes de crear sesión: verificar bloqueos por IP y aplicar rate-limit
        $ipAddress = $request->getClientIp() ?? '0.0.0.0';
        // Verificar IP bloqueada
        try {
            $blocked = $this->em->getRepository(\App\Entity\BlockedIp::class)->findOneBy(['ipAddress' => $ipAddress]);
            if ($blocked && method_exists($blocked, 'isBlocked') && $blocked->isBlocked()) {
                // Registrar intento y redirigir a login con mensaje
                $this->securityLogger->log('blocked_ip_login_attempt', 'WARNING', $user, ['ip' => $ipAddress]);
                $request->getSession()->getFlashBag()->add('error', 'auth.too_many_attempts');
                return new RedirectResponse($this->router->generate('app_login'));
            }
        } catch (\Throwable $e) {
            // Ignore lookup errors
        }

        // Rate-limit: si hay muchas sesiones creadas desde esta IP en el último minuto, bloquear temporalmente
        try {
            $cutoff = new \DateTime('-1 minute');
            $qb = $this->em->createQueryBuilder();
            $qb->select('COUNT(ls.id)')
                ->from(LoginSession::class, 'ls')
                ->where('ls.ipAddress = :ip')
                ->andWhere('ls.createdAt > :cutoff')
                ->setParameter('ip', $ipAddress)
                ->setParameter('cutoff', $cutoff);
            $countRecent = (int)$qb->getQuery()->getSingleScalarResult();
            if ($countRecent > 20) {
                // Crear bloqueo temporal de 1 hora
                $blockedIp = new \App\Entity\BlockedIp($ipAddress, 'rate_limit_exceeded', 'automatic');
                $blockedIp->setBlockedUntil((new \DateTime('+1 hour')));
                $blockedIp->setRiskScore(80);
                $this->em->persist($blockedIp);
                $this->em->flush();

                $this->securityLogger->log('ip_blocked_rate_limit', 'WARNING', $user, ['ip' => $ipAddress, 'count' => $countRecent]);
                $request->getSession()->getFlashBag()->add('error', 'auth.too_many_attempts');
                return new RedirectResponse($this->router->generate('app_login'));
            }
        } catch (\Throwable $e) {
            // ignore
        }

        // Actualizar información de último login
        $user->updateLastLogin($ipAddress);

        // Crear sesión de login
        $sessionId = $request->getSession()->getId();
        $userAgent = $request->headers->get('User-Agent') ?? 'Unknown';

        $lifetime = (int) (getenv('SESSION_LIFETIME') ?: 10800); // 3 horas por defecto

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

        // Si es super admin, enviar código por correo y requerir verificación adicional
        $roles = $user->getRoles();
        $isSuper = in_array('ROLE_SUPER_ADMIN', $roles, true);

        if ($isSuper) {
            // Generar un único código, enviar por email y guardar hash en sesión
            $code = random_int(100000, 999999);

            $hash = password_hash((string)$code, PASSWORD_DEFAULT);

            $request->getSession()->set('superadmin_email_code_hash', $hash);
            $request->getSession()->set('superadmin_email_sent_at', (new \DateTime())->format(DATE_ATOM));
            $request->getSession()->set('superadmin_email_expires_at', (new \DateTime('+10 minutes'))->format(DATE_ATOM));

            // Enviar correo con el código usando plantilla HTML con estilos del sistema
            try {
                $expiresAt = (new \DateTime('+10 minutes'));

                $templated = (new TemplatedEmail())
                    ->from(new Address(getenv('MAILER_FROM_ADDRESS') ?: 'noreply@apusystem.com', getenv('MAILER_FROM_NAME') ?: 'APU System'))
                    ->to(new Address($user->getEmail(), $user->getFullName()))
                    ->subject('Código de acceso — APU System')
                    ->htmlTemplate('emails/superadmin_code.html.twig')
                    ->textTemplate('emails/superadmin_code.txt.twig')
                    ->context([
                        'user' => $user,
                        'code' => $code,
                        'expires' => $expiresAt,
                        'primary_color' => $user->getThemePrimaryColor() ?? '#667eea',
                        'secondary_color' => $user->getThemeSecondaryColor() ?? '#764ba2',
                    ]);

                $this->mailer->send($templated);
            } catch (\Throwable $e) {
                // No cortar el flujo si falla el correo; dejar la comprobación activa
            }
        }

        // Si tiene 2FA habilitado, redirigir a verificación
        if ($user->isTwoFactorEnabled()) {
            return new RedirectResponse($this->router->generate('app_2fa_verify'));
        }

        // Marcar 2FA como verificado (ya que no está habilitado)
        $request->getSession()->set('2fa_verified', true);

        // Registrar timestamp de autenticación completa
        $request->getSession()->set('last_full_auth', (new \DateTimeImmutable())->getTimestamp());

        // Si es superadmin y hay un email pendiente, redirigir a verificación de email
        if ($isSuper && $request->getSession()->get('superadmin_email_code_hash')) {
            return new RedirectResponse($this->router->generate('app_superadmin_verify_email'));
        }

        // Redirigir al dashboard
        return new RedirectResponse($this->router->generate('app_dashboard'));
    }
}
