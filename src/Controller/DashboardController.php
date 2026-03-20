<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    #[Route('/', name: 'app_dashboard')]
    #[Route('/dashboard', name: 'app_dashboard_alt')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        // Si es super_admin, redirigir al dashboard del sistema
        if (in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('app_system');
        }

        $tenant = $user->getTenant();

        // Estadísticas para usuarios de empresa
        $stats = [
            'total_proyectos' => $this->em->getRepository(\App\Entity\Proyecto::class)
                ->count(['tenant' => $tenant]),
            'proyectos_activos' => $this->em->getRepository(\App\Entity\Proyecto::class)
                ->count(['tenant' => $tenant, 'estado' => 'en_proceso']),
            'total_apus' => $this->em->getRepository(\App\Entity\Apu::class)
                ->count(['tenant' => $tenant]),
            'total_plantillas' => 0, // Implementar cuando exista la entidad
        ];

        // Proyectos recientes
        $proyectosRecientes = $this->em->getRepository(\App\Entity\Proyecto::class)
            ->findBy(['tenant' => $tenant], ['createdAt' => 'DESC'], 5);

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'tenant' => $tenant,
            'stats' => $stats,
            'proyectosRecientes' => $proyectosRecientes,
        ]);
    }
}
