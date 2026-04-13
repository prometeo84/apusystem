<?php

namespace App\Controller;

use App\Entity\Rubro;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/rubros')]
#[IsGranted('ROLE_USER')]
class RubroController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    #[Route('/', name: 'app_rubro_index')]
    public function index(Request $request): Response
    {
        $tenant = $this->getUser()->getTenant();
        $perPage = 20;
        $currentPage = max(1, (int) $request->query->get('page', 1));

        $repo = $this->em->getRepository(Rubro::class);
        $totalItems = $repo->count(['tenant' => $tenant]);
        $totalPages = max(1, (int) ceil($totalItems / $perPage));
        $currentPage = min($currentPage, $totalPages);

        $rubros = $repo->findBy(
            ['tenant' => $tenant],
            ['codigo' => 'ASC'],
            $perPage,
            ($currentPage - 1) * $perPage
        );

        return $this->render('rubros/index.html.twig', [
            'rubros'      => $rubros,
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'totalItems'  => $totalItems,
            'perPage'     => $perPage,
        ]);
    }

    #[Route('/create', name: 'app_rubro_create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('rubro_create', $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_rubro_create');
            }

            $rubro = new Rubro();
            $rubro->setTenant($this->getUser()->getTenant());
            $rubro->setCodigo(trim($request->request->get('codigo', '')));
            $rubro->setNombre(trim($request->request->get('nombre', '')));
            $rubro->setDescripcion(trim($request->request->get('descripcion', '')) ?: null);
            $rubro->setUnidad(trim($request->request->get('unidad', '')));
            $rubro->setTipo('personalizado');

            $this->em->persist($rubro);
            $this->em->flush();

            $this->addFlash('success', 'rubro.created_success');
            return $this->redirectToRoute('app_rubro_index');
        }

        return $this->render('rubros/create.html.twig');
    }

    #[Route('/{id}/edit', name: 'app_rubro_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(int $id, Request $request): Response
    {
        $rubro = $this->em->getRepository(Rubro::class)->findOneBy([
            'id' => $id,
            'tenant' => $this->getUser()->getTenant(),
        ]);

        if (!$rubro) {
            throw $this->createNotFoundException();
        }

        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('rubro_edit_' . $id, $request->request->get('_token'))) {
                $this->addFlash('error', 'common.error_invalid_csrf');
                return $this->redirectToRoute('app_rubro_edit', ['id' => $id]);
            }

            $rubro->setCodigo(trim($request->request->get('codigo', '')));
            $rubro->setNombre(trim($request->request->get('nombre', '')));
            $rubro->setDescripcion(trim($request->request->get('descripcion', '')) ?: null);
            $rubro->setUnidad(trim($request->request->get('unidad', '')));
            $rubro->setUpdatedAt(new \DateTime());

            $this->em->flush();

            $this->addFlash('success', 'rubro.updated_success');
            return $this->redirectToRoute('app_rubro_index');
        }

        return $this->render('rubros/edit.html.twig', ['rubro' => $rubro]);
    }

    #[Route('/{id}/delete', name: 'app_rubro_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(int $id, Request $request): Response
    {
        $rubro = $this->em->getRepository(Rubro::class)->findOneBy([
            'id' => $id,
            'tenant' => $this->getUser()->getTenant(),
        ]);

        if (!$rubro) {
            throw $this->createNotFoundException();
        }

        if (!$this->isCsrfTokenValid('rubro_delete_' . $id, $request->request->get('_token'))) {
            $this->addFlash('error', 'common.error_invalid_csrf');
            return $this->redirectToRoute('app_rubro_index');
        }

        $this->em->remove($rubro);
        $this->em->flush();

        $this->addFlash('success', 'rubro.deleted_success');
        return $this->redirectToRoute('app_rubro_index');
    }
}
