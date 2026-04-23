<?php

namespace App\Controller\Catalog;

use App\Entity\Labor;
use App\Entity\Projects;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/catalog/labor')]
#[IsGranted('ROLE_USER')]
class LaborController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('/', name: 'catalog_labor_index')]
    public function index(): Response
    {
        $items = $this->em->getRepository(Labor::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['code' => 'ASC']);
        return $this->render('catalog/labor/index.html.twig', ['items' => $items]);
    }

    #[Route('/json', name: 'catalog_labor_json', methods: ['GET'])]
    public function listJson(): JsonResponse
    {
        $items = $this->em->getRepository(Labor::class)->findBy(['tenant' => $this->getUser()->getTenant(), 'active' => true], ['code' => 'ASC']);
        $data = array_map(fn(Labor $e) => ['id' => $e->getId(), 'code' => $e->getCode(), 'name' => $e->getDescription(), 'unit' => $e->getUnit()], $items);
        return $this->json($data);
    }

    #[Route('/create', name: 'catalog_labor_create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('labor_create', $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('catalog_labor_create');
            }

            $e = new Labor();
            $e->setTenant($this->getUser()->getTenant());
            $e->setCode(trim($request->request->get('code', '')));
            $e->setDescription(trim($request->request->get('description', '')));
            $e->setActive($request->request->get('active') === '1');

            $this->em->persist($e);
            $this->em->flush();
            $this->addFlash('success', 'catalog.created_success');
            return $this->redirectToRoute('catalog_labor_create');
        }

        $projects = $this->em->getRepository(Projects::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['name' => 'ASC']);
        return $this->render('catalog/labor/create.html.twig', ['projects' => $projects]);
    }

    #[Route('/{id}/edit', name: 'catalog_labor_edit', requirements: ['id' => '\\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(int $id, Request $request): Response
    {
        $e = $this->em->getRepository(Labor::class)->find($id);
        if (!$e || $e->getTenant() !== $this->getUser()->getTenant()) throw $this->createNotFoundException('catalog.not_found');
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('labor_edit_' . $id, $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('catalog_labor_edit', ['id' => $id]);
            }
            $e->setCode(trim($request->request->get('code', '')));
            $e->setDescription(trim($request->request->get('description', '')));
            $e->setActive($request->request->get('active') === '1');
            $visibility = $request->request->get('visibility');
            if ($visibility === 'project') {
                $pid = (int)$request->request->get('project_id');
                $proj = $this->em->getRepository(Projects::class)->find($pid);
                if ($proj && $proj->getTenant() === $this->getUser()->getTenant()) $e->setProject($proj);
            } else {
                $e->setProject(null);
            }
            $this->em->flush();
            $this->addFlash('success', 'catalog.updated_success');
            return $this->redirectToRoute('catalog_labor_index');
        }
        $projects = $this->em->getRepository(Projects::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['name' => 'ASC']);
        return $this->render('catalog/labor/edit.html.twig', ['item' => $e, 'projects' => $projects]);
    }

    #[Route('/{id}/delete', name: 'catalog_labor_delete_confirm', requirements: ['id' => '\\d+'], methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteConfirm(int $id): Response
    {
        $e = $this->em->getRepository(Labor::class)->find($id);
        if (!$e || $e->getTenant() !== $this->getUser()->getTenant()) throw $this->createNotFoundException('catalog.not_found');
        return $this->render('catalog/labor/delete_confirm.html.twig', ['item' => $e]);
    }

    #[Route('/{id}/delete', name: 'catalog_labor_delete', requirements: ['id' => '\\d+'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('catalog_labor_delete_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('catalog_labor_index');
        }
        $e = $this->em->getRepository(Labor::class)->find($id);
        if ($e && $e->getTenant() === $this->getUser()->getTenant()) {
            $this->em->remove($e);
            $this->em->flush();
            $this->addFlash('success', 'catalog.deleted_success');
        }
        return $this->redirectToRoute('catalog_labor_index');
    }
}
