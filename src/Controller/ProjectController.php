<?php

namespace App\Controller;

use App\Entity\Template;
use App\Entity\TemplateItem;
use App\Entity\Projects;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\SecurityLogger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/projects')]
#[IsGranted('ROLE_USER')]
class ProjectController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private ValidatorInterface $validator,
        private SecurityLogger $securityLogger
    ) {}

    private function sanitizeCode(string $raw): string
    {
        $s = trim($raw);
        // Replace any sequence of non-alphanumeric characters with a single dash
        $s = preg_replace('/[^A-Za-z0-9]+/', '-', $s);
        $s = preg_replace('/-+/', '-', $s);
        $s = trim($s, '-');
        return $s;
    }

    #[Route('/', name: 'app_project_index')]
    public function index(Request $request): Response
    {
        $tenant = $this->getUser()->getTenant();
        // Mostrar suficientes proyectos en una sola página para pruebas E2E
        $perPage = 100;
        $currentPage = max(1, (int) $request->query->get('page', 1));

        $repo = $this->em->getRepository(Projects::class);
        $totalItems = $repo->count(['tenant' => $tenant]);
        $totalPages = max(1, (int) ceil($totalItems / $perPage));
        $currentPage = min($currentPage, $totalPages);

        $projects = $repo->findBy(
            ['tenant' => $tenant],
            ['createdAt' => 'DESC'],
            $perPage,
            ($currentPage - 1) * $perPage
        );

        $canCreateProject = true;
        $maxProjects = $tenant->getMaxProjects();
        if ($maxProjects > 0) {
            $canCreateProject = $totalItems < $maxProjects;
        }

        return $this->render('projects/index.html.twig', [
            'projects'    => $projects,
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'totalItems'  => $totalItems,
            'perPage'     => $perPage,
            'can_create_project' => $canCreateProject,
        ]);
    }

    #[Route('/create', name: 'app_project_create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            if (!$this->isCsrfTokenValid('project_create', $request->request->get('_token'))) {
                $this->addFlash('error', 'project.error_invalid_csrf');
                return $this->redirectToRoute('app_project_create');
            }

            $user = $this->getUser();
            $tenant = $user->getTenant();

            $project = new Projects();
            $project->setTenant($tenant);
            $project->setCreatedBy($this->getUser());
            // Check tenant project limit before creating
            $repo = $this->em->getRepository(Projects::class);
            $current = $repo->count(['tenant' => $tenant]);
            if ($current >= $tenant->getMaxProjects()) {
                $this->securityLogger->log('project_creation_blocked_limit', 'WARNING', $user, [
                    'current' => $current,
                    'limit' => $tenant->getMaxProjects()
                ]);
                $this->addFlash('error', 'project.limit_reached');
                return $this->render('projects/create.html.twig', ['project' => $project]);
            }
            // Ensure name is trimmed and does not exceed DB column length
            $rawName = trim($request->request->get('name', ''));
            if (mb_strlen($rawName) > 255) {
                $rawName = mb_substr($rawName, 0, 255);
            }
            $project->setName($rawName);
            $rawCode = (string) $request->request->get('code', '');
            $project->setCode($this->sanitizeCode($rawCode));
            $project->setDescription(trim($request->request->get('description', '')) ?: null);
            $project->setClient(trim($request->request->get('client', '')) ?: null);
            $project->setLocation(trim($request->request->get('location', '')) ?: null);
            $project->setStatus($request->request->get('status', 'planificacion'));

            $presupuesto = $request->request->get('total_budget', '');
            $project->setTotalBudget($presupuesto !== '' ? $presupuesto : null);

            $fechaInicio = $request->request->get('start_date', '');
            if ($fechaInicio !== '') {
                $project->setStartDate(new \DateTime($fechaInicio));
            }

            $fechaFin = $request->request->get('end_date', '');
            if ($fechaFin !== '') {
                $project->setEndDate(new \DateTime($fechaFin));
            }

            $errors = $this->validator->validate($project);
            if (count($errors) > 0) {
                $fieldErrors = [];
                foreach ($errors as $e) {
                    $fieldErrors[$e->getPropertyPath()][] = $e->getMessage();
                }
                return $this->render('projects/create.html.twig', ['fieldErrors' => $fieldErrors, 'project' => $project]);
            }

            $this->em->persist($project);
            // Defensive: catch DB driver exceptions (e.g. data too long) and map to field errors
            try {
                $this->em->flush();
            } catch (\Doctrine\DBAL\Exception\DriverException $ex) {
                $fieldErrors = [];
                if (stripos($ex->getMessage(), "Data too long for column 'name'") !== false) {
                    $fieldErrors['name'][] = 'name.too_long';
                    return $this->render('projects/create.html.twig', ['fieldErrors' => $fieldErrors, 'project' => $project]);
                }
                throw $ex;
            }

            $this->addFlash('success', 'project.created_success');
            return $this->redirectToRoute('app_project_show', ['id' => $project->getId()]);
        }

        return $this->render('projects/create.html.twig');
    }

    #[Route('/{id}', name: 'app_project_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $tenant = $this->getUser()->getTenant();
        $project = $this->em->getRepository(Projects::class)->findOneBy([
            'id' => $id,
            'tenant' => $tenant,
        ]);

        if (!$project) {
            throw $this->createNotFoundException('project.not_found');
        }

        return $this->render('projects/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_project_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(int $id, Request $request): Response
    {
        $tenant = $this->getUser()->getTenant();
        $project = $this->em->getRepository(Projects::class)->findOneBy([
            'id' => $id,
            'tenant' => $tenant,
        ]);

        if (!$project) {
            throw $this->createNotFoundException('project.not_found');
        }

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('project_edit_' . $id, $request->request->get('_token'))) {
                $this->addFlash('error', 'project.error_invalid_csrf');
                return $this->redirectToRoute('app_project_edit', ['id' => $id]);
            }

            $project->setName(trim($request->request->get('name', '')));
            $rawCode = (string) $request->request->get('code', '');
            $project->setCode($this->sanitizeCode($rawCode));
            $project->setDescription(trim($request->request->get('description', '')) ?: null);
            $project->setClient(trim($request->request->get('client', '')) ?: null);
            $project->setLocation(trim($request->request->get('location', '')) ?: null);
            $project->setStatus($request->request->get('status', 'planificacion'));

            $presupuesto = $request->request->get('total_budget', '');
            $project->setTotalBudget($presupuesto !== '' ? $presupuesto : null);

            $fechaInicio = $request->request->get('start_date', '');
            $project->setStartDate($fechaInicio !== '' ? new \DateTime($fechaInicio) : null);

            $fechaFin = $request->request->get('end_date', '');
            $project->setEndDate($fechaFin !== '' ? new \DateTime($fechaFin) : null);

            $this->em->flush();

            $this->addFlash('success', 'project.updated_success');
            return $this->redirectToRoute('app_project_show', ['id' => $project->getId()]);
        }

        return $this->render('projects/edit.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_project_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id, Request $request): Response
    {
        $tenant = $this->getUser()->getTenant();
        $project = $this->em->getRepository(Projects::class)->findOneBy([
            'id' => $id,
            'tenant' => $tenant,
        ]);

        if (!$project) {
            throw $this->createNotFoundException('project.not_found');
        }

        if (!$this->isCsrfTokenValid('project_delete_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'project.error_invalid_csrf');
            return $this->redirectToRoute('app_project_show', ['id' => $id]);
        }

        $this->em->remove($project);
        $this->em->flush();

        $this->addFlash('success', 'project.deleted_success');
        return $this->redirectToRoute('app_project_index');
    }

    /** Duplicar proyecto (sin APUs, solo estructura) */
    #[Route('/{id}/duplicate', name: 'app_project_duplicate', requirements: ['id' => '\d+'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function duplicate(int $id, Request $request): Response
    {
        $tenant = $this->getUser()->getTenant();
        $original = $this->em->getRepository(Projects::class)->findOneBy([
            'id' => $id,
            'tenant' => $tenant,
        ]);

        if (!$original) {
            throw $this->createNotFoundException('project.not_found');
        }

        if (!$this->isCsrfTokenValid('project_dup_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'project.error_invalid_csrf');
            return $this->redirectToRoute('app_project_show', ['id' => $id]);
        }

        $copy = new Projects();
        $copy->setTenant($tenant);
        $copy->setCreatedBy($this->getUser());
        // Asegurar que el nombre de la copia no exceda la longitud de la columna DB
        $copyName = $original->getName() . ' (copia)';
        if (mb_strlen($copyName) > 255) {
            $copyName = mb_substr($copyName, 0, 255);
        }
        $copy->setName($copyName);
        $copy->setCode($this->sanitizeCode($original->getCode() . '-C'));
        $copy->setDescription($original->getDescription());
        $copy->setClient($original->getClient());
        $copy->setLocation($original->getLocation());
        $copy->setStatus('planificacion');
        $copy->setTotalBudget($original->getTotalBudget());
        $copy->setStartDate($original->getStartDate());
        $copy->setEndDate($original->getEndDate());

        // Check tenant project limit before persisting duplicate
        $repo = $this->em->getRepository(Projects::class);
        $current = $repo->count(['tenant' => $tenant]);
        if ($current >= $tenant->getMaxProjects()) {
            $this->securityLogger->log('project_duplicate_blocked_limit', 'WARNING', $this->getUser(), [
                'current' => $current,
                'limit' => $tenant->getMaxProjects(),
                'original_project_id' => $original->getId(),
            ]);
            $this->addFlash('error', 'project.limit_reached');
            return $this->redirectToRoute('app_project_show', ['id' => $id]);
        }

        $this->em->persist($copy);

        // Duplicar plantillas (sin APUs)
        foreach ($original->getTemplates() as $plantilla) {
            $newPlantilla = new Template();
            $newPlantilla->setTenant($tenant);
            $newPlantilla->setProject($copy);
            $newPlantilla->setName($plantilla->getName());
            $newPlantilla->setDescription($plantilla->getDescription());

            foreach ($plantilla->getItems() as $pr) {
                $newPr = new TemplateItem();
                $newPr->setTemplate($newPlantilla);
                $newPr->setItem($pr->getItem());
                // TemplateItem no longer stores a quantity; preserve order only
                $newPr->setOrder($pr->getOrder());
                $this->em->persist($newPr);
            }

            $this->em->persist($newPlantilla);
        }

        // Defensive flush: map DB overflow to user-facing error when possible
        try {
            $this->em->flush();
        } catch (\Doctrine\DBAL\Exception\DriverException $ex) {
            if (stripos($ex->getMessage(), "Data too long for column 'name'") !== false) {
                $this->addFlash('error', 'name.too_long');
                return $this->redirectToRoute('app_project_show', ['id' => $id]);
            }
            throw $ex;
        }

        $this->addFlash('success', 'project.duplicated_success');
        return $this->redirectToRoute('app_project_show', ['id' => $copy->getId()]);
    }
}
