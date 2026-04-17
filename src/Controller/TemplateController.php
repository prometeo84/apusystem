<?php

namespace App\Controller;

use App\Entity\Template;
use App\Entity\TemplateItem;
use App\Entity\Projects;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/projects/{projectId}/templates')]
#[IsGranted('ROLE_USER')]
class TemplateController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    private function getProject(int $projectId): Projects
    {
        $project = $this->em->getRepository(Projects::class)->findOneBy([
            'id' => $projectId,
            'tenant' => $this->getUser()->getTenant(),
        ]);
        if (!$project) {
            throw $this->createNotFoundException('project.not_found');
        }
        return $project;
    }

    #[Route('/', name: 'app_template_index')]
    public function index(int $projectId): Response
    {
        $project = $this->getProject($projectId);

        $plantillas = $this->em->getRepository(Template::class)->findBy(
            ['project' => $project],
            ['createdAt' => 'ASC']
        );

        return $this->render('template/index.html.twig', [
            'project'   => $project,
            'plantillas' => $plantillas,
        ]);
    }

    #[Route('/create', name: 'app_template_create', methods: ['GET', 'POST'])]
    public function create(int $projectId, Request $request): Response
    {
        $project = $this->getProject($projectId);

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('plantilla_create_' . $projectId, $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_template_create', ['projectId' => $projectId]);
            }

            $plantilla = new Template();
            $plantilla->setTenant($this->getUser()->getTenant());
            $plantilla->setProject($project);
            $plantilla->setName(trim($request->request->get('nombre', '')));
            $plantilla->setDescription(trim($request->request->get('descripcion', '')) ?: null);

            $this->em->persist($plantilla);
            $this->em->flush();

            $this->addFlash('success', 'plantilla.created_success');
            return $this->redirectToRoute('app_template_show', [
                'projectId' => $projectId,
                'id' => $plantilla->getId(),
            ]);
        }

        return $this->render('template/create.html.twig', ['project' => $project]);
    }

    #[Route('/{id}', name: 'app_template_show', requirements: ['id' => '\\d+'])]
    public function show(int $projectId, int $id): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Template::class)->findOneBy([
            'id' => $id,
            'project' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        $rubrosDisponibles = $this->em->getRepository(Item::class)->findBy(
            ['tenant' => $this->getUser()->getTenant(), 'active' => true],
            ['code' => 'ASC']
        );

        // IDs de rubros ya agregados
        $rubrosAgregados = [];
        foreach ($plantilla->getItems() as $pr) {
            $rubrosAgregados[] = $pr->getItem()->getId();
        }

        return $this->render('template/show.html.twig', [
            'project'          => $project,
            'plantilla'        => $plantilla,
            'rubrosDisponibles' => $rubrosDisponibles,
            'rubrosAgregados'  => $rubrosAgregados,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_template_edit', requirements: ['id' => '\\d+'], methods: ['GET', 'POST'])]
    public function edit(int $projectId, int $id, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Template::class)->findOneBy([
            'id' => $id,
            'project' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('plantilla_edit_' . $id, $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_template_edit', ['projectId' => $projectId, 'id' => $id]);
            }

            $plantilla->setName(trim($request->request->get('nombre', '')));
            $plantilla->setDescription(trim($request->request->get('descripcion', '')) ?: null);
            $plantilla->setUpdatedAt(new \DateTime());

            $this->em->flush();
            $this->addFlash('success', 'plantilla.updated_success');
            return $this->redirectToRoute('app_template_show', ['projectId' => $projectId, 'id' => $id]);
        }

        return $this->render('template/edit.html.twig', [
            'project'  => $project,
            'plantilla' => $plantilla,
        ]);
    }

    #[Route('/{id}/add-item', name: 'app_template_add_item', requirements: ['id' => '\\d+'], methods: ['POST'])]
    public function addRubro(int $projectId, int $id, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Template::class)->findOneBy([
            'id' => $id,
            'project' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        if (!$this->isCsrfTokenValid('add_rubro_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_template_show', ['projectId' => $projectId, 'id' => $id]);
        }

        $rubroId = (int) $request->request->get('rubro_id');
        $rubro = $this->em->getRepository(Item::class)->findOneBy([
            'id' => $rubroId,
            'tenant' => $this->getUser()->getTenant(),
        ]);

        if (!$rubro) {
            $this->addFlash('error', 'rubro.not_found');
            return $this->redirectToRoute('app_template_show', ['projectId' => $projectId, 'id' => $id]);
        }

        // No duplicar
        foreach ($plantilla->getItems() as $pr) {
            if ($pr->getItem()->getId() === $rubro->getId()) {
                $this->addFlash('warning', 'plantilla.rubro_already_added');
                return $this->redirectToRoute('app_template_show', ['projectId' => $projectId, 'id' => $id]);
            }
        }

        $cantidad = $request->request->get('cantidad', '1.00');
        $orden = $plantilla->getItems()->count();

        $pr = new TemplateItem();
        $pr->setTemplate($plantilla);
        $pr->setItem($rubro);
        $pr->setQuantity($cantidad);
        $pr->setOrder($orden);

        $this->em->persist($pr);
        $this->em->flush();

        $this->addFlash('success', 'plantilla.rubro_added');
        return $this->redirectToRoute('app_template_show', ['projectId' => $projectId, 'id' => $id]);
    }

    #[Route('/{id}/remove-item/{prId}', name: 'app_template_remove_item', requirements: ['id' => '\\d+', 'prId' => '\\d+'], methods: ['POST'])]
    public function removeRubro(int $projectId, int $id, int $prId, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Template::class)->findOneBy([
            'id' => $id,
            'project' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        if (!$this->isCsrfTokenValid('remove_rubro_' . $prId, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_template_show', ['projectId' => $projectId, 'id' => $id]);
        }

        $pr = $this->em->getRepository(TemplateItem::class)->find($prId);
        if ($pr && $pr->getTemplate()->getId() === $plantilla->getId()) {
            $this->em->remove($pr);
            $this->em->flush();
            $this->addFlash('success', 'plantilla.rubro_removed');
        }

        return $this->redirectToRoute('app_template_show', ['projectId' => $projectId, 'id' => $id]);
    }

    #[Route('/{id}/duplicate', name: 'app_template_duplicate', requirements: ['id' => '\\d+'], methods: ['POST'])]
    public function duplicate(int $projectId, int $id, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $original = $this->em->getRepository(Template::class)->findOneBy([
            'id' => $id,
            'project' => $project,
        ]);
        if (!$original) {
            throw $this->createNotFoundException();
        }

        if (!$this->isCsrfTokenValid('plantilla_dup_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_template_show', ['projectId' => $projectId, 'id' => $id]);
        }

        $copy = new Template();
        $copy->setTenant($original->getTenant());
        $copy->setProject($project);
        $copy->setName($original->getName() . ' (copia)');
        $copy->setDescription($original->getDescription());

        foreach ($original->getItems() as $pr) {
            $newPr = new TemplateItem();
            $newPr->setTemplate($copy);
            $newPr->setItem($pr->getItem());
            $newPr->setQuantity($pr->getQuantity());
            $newPr->setOrder($pr->getOrder());
            // APU no se duplica — queda pendiente de asignar
            $this->em->persist($newPr);
        }

        $this->em->persist($copy);
        $this->em->flush();

        $this->addFlash('success', 'plantilla.duplicated_success');
        return $this->redirectToRoute('app_template_show', [
            'projectId' => $projectId,
            'id' => $copy->getId(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_template_delete', requirements: ['id' => '\\d+'], methods: ['POST'])]
    public function delete(int $projectId, int $id, Request $request): Response
    {
        $project = $this->getProject($projectId);
        $plantilla = $this->em->getRepository(Template::class)->findOneBy([
            'id' => $id,
            'project' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        if (!$this->isCsrfTokenValid('plantilla_delete_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_template_index', ['projectId' => $projectId]);
        }

        $this->em->remove($plantilla);
        $this->em->flush();

        $this->addFlash('success', 'plantilla.deleted_success');
        return $this->redirectToRoute('app_template_index', ['projectId' => $projectId]);
    }
}
