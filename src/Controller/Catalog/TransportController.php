<?php

namespace App\Controller\Catalog;

use App\Entity\Transport;
use App\Entity\Projects;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/catalog/transport')]
#[IsGranted('ROLE_USER')]
class TransportController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('/', name: 'catalog_transport_index')]
    public function index(): Response
    {
        $items = $this->em->getRepository(Transport::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['code' => 'ASC']);
        return $this->render('catalog/transport/index.html.twig', ['items' => $items]);
    }

    #[Route('/json', name: 'catalog_transport_json', methods: ['GET'])]
    public function listJson(): JsonResponse
    {
        $items = $this->em->getRepository(Transport::class)->findBy(['tenant' => $this->getUser()->getTenant(), 'active' => true], ['code' => 'ASC']);
        $data = array_map(fn(Transport $e) => ['id' => $e->getId(), 'code' => $e->getCode(), 'name' => $e->getName(), 'unit' => $e->getUnit()], $items);
        return $this->json($data);
    }

    #[Route('/create', name: 'catalog_transport_create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('transport_create', $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('catalog_transport_create');
            }

            $e = new Transport();
            $e->setTenant($this->getUser()->getTenant());
            $e->setCode(trim($request->request->get('code', '')));
            $e->setName(trim($request->request->get('name', '')));
            $e->setUnit(trim($request->request->get('unit', '')) ?: null);
            $e->setActive((bool)$request->request->get('active'));
            $visibility = $request->request->get('visibility');
            if ($visibility === 'project') {
                $pid = (int)$request->request->get('project_id');
                $proj = $this->em->getRepository(Projects::class)->find($pid);
                if ($proj && $proj->getTenant() === $this->getUser()->getTenant()) $e->setProject($proj);
            } else {
                $e->setProject(null);
            }

            $this->em->persist($e);
            $this->em->flush();
            $this->addFlash('success', 'catalog.created_success');
            return $this->redirectToRoute('catalog_transport_create');
        }

        $projects = $this->em->getRepository(Projects::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['name' => 'ASC']);
        return $this->render('catalog/transport/create.html.twig', ['projects' => $projects]);
    }

    #[Route('/{id}/edit', name: 'catalog_transport_edit', requirements: ['id' => '\\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(int $id, Request $request): Response
    {
        $e = $this->em->getRepository(Transport::class)->find($id);
        if (!$e || $e->getTenant() !== $this->getUser()->getTenant()) throw $this->createNotFoundException('catalog.not_found');
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('transport_edit_' . $id, $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('catalog_transport_edit', ['id' => $id]);
            }
            $e->setCode(trim($request->request->get('code', '')));
            $e->setName(trim($request->request->get('name', '')));
            $e->setUnit(trim($request->request->get('unit', '')) ?: null);
            $e->setActive((bool)$request->request->get('active'));
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
            return $this->redirectToRoute('catalog_transport_index');
        }
        $projects = $this->em->getRepository(Projects::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['name' => 'ASC']);
        return $this->render('catalog/transport/edit.html.twig', ['item' => $e, 'projects' => $projects]);
    }

    #[Route('/{id}/delete', name: 'catalog_transport_delete_confirm', requirements: ['id' => '\\d+'], methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteConfirm(int $id): Response
    {
        $e = $this->em->getRepository(Transport::class)->find($id);
        if (!$e || $e->getTenant() !== $this->getUser()->getTenant()) throw $this->createNotFoundException('catalog.not_found');
        return $this->render('catalog/transport/delete_confirm.html.twig', ['item' => $e]);
    }

    #[Route('/{id}/delete', name: 'catalog_transport_delete', requirements: ['id' => '\\d+'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('catalog_transport_delete_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('catalog_transport_index');
        }
        $e = $this->em->getRepository(Transport::class)->find($id);
        if ($e && $e->getTenant() === $this->getUser()->getTenant()) {
            $this->em->remove($e);
            $this->em->flush();
            $this->addFlash('success', 'catalog.deleted_success');
        }
        return $this->redirectToRoute('catalog_transport_index');
    }
}
