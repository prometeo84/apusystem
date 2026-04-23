<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\Projects;
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
        $tenant = $this->getUser()->getTenant();
        $total = count($items);
        $maxItems = $this->getParameter('limits.items_per_tenant');
        $canCreateItem = true;
        if ($maxItems !== null && (int)$maxItems > 0) {
            $canCreateItem = $total < (int)$maxItems;
        }

        return $this->render('items/index.html.twig', ['items' => $items, 'rubros' => $items, 'can_create_item' => $canCreateItem, 'max_items_limit' => $maxItems ?? null]);
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
            $item->setCreatedBy($this->getUser());

            // Log incoming values for debugging E2E creation flakiness
            $payload = [
                'code' => $request->request->get('code', ''),
                'name' => $request->request->get('name', ''),
                'unit' => $request->request->get('unit', ''),
            ];
            $this->logger->info('Item create POST received', ['payload' => $payload]);
            // Also append a debug file to help CI debugging when profiler isn't available
            try {
                @file_put_contents(__DIR__ . '/../../var/log/item_create_debug.log', date('c') . " " . json_encode($payload) . "\n", FILE_APPEND | LOCK_EX);
            } catch (\Throwable $e) {
                // ignore
            }

            $code = trim($request->request->get('code', ''));
            $name = trim($request->request->get('name', ''));
            $description = trim($request->request->get('description', '')) ?: null;
            $unit = trim($request->request->get('unit', '')) ?: null;

            $item->setCode($code);
            $item->setName($name);
            $item->setDescription($description);
            $item->setUnit($unit);

            // Visibility: tenant-wide or project-specific
            $visibility = $request->request->get('visibility', 'tenant');
            $projectId = $request->request->get('project_id');
            if ($visibility === 'project' && $projectId) {
                $project = $this->em->getRepository(Projects::class)->findOneBy([
                    'id' => (int)$projectId,
                    'tenant' => $this->getUser()->getTenant(),
                ]);
                if ($project) {
                    $item->setProject($project);
                }
            }

            // Manual quick checks to ensure immediate feedback in templates
            $fieldErrors = [];
            if ($code === '' || !preg_match('/^[A-Za-z0-9\-\_\.]+$/', $code)) {
                $fieldErrors['code'][] = 'code.invalid';
            }
            if ($name === '' || !preg_match('/^(?=.*\\p{L})[\\p{L}\\d\\s\\-\\.\\_\\(\\),\\/]+$/u', $name)) {
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
                return $this->render('items/create.html.twig', ['fieldErrors' => $fieldErrors, 'item' => $item, 'projects' => $this->em->getRepository(Projects::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['createdAt' => 'DESC'])]);
            }

            $this->logger->info('Item create validation passed', ['code' => $code, 'name' => $name, 'unit' => $unit]);

            try {
                $this->em->persist($item);
                $this->em->flush();
            } catch (\Throwable $ex) {
                $this->logger->error('Item persist/flush failed', ['exception' => (string) $ex, 'code' => $code, 'name' => $name]);
                $this->addFlash('error', 'rubro.create_error');
                return $this->render('items/create.html.twig', ['fieldErrors' => ['exception' => [$ex->getMessage()]], 'item' => $item, 'projects' => $this->em->getRepository(Projects::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['createdAt' => 'DESC'])]);
            }

            $this->addFlash('success', 'rubro.created_success');
            return $this->redirectToRoute('app_item_index');
        }

        return $this->render('items/create.html.twig', ['projects' => $this->em->getRepository(Projects::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['createdAt' => 'DESC'])]);
    }

    #[Route('/{id}/edit', name: 'app_item_edit', requirements: ['id' => '\\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(int $id, Request $request): Response
    {
        $item = $this->em->getRepository(Item::class)->find($id);
        if (!$item || $item->getTenant() !== $this->getUser()->getTenant()) {
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

            // Allow changing visibility/project
            $visibility = $request->request->get('visibility', 'tenant');
            $projectId = $request->request->get('project_id');
            if ($visibility === 'project' && $projectId) {
                $project = $this->em->getRepository(Projects::class)->findOneBy([
                    'id' => (int)$projectId,
                    'tenant' => $this->getUser()->getTenant(),
                ]);
                if ($project) {
                    $item->setProject($project);
                }
            } else {
                $item->setProject(null);
            }

            $this->em->flush();
            $this->addFlash('success', 'rubro.updated_success');
            return $this->redirectToRoute('app_item_index');
        }

        return $this->render('items/edit.html.twig', ['item' => $item, 'projects' => $this->em->getRepository(Projects::class)->findBy(['tenant' => $this->getUser()->getTenant()], ['createdAt' => 'DESC'])]);
    }

    #[Route('/{id}/delete', name: 'app_item_delete_confirm', requirements: ['id' => '\\d+'], methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteConfirm(int $id): Response
    {
        $item = $this->em->getRepository(Item::class)->find($id);
        if (!$item || $item->getTenant() !== $this->getUser()->getTenant()) {
            throw $this->createNotFoundException('rubro.not_found');
        }

        return $this->render('items/delete_confirm.html.twig', ['item' => $item]);
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
        if ($item && $item->getTenant() === $this->getUser()->getTenant()) {
            $this->em->remove($item);
            $this->em->flush();
            $this->addFlash('success', 'rubro.deleted_success');
        }

        return $this->redirectToRoute('app_item_index');
    }
}
