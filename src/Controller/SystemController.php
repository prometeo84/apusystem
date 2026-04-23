<?php

namespace App\Controller;

use App\Entity\SecurityEvent;
use App\Entity\User;
use App\Entity\LoginSession;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/system')]
#[IsGranted('ROLE_SUPER_ADMIN')]
class SystemController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator
    ) {}

    #[Route('', name: 'app_system')]
    public function index(): Response
    {
        // Estadísticas globales del sistema
        $stats = [
            'total_tenants' => $this->em->getRepository(\App\Entity\Tenant::class)->count([]),
            'active_tenants' => $this->em->getRepository(\App\Entity\Tenant::class)->count(['isActive' => true]),
            'total_users' => $this->em->getRepository(User::class)->count([]),
            'active_users' => $this->em->getRepository(User::class)->count(['isActive' => true]),
            'users_2fa' => $this->em->getRepository(User::class)->count(['totpEnabled' => true]),
            'active_sessions' => $this->em->getRepository(LoginSession::class)->count(['isActive' => true]),
        ];

        // Eventos críticos recientes
        $criticalEvents = $this->em->getRepository(SecurityEvent::class)
            ->findBy(
                ['severity' => 'CRITICAL'],
                ['createdAt' => 'DESC'],
                10
            );

        // Eventos de las últimas 24 horas
        $last24h = new \DateTime('-24 hours');
        $recentEvents = $this->em->getRepository(SecurityEvent::class)
            ->createQueryBuilder('se')
            ->where('se.createdAt >= :date')
            ->setParameter('date', $last24h)
            ->orderBy('se.createdAt', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();

        // Tenants más activos
        $activeTenants = $this->em->getRepository(\App\Entity\Tenant::class)
            ->findBy(['isActive' => true], ['createdAt' => 'DESC'], 5);

        return $this->render('system/index.html.twig', [
            'stats' => $stats,
            'criticalEvents' => $criticalEvents,
            'recentEvents' => $recentEvents,
            'activeTenants' => $activeTenants,
        ]);
    }

    #[Route('/monitoring', name: 'app_system_monitoring')]
    public function monitoring(): Response
    {
        // Monitoreo en tiempo real
        $monitoring = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'sessions' => $this->checkSessions(),
            'disk_usage' => $this->checkDiskUsage(),
        ];

        // Errores recientes del log
        $errors = $this->getRecentErrors();

        return $this->render('system/monitoring.html.twig', [
            'monitoring' => $monitoring,
            'errors' => $errors,
        ]);
    }

    #[Route('/errors', name: 'app_system_errors')]
    public function errors(): Response
    {
        // Leer errores del log de Symfony
        $logFile = $this->getParameter('kernel.logs_dir') . '/dev.log';
        $errors = [];

        if (file_exists($logFile)) {
            $errors = $this->parseLogFile($logFile);
        }

        return $this->render('system/errors.html.twig', [
            'errors' => $errors,
        ]);
    }

    #[Route('/alerts', name: 'app_system_alerts')]
    public function alerts(): Response
    {
        // Alertas del sistema
        $alerts = [];

        // 1. ALERTAS DE CONEXIONES SOSPECHOSAS - PRIORIDAD ALTA
        $suspiciousLogins = $this->em->getRepository(SecurityEvent::class)
            ->createQueryBuilder('se')
            ->where('se.eventType = :type')
            ->andWhere('se.createdAt > :last24h')
            ->setParameter('type', 'session_anomaly_detected')
            ->setParameter('last24h', new \DateTime('-24 hours'))
            ->orderBy('se.createdAt', 'DESC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();

        foreach ($suspiciousLogins as $event) {
            $details = $event->getDetails() ?? [];
            $anomalies = $details['anomalies'] ?? [];
            $score = $details['score'] ?? 0;

            $anomalyText = [];
            if (in_array('ip_change', $anomalies)) $anomalyText[] = 'Cambio de IP';
            if (in_array('user_agent_change', $anomalies)) $anomalyText[] = 'Cambio de navegador';
            if (in_array('multiple_sessions', $anomalies)) $anomalyText[] = 'Múltiples sesiones';
            if (in_array('bot_pattern', $anomalies)) $anomalyText[] = 'Patrón de bot';
            if (in_array('threat_intel', $anomalies)) $anomalyText[] = 'IP sospechosa';

            $alerts[] = [
                'type' => 'danger',
                'category' => 'security',
                'title' => '🚨 Conexión Sospechosa Detectada',
                'message' => sprintf(
                    "Usuario '%s' - Anomalías: %s (Score: %d/5)",
                    $event->getUser()->getEmail(),
                    implode(', ', $anomalyText),
                    $score
                ),
                'date' => $event->getCreatedAt(),
                'user' => $event->getUser(),
                'details' => $details,
            ];
        }

        // 2. ALERTAS DE PLANES PRÓXIMOS A VENCER
        $expiringTenants = $this->em->getRepository(\App\Entity\Tenant::class)
            ->createQueryBuilder('t')
            ->where('t.planExpiresAt IS NOT NULL')
            ->andWhere('t.planExpiresAt BETWEEN :now AND :next30')
            ->andWhere('t.isActive = true')
            ->setParameter('now', new \DateTime())
            ->setParameter('next30', new \DateTime('+30 days'))
            ->getQuery()
            ->getResult();

        foreach ($expiringTenants as $tenant) {
            $days = $tenant->getDaysUntilExpiration();
            $alerts[] = [
                'type' => $days <= 7 ? 'danger' : 'warning',
                'category' => 'billing',
                'title' => '⏰ Plan Próximo a Vencer',
                'message' => sprintf(
                    "Empresa '%s' - Plan '%s' vence en %d días (%s)",
                    $tenant->getName(),
                    strtoupper($tenant->getPlan()),
                    $days,
                    $tenant->getPlanExpiresAt()->format('d/m/Y')
                ),
                'date' => $tenant->getPlanExpiresAt(),
                'tenant' => $tenant,
            ];
        }

        // 3. PLANES EXPIRADOS
        $expiredTenants = $this->em->getRepository(\App\Entity\Tenant::class)
            ->createQueryBuilder('t')
            ->where('t.planExpiresAt IS NOT NULL')
            ->andWhere('t.planExpiresAt < :now')
            ->andWhere('t.isActive = true')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();

        foreach ($expiredTenants as $tenant) {
            $days = abs($tenant->getDaysUntilExpiration());
            $alerts[] = [
                'type' => 'danger',
                'category' => 'billing',
                'title' => '🚫 Plan Expirado',
                'message' => sprintf(
                    "Empresa '%s' - Plan '%s' expiró hace %d días",
                    $tenant->getName(),
                    strtoupper($tenant->getPlan()),
                    $days
                ),
                'date' => $tenant->getPlanExpiresAt(),
                'tenant' => $tenant,
            ];
        }

        // 4. Verificar tenants inactivos por mucho tiempo
        $inactiveTenants = $this->em->getRepository(\App\Entity\Tenant::class)
            ->findBy(['isActive' => false]);

        foreach ($inactiveTenants as $tenant) {
            $alerts[] = [
                'type' => 'warning',
                'category' => 'status',
                'title' => 'Tenant Inactivo',
                'message' => "Tenant '{$tenant->getName()}' está inactivo",
                'date' => $tenant->getUpdatedAt(),
            ];
        }

        // 5. Verificar usuarios bloqueados
        $blockedUsers = $this->em->getRepository(User::class)
            ->createQueryBuilder('u')
            ->where('u.lockedUntil IS NOT NULL')
            ->andWhere('u.lockedUntil > :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();

        foreach ($blockedUsers as $user) {
            $alerts[] = [
                'type' => 'warning',
                'category' => 'security',
                'title' => '🔒 Usuario Bloqueado',
                'message' => "Usuario '{$user->getEmail()}' bloqueado por múltiples intentos fallidos hasta " . $user->getLockedUntil()->format('d/m/Y H:i'),
                'date' => $user->getLockedUntil(),
            ];
        }

        // 6. Verificar eventos críticos recientes
        $criticalCount = $this->em->getRepository(SecurityEvent::class)
            ->createQueryBuilder('se')
            ->select('COUNT(se.id)')
            ->where('se.severity = :severity')
            ->andWhere('se.createdAt > :last_hour')
            ->setParameter('severity', 'CRITICAL')
            ->setParameter('last_hour', new \DateTime('-1 hour'))
            ->getQuery()
            ->getSingleScalarResult();

        if ($criticalCount > 5) {
            // codesweep:ignore - false positive: $criticalCount es un entero obtenido por consulta (no entrada de usuario)
            $alerts[] = [
                'type' => 'danger',
                'category' => 'security',
                'title' => '⚠️ Múltiples Eventos Críticos',
                'message' => "Se detectaron {$criticalCount} eventos críticos en la última hora",
                'date' => new \DateTime(),
            ];
        }

        // Ordenar por fecha (más recientes primero)
        usort($alerts, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        // Estadísticas de alertas
        $stats = [
            'total' => count($alerts),
            'security' => count(array_filter($alerts, fn($a) => $a['category'] === 'security')),
            'billing' => count(array_filter($alerts, fn($a) => $a['category'] === 'billing')),
            'critical' => count(array_filter($alerts, fn($a) => $a['type'] === 'danger')),
        ];

        return $this->render('system/alerts.html.twig', [
            'alerts' => $alerts,
            'stats' => $stats,
        ]);
    }

    #[Route('/tenants', name: 'app_system_tenants')]
    public function tenants(Request $request): Response
    {
        $perPage = 20;
        $currentPage = max(1, (int) $request->query->get('page', 1));

        $repo = $this->em->getRepository(\App\Entity\Tenant::class);
        $totalItems = $repo->count([]);
        $totalPages = max(1, (int) ceil($totalItems / $perPage));
        $currentPage = min($currentPage, $totalPages);

        $tenants = $repo->findBy(
            [],
            ['createdAt' => 'DESC'],
            $perPage,
            ($currentPage - 1) * $perPage
        );

        return $this->render('system/tenants.html.twig', [
            'tenants'     => $tenants,
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'totalItems'  => $totalItems,
            'perPage'     => $perPage,
        ]);
    }

    #[Route('/tenants/create', name: 'app_system_tenants_create', methods: ['GET', 'POST'])]
    public function createTenant(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('submit', $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_system_tenants_create');
            }

            $name = $request->request->get('name');
            $slug = $request->request->get('slug');
            $plan = $request->request->get('plan');
            $maxUsers = (int)$request->request->get('max_users');
            $maxProjects = (int)$request->request->get('max_projects');
            $planMonths = (int)$request->request->get('plan_months');

            if (!$name || !$slug || !$plan) {
                $this->addFlash('error', 'flash.fill_required_fields');
                return $this->redirectToRoute('app_system_tenants_create');
            }

            // Proteger slug reservado
            if ($slug === \App\Entity\Tenant::PROTECTED_SLUG) {
                $this->addFlash('error', 'flash.cannot_use_reserved_slug');
                return $this->redirectToRoute('app_system_tenants_create');
            }

            // Verificar slug único
            $existing = $this->em->getRepository(\App\Entity\Tenant::class)->findOneBy(['slug' => $slug]);
            if ($existing) {
                $this->addFlash('error', 'flash.subdomain_in_use');
                return $this->redirectToRoute('app_system_tenants_create');
            }

            $tenant = new \App\Entity\Tenant();
            $tenant->setName($name);
            $tenant->setSlug($slug);
            $tenant->setPlan($plan);
            $tenant->setMaxUsers($maxUsers);
            $tenant->setMaxProjects($maxProjects);

            // Calcular fecha de expiración
            if ($planMonths > 0) {
                // codesweep:ignore - false positive: $planMonths se cast a (int) desde la request, no es entrada de ruta
                $expiresAt = new \DateTime("+{$planMonths} months");
                $tenant->setPlanExpiresAt($expiresAt);
            }

            $this->em->persist($tenant);
            $this->em->flush();

            $this->addFlash('success', $this->translator->trans('flash.company_created', ['%name%' => $name]));
            return $this->redirectToRoute('app_system_tenants');
        }

        return $this->render('system/tenants_create.html.twig');
    }

    #[Route('/tenants/{id}/edit', name: 'app_system_tenants_edit', methods: ['GET', 'POST'])]
    public function editTenant(Request $request, int $id): Response
    {
        $tenant = $this->em->getRepository(\App\Entity\Tenant::class)->find($id);

        if (!$tenant) {
            $this->addFlash('error', 'flash.company_not_found');
            return $this->redirectToRoute('app_system_tenants');
        }

        // No permitir editar tenant protegido
        if ($tenant->isProtected()) {
            $this->addFlash('error', 'flash.cannot_modify_protected_company');
            return $this->redirectToRoute('app_system_tenants');
        }

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('submit', $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_system_tenants_edit', ['id' => $id]);
            }

            $name = $request->request->get('name');
            $plan = $request->request->get('plan');
            $maxUsers = (int)$request->request->get('max_users');
            $maxProjects = (int)$request->request->get('max_projects');
            $isActive = (bool)$request->request->get('is_active');
            $planMonths = (int)$request->request->get('plan_months');

            $tenant->setName($name);
            $tenant->setPlan($plan);
            $tenant->setMaxUsers($maxUsers);
            $tenant->setMaxProjects($maxProjects);
            $tenant->setIsActive($isActive);

            // Actualizar vigencia si se especifica
            if ($planMonths > 0) {
                // codesweep:ignore - false positive: $planMonths se cast a (int) desde la request, no es entrada de ruta
                $expiresAt = new \DateTime("+{$planMonths} months");
                $tenant->setPlanExpiresAt($expiresAt);
            }

            $this->em->flush();

            $this->addFlash('success', $this->translator->trans('flash.company_updated', ['%name%' => $name]));
            return $this->redirectToRoute('app_system_tenants');
        }

        return $this->render('system/tenants_edit.html.twig', [
            'tenant' => $tenant,
        ]);
    }

    private function checkDatabase(): array
    {
        try {
            // Verificar conectividad con una query simple
            $this->em->getConnection()->executeQuery('SELECT 1');
            return [
                'status' => 'ok',
                'message' => 'Conexión exitosa',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    private function checkCache(): array
    {
        $cacheDir = $this->getParameter('kernel.cache_dir');
        $size = $this->getDirSize($cacheDir);

        return [
            'status' => 'ok',
            'size' => $this->formatBytes($size),
        ];
    }

    private function checkSessions(): array
    {
        $activeCount = $this->em->getRepository(LoginSession::class)
            ->count(['isActive' => true]);

        return [
            'status' => 'ok',
            'active' => $activeCount,
        ];
    }

    private function checkDiskUsage(): array
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $total = disk_total_space($projectDir);
        $free = disk_free_space($projectDir);

        if ($total === false || $free === false) {
            return [
                'status' => 'error',
                'total' => 'N/A',
                'used' => 'N/A',
                'free' => 'N/A',
                'percent' => 0,
            ];
        }

        $used = $total - $free;
        $percent = ($used / $total) * 100;

        return [
            'status' => $percent > 80 ? 'warning' : 'ok',
            'total' => $this->formatBytes((int)$total),
            'used' => $this->formatBytes((int)$used),
            'free' => $this->formatBytes((int)$free),
            'percent' => round($percent, 2),
        ];
    }

    private function getDirSize(string $dir): int
    {
        $size = 0;
        if (is_dir($dir)) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir)) as $file) {
                if ($file->isFile()) {
                    $size += $file->getSize();
                }
            }
        }
        return $size;
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    private function getRecentErrors(): array
    {
        $logFile = $this->getParameter('kernel.logs_dir') . '/dev.log';
        if (file_exists($logFile)) {
            return array_slice($this->parseLogFile($logFile), 0, 20);
        }
        return [];
    }

    private function parseLogFile(string $logFile): array
    {
        $errors = [];
        // codesweep:ignore - false positive: $logFile proviene de kernel parameter, no de input del usuario
        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach (array_reverse(array_slice($lines, -500)) as $line) {
            if (preg_match('/\[(.*?)\].*?(ERROR|CRITICAL|WARNING).*?:\s*(.*)/', $line, $matches)) {
                $errors[] = [
                    'date' => $matches[1],
                    'level' => $matches[2],
                    'message' => $matches[3],
                ];

                if (count($errors) >= 100) {
                    break;
                }
            }
        }

        return $errors;
    }
}
