<?php

namespace App\Controller;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;

#[Route('/items')]
#[IsGranted('ROLE_USER')]
class ItemController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em, private ValidatorInterface $validator, private LoggerInterface $logger) {}

    #[Route('/', name: 'app_item_index')]
    public function index(): Response
    {
        $items = $this->em->getRepository(Item::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['code' => 'ASC']);
        // Expose both `items` (new) and `rubros` (legacy) for compatibility while templates migrate.
        return $this->render('items/index.html.twig', ['items' => $items, 'rubros' => $items]);
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

            // Log incoming values for debugging E2E creation flakiness
            $this->logger->info('Item create POST received', [
                'payload' => [
                    'code' => $request->request->get('code', ''),
                    'name' => $request->request->get('name', ''),
                    'unit' => $request->request->get('unit', ''),
                ],
            ]);

            $code = trim($request->request->get('code', ''));
            $name = trim($request->request->get('name', ''));
            $description = trim($request->request->get('description', '')) ?: null;
            $unit = trim($request->request->get('unit', '')) ?: null;

            $item->setCode($code);
            $item->setName($name);
            $item->setDescription($description);
            $item->setUnit($unit);

            // Manual quick checks to ensure immediate feedback in templates
            $fieldErrors = [];
            if ($code === '' || !preg_match('/^[A-Za-z0-9]+$/', $code)) {
                $fieldErrors['code'][] = 'code.invalid';
            }
            if ($name === '' || !preg_match('/^[\p{L}\s]+$/u', $name)) {
                $fieldErrors['name'][] = 'name.invalid';
            }
            if ($unit === null || $unit === '') {
                $fieldErrors['unit'][] = 'unit.required';
            }

            // Run validator for additional checks but merge results
            $errors = $this->validator->validate($item);
            foreach ($errors as $e) {
                $fieldErrors[$e->getPropertyPath()][] = $e->getMessage();
            }

            if (count($fieldErrors) > 0) {
                $this->logger->info('Item create validation failed', ['code' => $code, 'name' => $name, 'unit' => $unit, 'fieldErrors' => $fieldErrors]);
                return $this->render('items/create.html.twig', ['fieldErrors' => $fieldErrors, 'item' => $item]);
            }

            $this->logger->info('Item create validation passed', ['code' => $code, 'name' => $name, 'unit' => $unit]);

            try {
                $this->em->persist($item);
                $this->em->flush();
            } catch (\Throwable $ex) {
                $this->logger->error('Item persist/flush failed', ['exception' => (string) $ex, 'code' => $code, 'name' => $name]);
                $this->addFlash('error', 'rubro.create_error');
                return $this->render('items/create.html.twig', ['fieldErrors' => ['exception' => [$ex->getMessage()]], 'item' => $item]);
            }

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

            $item->setCode(trim($request->request->get('code', '')));
            $item->setName(trim($request->request->get('name', '')));
            $item->setDescription(trim($request->request->get('description', '')) ?: null);
            $item->setUnit(trim($request->request->get('unit', '')) ?: null);

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
