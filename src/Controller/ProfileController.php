<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\SecurityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profile')]
#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SecurityLogger $securityLogger,
        private UserPasswordHasherInterface $passwordHasher,
        private \App\Service\PasswordPolicyService $passwordPolicy
    ) {}

    #[Route('', name: 'app_profile')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'tenant' => $user->getTenant(),
        ]);
    }

    #[Route('/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $firstName = $request->request->get('first_name');
            $lastName = $request->request->get('last_name');
            $phone = $request->request->get('phone');

            if ($firstName && $lastName) {
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setPhone($phone);

                // Manejar carga de avatar
                $avatarFile = $request->files->get('avatar');
                if ($avatarFile) {
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    $extension = strtolower($avatarFile->getClientOriginalExtension());

                    if (in_array($extension, $allowedExtensions)) {
                        $maxSize = 2 * 1024 * 1024; // 2MB
                        if ($avatarFile->getSize() <= $maxSize) {
                            $uploadsDir = $this->getParameter('kernel.project_dir') . '/public/uploads/avatars';

                            // Crear directorio si no existe
                            if (!is_dir($uploadsDir)) {
                                mkdir($uploadsDir, 0755, true);
                            }

                            // Eliminar avatar anterior si existe
                            if ($user->getAvatar()) {
                                $oldFile = $this->getParameter('kernel.project_dir') . '/public' . $user->getAvatar();
                                if (file_exists($oldFile)) {
                                    unlink($oldFile);
                                }
                            }

                            // Generar nombre único
                            $filename = 'avatar_' . $user->getId() . '_' . time() . '.' . $extension;
                            $avatarFile->move($uploadsDir, $filename);

                            $user->setAvatar('/uploads/avatars/' . $filename);
                        } else {
                            $this->addFlash('error', 'flash.avatar_too_large');
                            return $this->redirectToRoute('app_profile_edit');
                        }
                    } else {
                        $this->addFlash('error', 'flash.invalid_avatar_format');
                        return $this->redirectToRoute('app_profile_edit');
                    }
                }

                $this->em->flush();

                $this->addFlash('success', 'flash.profile_updated');
                return $this->redirectToRoute('app_profile');
            }

            $this->addFlash('error', 'flash.fill_required_fields');
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/change-password', name: 'app_profile_change_password', methods: ['GET', 'POST'])]
    public function changePassword(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $currentPassword = $request->request->get('current_password');
            $newPassword = $request->request->get('new_password');
            $confirmPassword = $request->request->get('confirm_password');

            // Verificar contraseña actual
            if (!$this->passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'flash.current_password_incorrect');
                return $this->redirectToRoute('app_profile_change_password');
            }

            // Verificar que las contraseñas coincidan
            if ($newPassword !== $confirmPassword) {
                $this->addFlash('error', 'flash.passwords_do_not_match');
                return $this->redirectToRoute('app_profile_change_password');
            }

            // Verificar política de contraseña
            if (!$this->passwordPolicy->isStrongPassword($newPassword)) {
                $this->addFlash('error', 'flash.password_policy_not_met');
                return $this->redirectToRoute('app_profile_change_password');
            }

            // Actualizar contraseña
            $hashedPassword = $this->passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);
            $user->setPasswordChangedAt(new \DateTime());
            $this->em->flush();

            // Log security event
            $this->securityLogger->log(
                'password_changed',
                'INFO',
                $user,
                ['ip' => $request->getClientIp()]
            );

            $this->addFlash('success', 'flash.password_changed');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/change_password.html.twig');
    }

    #[Route('/preferences', name: 'app_profile_preferences', methods: ['GET', 'POST'])]
    public function preferences(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
            $locale = $request->request->get('locale');
            $timezone = $request->request->get('timezone');
            $themePrimaryColor = $request->request->get('theme_primary_color');
            $themeSecondaryColor = $request->request->get('theme_secondary_color');
            $themeMode = $request->request->get('theme_mode');

            // Validar locale
            if (in_array($locale, ['es', 'en'])) {
                $user->setLocale($locale);
                $request->getSession()->set('_locale', $locale);
            }

            // Validar y actualizar timezone
            if ($timezone && in_array($timezone, timezone_identifiers_list())) {
                $user->setTimezone($timezone);
            }

            // Validar colores hex
            if ($themePrimaryColor && preg_match('/^#[0-9A-Fa-f]{6}$/', $themePrimaryColor)) {
                $user->setThemePrimaryColor($themePrimaryColor);
            }

            if ($themeSecondaryColor && preg_match('/^#[0-9A-Fa-f]{6}$/', $themeSecondaryColor)) {
                $user->setThemeSecondaryColor($themeSecondaryColor);
            }

            // Validar theme mode
            if (in_array($themeMode, ['light', 'dark', 'auto'])) {
                $user->setThemeMode($themeMode);
            }

            $this->em->flush();

            $this->addFlash('success', 'flash.preferences_updated');
            return $this->redirectToRoute('app_profile_preferences');
        }

        return $this->render('profile/preferences.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/reset-theme', name: 'app_profile_reset_theme', methods: ['POST'])]
    public function resetTheme(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $user->setThemePrimaryColor('#667eea');
        $user->setThemeSecondaryColor('#764ba2');
        $user->setThemeMode('light');

        $this->em->flush();

        $this->addFlash('success', 'flash.theme_reset');
        return $this->redirectToRoute('app_profile_preferences');
    }
}
