<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator
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
        $isAdmin = in_array('ROLE_ADMIN', $user->getRoles(), true) || in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true);

        if ($isAdmin) {
            // Para administradores: contar proyectos, plantillas y APUs creados por/para el admin (created_by)
            $projectRepo = $this->em->getRepository(\App\Entity\Projects::class);
            $userProjects = $projectRepo->findBy(['tenant' => $tenant, 'createdBy' => $user]);
            $projectIds = array_map(fn($p) => $p->getId(), $userProjects);

            $totalProyectos = count($userProjects);
            $proyectosActivos = $projectRepo->count(['tenant' => $tenant, 'status' => 'en_proceso', 'createdBy' => $user]);

            // Plantillas asociadas a los proyectos del admin
            $totalPlantillas = 0;
            if (count($projectIds) > 0) {
                $qb = $this->em->createQueryBuilder()
                    ->select('count(t.id)')
                    ->from(\App\Entity\Template::class, 't')
                    ->where('t.project IN (:ids)')
                    ->setParameter('ids', $projectIds);
                $totalPlantillas = (int) $qb->getQuery()->getSingleScalarResult();
            }

            // APUs vinculadas a proyectos del admin
            $totalApus = 0;
            if (count($projectIds) > 0) {
                $qb2 = $this->em->createQueryBuilder()
                    ->select('count(a.id)')
                    ->from(\App\Entity\Apu::class, 'a')
                    ->where('a.project IN (:ids)')
                    ->setParameter('ids', $projectIds);
                $totalApus = (int) $qb2->getQuery()->getSingleScalarResult();
            }

            $stats = [
                'total_proyectos' => $totalProyectos,
                'proyectos_activos' => $proyectosActivos,
                'total_apus' => $totalApus,
                'total_plantillas' => $totalPlantillas,
            ];
        } else {
            $stats = [
                'total_proyectos' => $this->em->getRepository(\App\Entity\Projects::class)
                    ->count(['tenant' => $tenant]),
                'proyectos_activos' => $this->em->getRepository(\App\Entity\Projects::class)
                    ->count(['tenant' => $tenant, 'status' => 'en_proceso']),
                'total_apus' => $this->em->getRepository(\App\Entity\Apu::class)
                    ->count(['tenant' => $tenant]),
                'total_plantillas' => $this->em->getRepository(\App\Entity\Template::class)
                    ->count(['tenant' => $tenant]),
            ];
        }

        // Proyectos recientes
        $proyectosRecientes = $this->em->getRepository(\App\Entity\Projects::class)
            ->findBy(['tenant' => $tenant], ['createdAt' => 'DESC'], 5);

        // Alertas administrativas: avisar si el uso está cerca del límite
        $isAdmin = in_array('ROLE_ADMIN', $user->getRoles(), true) || in_array('ROLE_SUPER_ADMIN', $user->getRoles(), true);
        $canCreateProject = true;
        $canCreateUser = true;
        $canCreateApu = true;

        if ($isAdmin) {
            $projectCount = $stats['total_proyectos'];
            $maxProjects = $tenant->getMaxProjects();
            if ($maxProjects > 0) {
                $ratio = $projectCount / $maxProjects;
                // Do not show a hard error on dashboard when limit exceeded; only warn when near
                if ($ratio >= 0.8) {
                    $this->addFlash('warning', $this->translator->trans('project.limit_near', ['%current%' => $projectCount, '%limit%' => $maxProjects]));
                }
                $canCreateProject = $projectCount < $maxProjects;
            }

            $userCount = $this->em->getRepository(User::class)->count(['tenant' => $tenant]);
            $maxUsers = $tenant->getMaxUsers();
            if ($maxUsers > 0) {
                $uRatio = $userCount / $maxUsers;
                if ($uRatio >= 0.8) {
                    $this->addFlash('warning', $this->translator->trans('user.limit_near', ['%current%' => $userCount, '%limit%' => $maxUsers]));
                }
                $canCreateUser = $userCount < $maxUsers;
            }

            // APU create availability based on optional config limit
            $apuCount = $stats['total_apus'];
            $maxApus = $this->getParameter('limits.apus_per_tenant');
            if ($maxApus !== null && (int)$maxApus > 0) {
                if ($apuCount / (int)$maxApus >= 0.8) {
                    $this->addFlash('warning', $this->translator->trans('apu.limit_near', ['%current%' => $apuCount, '%limit%' => $maxApus]));
                }
                $canCreateApu = $apuCount < (int)$maxApus;
            }
        }

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'tenant' => $tenant,
            'stats' => $stats,
            'proyectosRecientes' => $proyectosRecientes,
            'can_create_project' => $canCreateProject,
            'can_create_user' => $canCreateUser,
            'can_create_apu' => $canCreateApu,
            'max_apus_limit' => $maxApus ?? null,
        ]);
    }
}
