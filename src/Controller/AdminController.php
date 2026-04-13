<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tenant;
use App\Service\SecurityLogger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SecurityLogger $securityLogger,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    #[Route('', name: 'app_admin')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $tenant = $user->getTenant();

        // Estadísticas
        $totalUsers = $this->em->getRepository(User::class)
            ->count(['tenant' => $tenant]);

        $activeUsers = $this->em->getRepository(User::class)
            ->count(['tenant' => $tenant, 'isActive' => true]);

        $users2FA = $this->em->getRepository(User::class)
            ->count(['tenant' => $tenant, 'totpEnabled' => true]);

        $eventsToday = $this->em->getRepository(\App\Entity\SecurityEvent::class)
            ->createQueryBuilder('se')
            ->select('COUNT(se.id)')
            ->where('se.tenant = :tenant')
            ->andWhere('se.createdAt >= :today')
            ->setParameter('tenant', $tenant)
            ->setParameter('today', new \DateTime('today'))
            ->getQuery()
            ->getSingleScalarResult();

        // Eventos recientes (últimas 24 horas)
        $last24h = new \DateTime('-24 hours');
        $recentEvents = $this->em->getRepository(\App\Entity\SecurityEvent::class)
            ->createQueryBuilder('se')
            ->where('se.tenant = :tenant')
            ->andWhere('se.createdAt >= :date')
            ->setParameter('tenant', $tenant)
            ->setParameter('date', $last24h)
            ->orderBy('se.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        return $this->render('admin/index.html.twig', [
            'user' => $user,
            'tenant' => $tenant,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'users2FA' => $users2FA,
            'eventsToday' => $eventsToday,
            'recentEvents' => $recentEvents,
        ]);
    }

    #[Route('/users', name: 'app_admin_users')]
    public function users(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $tenant = $user->getTenant();

        $perPage = 20;
        $currentPage = max(1, (int) $request->query->get('page', 1));

        $repo  = $this->em->getRepository(User::class);
        $total = $repo->count(['tenant' => $tenant]);
        $users = $repo->findBy(
            ['tenant' => $tenant],
            ['createdAt' => 'DESC'],
            $perPage,
            ($currentPage - 1) * $perPage
        );
        $totalPages = (int) ceil($total / $perPage);

        return $this->render('admin/users.html.twig', [
            'user'        => $user,
            'users'       => $users,
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'totalItems'  => $total,
            'perPage'     => $perPage,
        ]);
    }

    #[Route('/users/create', name: 'app_admin_users_create', methods: ['GET', 'POST'])]
    public function createUser(Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $tenant = $currentUser->getTenant();

        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $username = $request->request->get('username');
            $firstName = $request->request->get('first_name');
            $lastName = $request->request->get('last_name');
            $password = $request->request->get('password');
            $role = $request->request->get('role', 'user');

            // Validar campos
            if (!$email || !$username || !$firstName || !$lastName || !$password) {
                $this->addFlash('error', 'flash.all_fields_required');
                return $this->redirectToRoute('app_admin_users_create');
            }

            // Verificar límite de usuarios del tenant
            $userCount = $this->em->getRepository(User::class)->count(['tenant' => $tenant]);
            if ($userCount >= $tenant->getMaxUsers()) {
                $this->addFlash('error', 'flash.tenant_user_limit_reached');
                return $this->redirectToRoute('app_admin_users_create');
            }

            // Verificar si el email ya existe en el tenant
            $existingUser = $this->em->getRepository(User::class)
                ->findOneBy(['tenant' => $tenant, 'email' => $email]);

            if ($existingUser) {
                $this->addFlash('error', 'flash.email_exists');
                return $this->redirectToRoute('app_admin_users_create');
            }

            // Crear usuario
            $newUser = new User();
            $newUser->setTenant($tenant);
            $newUser->setEmail($email);
            $newUser->setUsername($username);
            $newUser->setFirstName($firstName);
            $newUser->setLastName($lastName);
            $newUser->setRole($role);

            $hashedPassword = $this->passwordHasher->hashPassword($newUser, $password);
            $newUser->setPassword($hashedPassword);

            $this->em->persist($newUser);
            $this->em->flush();

            $this->securityLogger->log('user_created', 'INFO', $currentUser, [
                'new_user_id' => $newUser->getId(),
                'new_user_email' => $newUser->getEmail()
            ]);

            $this->addFlash('success', 'flash.user_created');
            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/users_create.html.twig', [
            'user' => $currentUser,
        ]);
    }

    #[Route('/users/{id}/edit', name: 'app_admin_users_edit', methods: ['GET', 'POST'])]
    public function editUser(int $id, Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $tenant = $currentUser->getTenant();

        $userToEdit = $this->em->getRepository(User::class)->find($id);

        if (!$userToEdit || $userToEdit->getTenant()->getId() !== $tenant->getId()) {
            throw $this->createNotFoundException('Usuario no encontrado.');
        }

        if ($request->isMethod('POST')) {
            $firstName = $request->request->get('first_name');
            $lastName = $request->request->get('last_name');
            $role = $request->request->get('role');
            $isActive = $request->request->get('is_active') === '1';

            $userToEdit->setFirstName($firstName);
            $userToEdit->setLastName($lastName);
            $userToEdit->setRole($role);
            $userToEdit->setIsActive($isActive);

            $this->em->flush();

            $this->securityLogger->log('user_edited', 'INFO', $currentUser, [
                'edited_user_id' => $userToEdit->getId(),
                'edited_user_email' => $userToEdit->getEmail()
            ]);

            $this->addFlash('success', 'flash.user_updated');
            return $this->redirectToRoute('app_admin_users');
        }

        return $this->render('admin/users_edit.html.twig', [
            'user' => $currentUser,
            'editUser' => $userToEdit,
        ]);
    }

    #[Route('/users/{id}/toggle', name: 'app_admin_users_toggle', methods: ['POST'])]
    public function toggleUser(int $id): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $tenant = $currentUser->getTenant();

        $userToToggle = $this->em->getRepository(User::class)->find($id);

        if (!$userToToggle || $userToToggle->getTenant()->getId() !== $tenant->getId()) {
            throw $this->createNotFoundException('Usuario no encontrado.');
        }

        if ($userToToggle->getId() === $currentUser->getId()) {
            $this->addFlash('error', 'flash.cannot_deactivate_self');
            return $this->redirectToRoute('app_admin_users');
        }

        $userToToggle->setIsActive(!$userToToggle->isActive());
        $this->em->flush();

        $action = $userToToggle->isActive() ? 'activado' : 'desactivado';
        $this->addFlash('success', $this->container->get('translator')->trans('flash.user_toggled', ['%action%' => $action]));

        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/logs', name: 'app_admin_logs')]
    public function logs(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $tenant = $user->getTenant();

        $validSeverities = ['INFO', 'WARNING', 'CRITICAL'];
        $severity = strtoupper((string) $request->query->get('severity', ''));
        $severity = in_array($severity, $validSeverities, true) ? $severity : '';

        $criteria = ['tenant' => $tenant];
        if ($severity !== '') {
            $criteria['severity'] = $severity;
        }

        $perPage = 20;
        $totalEvents = $this->em->getRepository(\App\Entity\SecurityEvent::class)
            ->count($criteria);
        $totalPages = max(1, (int) ceil($totalEvents / $perPage));

        $page = max(1, min($totalPages, (int) $request->query->get('page', 1)));
        $offset = ($page - 1) * $perPage;

        $securityEvents = $this->em->getRepository(\App\Entity\SecurityEvent::class)
            ->findBy(
                $criteria,
                ['createdAt' => 'DESC'],
                $perPage,
                $offset
            );

        return $this->render('admin/logs.html.twig', [
            'user' => $user,
            'securityEvents' => $securityEvents,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalEvents' => $totalEvents,
            'perPage' => $perPage,
            'activeSeverity' => $severity,
        ]);
    }

    #[Route('/tenant', name: 'app_admin_tenant', methods: ['GET', 'POST'])]
    public function tenantSettings(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!in_array('ROLE_SUPER_ADMIN', $user->getRoles())) {
            throw $this->createAccessDeniedException('Solo super administradores pueden editar la configuración del tenant.');
        }

        // Por defecto trabajamos sobre el tenant del usuario
        $tenant = $user->getTenant();

        // Si el superadmin indica un tenant_id (sólo mediante GET), cargar ese tenant
        // El POST nunca cambia el tenant activo para evitar manipulación cross-tenant
        $requestedTenantId = $request->query->get('tenant_id');
        if ($requestedTenantId) {
            $candidate = $this->em->getRepository(Tenant::class)->find((int) $requestedTenantId);
            if ($candidate) {
                $tenant = $candidate;
            }
        }

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $timezone = $request->request->get('timezone');
            $currency = $request->request->get('currency');

            $tenant->setName($name);
            $tenant->setTimezone($timezone);
            $tenant->setCurrency($currency);

            $this->em->flush();

            $this->addFlash('success', 'flash.tenant_settings_updated');
            return $this->redirectToRoute('app_admin_tenant', ['tenant_id' => $tenant->getId()]);
        }

        // Para superadmins mostramos lista de tenants para poder elegir
        $allTenants = $this->em->getRepository(Tenant::class)->findBy([], ['name' => 'ASC']);

        return $this->render('admin/tenant.html.twig', [
            'user' => $user,
            'tenant' => $tenant,
            'allTenants' => $allTenants,
        ]);
    }
}
