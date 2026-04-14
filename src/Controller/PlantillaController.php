<?php

namespace App\Controller;

use App\Entity\Plantilla;
use App\Entity\PlantillaRubro;
use App\Entity\Projects;
use App\Entity\Rubro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/projects/{projectId}/plantillas')]
#[IsGranted('ROLE_USER')]
class PlantillaController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    private function getCurrentTenant(): \App\Entity\Tenant
    {
        $user = $this->getUser();
        if (!$user instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException();
        }
        return $user->getTenant();
    }

    private function getProject(int $projectId): Projects
    {
        $project = $this->em->getRepository(Projects::class)->findOneBy([
            'id' => $projectId,
            'tenant' => $this->getCurrentTenant(),
        ]);
        if (!$project) {
            throw $this->createNotFoundException('project.not_found');
        }
        return $project;
    }

    #[Route('/', name: 'app_plantilla_index')]
    public function index(int $projectId): Response
    {
        $project = $this->getProject($projectId);

        $plantillas = $this->em->getRepository(Plantilla::class)->findBy(
            ['proyecto' => $project],
            ['createdAt' => 'ASC']
        );

        return $this->render('plantillas/index.html.twig', [
            'project'   => $project,
            'plantillas' => $plantillas,
        ]);
    }

    #[Route('/create', name: 'app_plantilla_create', methods: ['GET', 'POST'])]
    public function create(int $projectId, Request $request): Response
    {
        $project = $this->getProject($projectId);

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('plantilla_create_' . $projectId, $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_plantilla_create', ['projectId' => $projectId]);
            }

            $plantilla = new Plantilla();
            $plantilla->setTenant($this->getCurrentTenant());
            $plantilla->setProyecto($project);
            $plantilla->setNombre(trim($request->request->get('nombre', '')));
            $plantilla->setDescripcion(trim($request->request->get('descripcion', '')) ?: null);

            $this->em->persist($plantilla);
            $this->em->flush();

            $this->addFlash('success', 'plantilla.created_success');
            return $this->redirectToRoute('app_plantilla_show', [
                'projectId' => $projectId,
                'id' => $plantilla->getId(),
            ]);
        }

        return $this->render('plantillas/create.html.twig', ['project' => $project]);
    }

    #[Route('/{id}', name: 'app_plantilla_show', requirements: ['id' => '\d+'])]
    public function show(int $projectId, int $id): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Plantilla::class)->findOneBy([
            'id' => $id,
            'proyecto' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        $rubrosDisponibles = $this->em->getRepository(Rubro::class)->findBy(
            ['tenant' => $this->getCurrentTenant(), 'activo' => true],
            ['codigo' => 'ASC']
        );

        // IDs de rubros ya agregados
        $rubrosAgregados = [];
        foreach ($plantilla->getPlantillaRubros() as $pr) {
            $rubrosAgregados[] = $pr->getRubro()->getId();
        }

        return $this->render('plantillas/show.html.twig', [
            'project'          => $project,
            'plantilla'        => $plantilla,
            'rubrosDisponibles' => $rubrosDisponibles,
            'rubrosAgregados'  => $rubrosAgregados,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plantilla_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(int $projectId, int $id, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Plantilla::class)->findOneBy([
            'id' => $id,
            'proyecto' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('plantilla_edit_' . $id, $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_plantilla_edit', ['projectId' => $projectId, 'id' => $id]);
            }

            $plantilla->setNombre(trim($request->request->get('nombre', '')));
            $plantilla->setDescripcion(trim($request->request->get('descripcion', '')) ?: null);
            $plantilla->setUpdatedAt(new \DateTime());

            $this->em->flush();
            $this->addFlash('success', 'plantilla.updated_success');
            return $this->redirectToRoute('app_plantilla_show', ['projectId' => $projectId, 'id' => $id]);
        }

        return $this->render('plantillas/edit.html.twig', [
            'project'  => $project,
            'plantilla' => $plantilla,
        ]);
    }

    /** Agregar un rubro a la plantilla */
    #[Route('/{id}/add-rubro', name: 'app_plantilla_add_rubro', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function addRubro(int $projectId, int $id, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Plantilla::class)->findOneBy([
            'id' => $id,
            'proyecto' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        if (!$this->isCsrfTokenValid('add_rubro_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_plantilla_show', ['projectId' => $projectId, 'id' => $id]);
        }

        $rubroId = (int) $request->request->get('rubro_id');
        $rubro = $this->em->getRepository(Rubro::class)->findOneBy([
            'id' => $rubroId,
            'tenant' => $this->getCurrentTenant(),
        ]);

        if (!$rubro) {
            $this->addFlash('error', 'rubro.not_found');
            return $this->redirectToRoute('app_plantilla_show', ['projectId' => $projectId, 'id' => $id]);
        }

        // No duplicar
        foreach ($plantilla->getPlantillaRubros() as $pr) {
            if ($pr->getRubro()->getId() === $rubro->getId()) {
                $this->addFlash('warning', 'plantilla.rubro_already_added');
                return $this->redirectToRoute('app_plantilla_show', ['projectId' => $projectId, 'id' => $id]);
            }
        }

        $cantidad = $request->request->get('cantidad', '1.00');
        $orden = $plantilla->getPlantillaRubros()->count();

        $pr = new PlantillaRubro();
        $pr->setPlantilla($plantilla);
        $pr->setRubro($rubro);
        $pr->setCantidad($cantidad);
        $pr->setOrden($orden);

        $this->em->persist($pr);
        $this->em->flush();

        $this->addFlash('success', 'plantilla.rubro_added');
        return $this->redirectToRoute('app_plantilla_show', ['projectId' => $projectId, 'id' => $id]);
    }

    /** Eliminar un rubro (PlantillaRubro) de la plantilla */
    #[Route('/{id}/remove-rubro/{prId}', name: 'app_plantilla_remove_rubro', requirements: ['id' => '\d+', 'prId' => '\d+'], methods: ['POST'])]
    public function removeRubro(int $projectId, int $id, int $prId, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Plantilla::class)->findOneBy([
            'id' => $id,
            'proyecto' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        if (!$this->isCsrfTokenValid('remove_rubro_' . $prId, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_plantilla_show', ['projectId' => $projectId, 'id' => $id]);
        }

        $pr = $this->em->getRepository(PlantillaRubro::class)->find($prId);
        if ($pr && $pr->getPlantilla()->getId() === $plantilla->getId()) {
            $this->em->remove($pr);
            $this->em->flush();
            $this->addFlash('success', 'plantilla.rubro_removed');
        }

        return $this->redirectToRoute('app_plantilla_show', ['projectId' => $projectId, 'id' => $id]);
    }

    /** Duplicar plantilla */
    #[Route('/{id}/duplicate', name: 'app_plantilla_duplicate', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function duplicate(int $projectId, int $id, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $original = $this->em->getRepository(Plantilla::class)->findOneBy([
            'id' => $id,
            'proyecto' => $project,
        ]);
        if (!$original) {
            throw $this->createNotFoundException();
        }

        if (!$this->isCsrfTokenValid('plantilla_dup_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_plantilla_show', ['projectId' => $projectId, 'id' => $id]);
        }

        $copy = new Plantilla();
        $copy->setTenant($original->getTenant());
        $copy->setProyecto($project);
        $copy->setNombre($original->getNombre() . ' (copia)');
        $copy->setDescripcion($original->getDescripcion());

        foreach ($original->getPlantillaRubros() as $pr) {
            $newPr = new PlantillaRubro();
            $newPr->setPlantilla($copy);
            $newPr->setRubro($pr->getRubro());
            $newPr->setCantidad($pr->getCantidad());
            $newPr->setOrden($pr->getOrden());
            // APU no se duplica — queda pendiente de asignar
            $this->em->persist($newPr);
        }

        $this->em->persist($copy);
        $this->em->flush();

        $this->addFlash('success', 'plantilla.duplicated_success');
        return $this->redirectToRoute('app_plantilla_show', [
            'projectId' => $projectId,
            'id' => $copy->getId(),
        ]);
    }

    /** Eliminar plantilla */
    #[Route('/{id}/delete', name: 'app_plantilla_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(int $projectId, int $id, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Plantilla::class)->findOneBy([
            'id' => $id,
            'proyecto' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        if (!$this->isCsrfTokenValid('plantilla_delete_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_plantilla_index', ['projectId' => $projectId]);
        }

        $this->em->remove($plantilla);
        $this->em->flush();

        $this->addFlash('success', 'plantilla.deleted_success');
        return $this->redirectToRoute('app_plantilla_index', ['projectId' => $projectId]);
    }
}
