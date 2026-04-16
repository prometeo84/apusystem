<?php

namespace App\Controller\Admin;

use App\Entity\LoginSession;
use App\Entity\RememberMeToken;
use App\Service\SessionAnomalyDetector;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sessions')]
class SessionController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private SessionAnomalyDetector $detector) {}

    #[Route('', name: 'app_admin_sessions')]
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $tenant = $user->getTenant();

        $sessions = $this->em->getRepository(LoginSession::class)->findBy(['isActive' => true, 'user' => $user]);
        $tokens = $this->em->getRepository(RememberMeToken::class)->findBy(['user' => $user]);

        // Run anomaly detection for display (non-blocking)
        $anomalies = $this->detector->detectForUser($user);

        return $this->render('admin/sessions.html.twig', [
            'sessions' => $sessions,
            'tokens' => $tokens,
            'anomalies' => $anomalies,
        ]);
    }

    #[Route('/{id}/revoke', name: 'app_admin_session_revoke', methods: ['POST'])]
    public function revoke(int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $session = $this->em->getRepository(LoginSession::class)->find($id);
        if ($session) {
            $session->invalidate();
            $this->em->flush();
            $this->addFlash('success', 'Session invalidated');
        }

        return $this->redirectToRoute('app_admin_sessions');
    }

    #[Route('/bulk-revoke', name: 'app_admin_sessions_bulk_revoke', methods: ['POST'])]
    public function bulkRevoke(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $sessionIds = $request->request->all('session_ids', []);
        $tokenIds = $request->request->all('token_ids', []);

        foreach ($sessionIds as $id) {
            $s = $this->em->getRepository(LoginSession::class)->find((int)$id);
            if ($s) {
                $s->invalidate();
            }
        }

        foreach ($tokenIds as $id) {
            $t = $this->em->getRepository(\App\Entity\RememberMeToken::class)->find((int)$id);
            if ($t) {
                $this->em->remove($t);
            }
        }

        $this->em->flush();

        $this->addFlash('success', 'Selected sessions and tokens revoked');
        return $this->redirectToRoute('app_admin_sessions');
    }

    #[Route('/token/{id}/revoke', name: 'app_admin_token_revoke', methods: ['POST'])]
    public function revokeToken(int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $token = $this->em->getRepository(RememberMeToken::class)->find($id);
        if ($token) {
            $this->em->remove($token);
            $this->em->flush();
            $this->addFlash('success', 'Token revoked');
        }

        return $this->redirectToRoute('app_admin_sessions');
    }
}
