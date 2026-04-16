<?php

namespace App\Controller;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/items')]
#[IsGranted('ROLE_USER')]
class ItemController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('/', name: 'app_item_index')]
    public function index(): Response
    {
        $items = $this->em->getRepository(Item::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['codigo' => 'ASC']);
        // Templates expect the variable name `rubros` (legacy naming). Keep compatibility.
        return $this->render('items/index.html.twig', ['rubros' => $items]);
    }

    #[Route('/create', name: 'app_item_create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('rubro_create', $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_item_create');
            }

            $item = new Item();
            $item->setTenant($this->getUser()->getTenant());
            $item->setCode(trim($request->request->get('codigo', '')));
            $item->setName(trim($request->request->get('nombre', '')));
            $item->setDescription(trim($request->request->get('descripcion', '')) ?: null);
            $item->setUnit(trim($request->request->get('unidad', '')) ?: null);

            $this->em->persist($item);
            $this->em->flush();

            $this->addFlash('success', 'rubro.created_success');
            return $this->redirectToRoute('app_item_index');
        }

        return $this->render('items/create.html.twig');
    }

    #[Route('/{id}/edit', name: 'app_item_edit', requirements: ['id' => '\\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(int $id, Request $request): Response
    {
        $item = $this->em->getRepository(Item::class)->find($id);
        if (!$item) {
            throw $this->createNotFoundException('rubro.not_found');
        }

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('rubro_edit_' . $id, $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_item_edit', ['id' => $id]);
            }

            $item->setCode(trim($request->request->get('codigo', '')));
            $item->setName(trim($request->request->get('nombre', '')));
            $item->setDescription(trim($request->request->get('descripcion', '')) ?: null);
            $item->setUnit(trim($request->request->get('unidad', '')) ?: null);

            $this->em->flush();
            $this->addFlash('success', 'rubro.updated_success');
            return $this->redirectToRoute('app_item_index');
        }

        return $this->render('items/edit.html.twig', ['item' => $item]);
    }

    #[Route('/{id}/delete', name: 'app_item_delete', requirements: ['id' => '\\d+'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('rubro_delete_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_item_index');
        }

        $item = $this->em->getRepository(Item::class)->find($id);
        if ($item) {
            $this->em->remove($item);
            $this->em->flush();
            $this->addFlash('success', 'rubro.deleted_success');
        }

        return $this->redirectToRoute('app_item_index');
    }
}
