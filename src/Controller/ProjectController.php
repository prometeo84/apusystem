<?php

namespace App\Controller;

use App\Entity\Plantilla;
use App\Entity\PlantillaRubro;
use App\Entity\Projects;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/projects')]
#[IsGranted('ROLE_USER')]
class ProjectController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    #[Route('/', name: 'app_project_index')]
    public function index(Request $request): Response
    {
        $tenant = $this->getUser()->getTenant();
        $perPage = 20;
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

        return $this->render('projects/index.html.twig', [
            'projects'    => $projects,
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'totalItems'  => $totalItems,
            'perPage'     => $perPage,
        ]);
    }

    #[Route('/create', name: 'app_project_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $this->denyAccessUnlessGranted('ROLE_USER');

            if (!$this->isCsrfTokenValid('project_create', $request->request->get('_token'))) {
                $this->addFlash('error', 'project.error_invalid_csrf');
                return $this->redirectToRoute('app_project_create');
            }

            $user = $this->getUser();
            $tenant = $user->getTenant();

            $project = new Projects();
            $project->setTenant($tenant);
            $project->setNombre(trim($request->request->get('nombre', '')));
            $project->setCodigo(trim($request->request->get('codigo', '')));
            $project->setDescripcion(trim($request->request->get('descripcion', '')) ?: null);
            $project->setCliente(trim($request->request->get('cliente', '')) ?: null);
            $project->setUbicacion(trim($request->request->get('ubicacion', '')) ?: null);
            $project->setEstado($request->request->get('estado', 'planificacion'));

            $presupuesto = $request->request->get('presupuesto_total', '');
            $project->setPresupuestoTotal($presupuesto !== '' ? $presupuesto : null);

            $fechaInicio = $request->request->get('fecha_inicio', '');
            if ($fechaInicio !== '') {
                $project->setFechaInicio(new \DateTime($fechaInicio));
            }

            $fechaFin = $request->request->get('fecha_fin', '');
            if ($fechaFin !== '') {
                $project->setFechaFin(new \DateTime($fechaFin));
            }

            $this->em->persist($project);
            $this->em->flush();

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

            $project->setNombre(trim($request->request->get('nombre', '')));
            $project->setCodigo(trim($request->request->get('codigo', '')));
            $project->setDescripcion(trim($request->request->get('descripcion', '')) ?: null);
            $project->setCliente(trim($request->request->get('cliente', '')) ?: null);
            $project->setUbicacion(trim($request->request->get('ubicacion', '')) ?: null);
            $project->setEstado($request->request->get('estado', 'planificacion'));

            $presupuesto = $request->request->get('presupuesto_total', '');
            $project->setPresupuestoTotal($presupuesto !== '' ? $presupuesto : null);

            $fechaInicio = $request->request->get('fecha_inicio', '');
            $project->setFechaInicio($fechaInicio !== '' ? new \DateTime($fechaInicio) : null);

            $fechaFin = $request->request->get('fecha_fin', '');
            $project->setFechaFin($fechaFin !== '' ? new \DateTime($fechaFin) : null);

            $this->em->flush();

            $this->addFlash('success', 'project.updated_success');
            return $this->redirectToRoute('app_project_show', ['id' => $project->getId()]);
        }

        return $this->render('projects/edit.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_project_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
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
        $copy->setNombre($original->getNombre() . ' (copia)');
        $copy->setCodigo($original->getCodigo() . '-C');
        $copy->setDescripcion($original->getDescripcion());
        $copy->setCliente($original->getCliente());
        $copy->setUbicacion($original->getUbicacion());
        $copy->setEstado('planificacion');
        $copy->setPresupuestoTotal($original->getPresupuestoTotal());
        $copy->setFechaInicio($original->getFechaInicio());
        $copy->setFechaFin($original->getFechaFin());

        $this->em->persist($copy);

        // Duplicar plantillas (sin APUs)
        foreach ($original->getPlantillas() as $plantilla) {
            $newPlantilla = new Plantilla();
            $newPlantilla->setTenant($tenant);
            $newPlantilla->setProyecto($copy);
            $newPlantilla->setNombre($plantilla->getNombre());
            $newPlantilla->setDescripcion($plantilla->getDescripcion());

            foreach ($plantilla->getPlantillaRubros() as $pr) {
                $newPr = new PlantillaRubro();
                $newPr->setPlantilla($newPlantilla);
                $newPr->setRubro($pr->getRubro());
                $newPr->setCantidad($pr->getCantidad());
                $newPr->setOrden($pr->getOrden());
                $this->em->persist($newPr);
            }

            $this->em->persist($newPlantilla);
        }

        $this->em->flush();

        $this->addFlash('success', 'project.duplicated_success');
        return $this->redirectToRoute('app_project_show', ['id' => $copy->getId()]);
    }
}
