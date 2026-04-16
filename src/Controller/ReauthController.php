<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class ReauthController extends AbstractController
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    #[Route('/reauth', name: 'app_reauth')]
    public function reauth(Request $request): Response
    {
        $user = $this->getUser();
        if (!$user || !($user instanceof PasswordAuthenticatedUserInterface)) {
            return $this->redirectToRoute('app_login');
        }

        $session = $request->getSession();
        $target = $session->get('reauth_target', $this->generateUrl('app_dashboard'));

        if ($request->isMethod('POST')) {
            $password = (string) $request->request->get('password', '');

            if ($this->passwordHasher->isPasswordValid($user, $password)) {
                $session->set('last_full_auth', (new \DateTimeImmutable())->getTimestamp());
                $session->remove('reauth_target');
                return $this->redirect($target);
            }

            $this->addFlash('error', 'flash.password_incorrect');
        }

        return $this->render('security/reauth.html.twig', [
            'target' => $target,
        ]);
    }
}
