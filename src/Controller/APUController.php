<?php

namespace App\Controller;

use App\Entity\APUItem;
use App\Entity\APUEquipment;
use App\Entity\APULabor;
use App\Entity\APUMaterial;
use App\Entity\APUTransport;
use App\Entity\APURubro;
use App\Entity\Item;
use App\Entity\TemplateItem;
use App\Entity\Template;
use App\Entity\Equipment;
use App\Entity\Labor;
use App\Entity\Material;
use App\Entity\Transport;
use App\Service\ExcelReportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/apu')]
#[IsGranted('ROLE_USER')]
class APUController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private ExcelReportService $excelReportService
    ) {}

    #[Route('/', name: 'app_apu_index')]
    public function index(Request $request): Response
    {
        $tenant = $this->getUser()->getTenant();
        $perPage = 20;
        $currentPage = max(1, (int) $request->query->get('page', 1));

        $repo = $this->em->getRepository(APUItem::class);
        $totalItems = $repo->count(['tenant' => $tenant]);
        $totalPages = max(1, (int) ceil($totalItems / $perPage));
        $currentPage = min($currentPage, $totalPages);

        $apuItems = $repo->findBy(
            ['tenant' => $tenant],
            ['createdAt' => 'DESC'],
            $perPage,
            ($currentPage - 1) * $perPage
        );

        $maxApus = $this->getParameter('limits.apus_per_tenant');
        $canCreateApu = $maxApus === null || $totalItems < (int) $maxApus;

        return $this->render('apu/index.html.twig', [
            'apu_items'     => $apuItems,
            'currentPage'   => $currentPage,
            'totalPages'    => $totalPages,
            'totalItems'    => $totalItems,
            'perPage'       => $perPage,
            'can_create_apu' => $canCreateApu,
            'max_apus_limit' => $maxApus,
        ]);
    }

    #[Route('/create', name: 'app_apu_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        // Administradores no pueden crear APUs via UI
        if ($this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Admins cannot create APUs');
        }

        if ($request->isMethod('POST')) {
            return $this->handleCreate($request);
        }

        return $this->render('apu/create.html.twig', [
            'catalog_data'  => $this->getCatalogData(),
            'items_catalog' => $this->getItemsCatalog(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_apu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        $apuItem = $this->em->getRepository(APUItem::class)->find($id);

        if (!$apuItem || $apuItem->getTenant() !== $this->getUser()->getTenant()) {
            throw $this->createNotFoundException('APU Item not found');
        }

        // Detectar si este APU está vinculado a un TemplateItem (para saber a dónde redirigir)
        $templateItem = $this->em->getRepository(TemplateItem::class)->findOneBy(['apuItem' => $apuItem]);

        if ($request->isMethod('POST')) {
            return $this->handleUpdate($request, $apuItem, $templateItem);
        }

        return $this->render('apu/edit.html.twig', [
            'apu_item'      => $apuItem,
            'templateItem'  => $templateItem,
            'catalog_data'  => $this->getCatalogData(),
            'items_catalog' => $this->getItemsCatalog(),
        ]);
    }

    #[Route('/{id}/export/excel', name: 'app_apu_export_excel')]
    public function exportExcel(int $id): Response
    {
        $apuItem = $this->em->getRepository(APUItem::class)->find($id);

        if (!$apuItem || $apuItem->getTenant() !== $this->getUser()->getTenant()) {
            throw $this->createNotFoundException();
        }

        // Generar Excel
        $filepath = $this->excelReportService->generateAPUReport($apuItem);

        if (!file_exists($filepath) || !is_readable($filepath)) {
            throw $this->createNotFoundException('apu.export_error');
        }

        $real = realpath($filepath);
        $tmp = realpath(sys_get_temp_dir());
        if ($real === false || $tmp === false || strpos($real, $tmp) !== 0) {
            throw $this->createNotFoundException('apu.export_error');
        }

        return $this->file($real, 'APU_' . $apuItem->getId() . '.xlsx');
    }

    /** Crear APU vinculado a un PlantillaRubro específico */
    #[Route('/create-for-rubro/{plantillaRubroId}', name: 'app_apu_create_for_rubro', requirements: ['plantillaRubroId' => '\d+'], methods: ['GET', 'POST'])]
    public function createForRubro(int $plantillaRubroId, Request $request): Response
    {
        $pr = $this->em->getRepository(TemplateItem::class)->find($plantillaRubroId);

        if (!$pr || $pr->getTemplate()->getTenant()->getId() !== $this->getUser()->getTenant()->getId()) {
            throw $this->createNotFoundException();
        }

        // Administradores no pueden crear APUs via UI
        if ($this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Admins cannot create APUs');
        }

        if ($request->isMethod('POST')) {
            $apuItem = $this->buildApuFromRequest($request);
            $apuItem->setDescription($apuItem->getDescription() ?: $pr->getItem()->getName());
            $apuItem->setUnit($apuItem->getUnit() ?: $pr->getItem()->getUnit());

            // Enforce APU limit
            $tenant = $this->getUser()->getTenant();
            $repo = $this->em->getRepository(APUItem::class);
            $current = $repo->count(['tenant' => $tenant]);
            $maxApus = $this->getParameter('limits.apus_per_tenant');
            if ($maxApus !== null && (int)$maxApus > 0 && $current >= (int)$maxApus) {
                $this->addFlash('error', 'apu.limit_reached');
                return $this->render('apu/create.html.twig', [
                    'plantillaRubroId' => $plantillaRubroId,
                    'rubroNombre' => $pr->getItem()->getName(),
                    'rubroUnidad' => $pr->getItem()->getUnit(),
                    'apu_item' => $apuItem,
                    'catalog_data' => $this->getCatalogData(),
                    'items_catalog' => $this->getItemsCatalog(),
                    'projectId' => $pr->getTemplate()->getProject()->getId(),
                ]);
            }

            $this->em->persist($apuItem);

            $pr->setApuItem($apuItem);
            $this->em->flush();

            $this->addFlash('success', 'flash.apu_created');

            $plantilla = $pr->getTemplate();
            return $this->redirectToRoute('app_template_show', [
                'projectId' => $plantilla->getProject()->getId(),
                'id' => $plantilla->getId(),
            ]);
        }

        return $this->render('apu/create.html.twig', [
            'plantillaRubroId' => $plantillaRubroId,
            'rubroNombre' => $pr->getItem()->getName(),
            'rubroUnidad' => $pr->getItem()->getUnit(),
            'catalog_data' => $this->getCatalogData(),
            'items_catalog' => $this->getItemsCatalog(),
            'projectId' => $pr->getTemplate()->getProject()->getId(),
        ]);
    }

    /** Crear APU vinculado a una Plantilla (seleccionando el TemplateItem) */
    #[Route('/create-for-template/{templateId}', name: 'app_apu_create_for_template', requirements: ['templateId' => '\\d+'], methods: ['GET', 'POST'])]
    public function createForTemplate(int $templateId, Request $request): Response
    {
        $template = $this->em->getRepository(Template::class)->find($templateId);

        if (!$template || $template->getTenant()->getId() !== $this->getUser()->getTenant()->getId()) {
            throw $this->createNotFoundException();
        }

        // Administradores no pueden crear APUs via UI
        if ($this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Admins cannot create APUs');
        }

        // TemplateItems disponibles para vincular (sin APU todavía)
        $pendingItems = $this->em->getRepository(TemplateItem::class)->findBy(['template' => $template, 'apuItem' => null]);

        if ($request->isMethod('POST')) {
            $templateItemId = $request->request->get('template_item_id');
            $pr = null;
            if ($templateItemId) {
                $pr = $this->em->getRepository(TemplateItem::class)->find((int) $templateItemId);
            }

            // If no specific template_item_id provided, try to use the first pending TemplateItem
            if (!$pr) {
                if (count($pendingItems) > 0) {
                    $pr = $pendingItems[0];
                } else {
                    $this->addFlash('error', 'rubro.not_found');
                    return $this->redirectToRoute('app_apu_create_for_template', ['templateId' => $templateId]);
                }
            }
            if ($pr->getTemplate()->getId() !== $template->getId()) {
                $this->addFlash('error', 'rubro.not_found');
                return $this->redirectToRoute('app_apu_create_for_template', ['templateId' => $templateId]);
            }

            $apuItem = $this->buildApuFromRequest($request);
            $apuItem->setDescription($apuItem->getDescription() ?: $pr->getItem()->getName());
            $apuItem->setUnit($apuItem->getUnit() ?: $pr->getItem()->getUnit());

            // Enforce APU limit
            $tenant = $this->getUser()->getTenant();
            $repo = $this->em->getRepository(APUItem::class);
            $current = $repo->count(['tenant' => $tenant]);
            $maxApus = $this->getParameter('limits.apus_per_tenant');
            if ($maxApus !== null && (int)$maxApus > 0 && $current >= (int)$maxApus) {
                $this->addFlash('error', 'apu.limit_reached');
                return $this->render('apu/create.html.twig', [
                    'templateId' => $templateId,
                    'template_items' => $pendingItems,
                    'apu_item' => $apuItem,
                    'catalog_data' => $this->getCatalogData(),
                    'items_catalog' => $this->getItemsCatalog(),
                    'projectId' => $template->getProject()->getId(),
                ]);
            }

            $this->em->persist($apuItem);
            $pr->setApuItem($apuItem);
            $this->em->flush();

            $this->addFlash('success', 'flash.apu_created');

            return $this->redirectToRoute('app_template_show', [
                'projectId' => $template->getProject()->getId(),
                'id' => $template->getId(),
            ]);
        }

        return $this->render('apu/create.html.twig', [
            'templateId' => $templateId,
            'template_items' => $pendingItems,
            'catalog_data' => $this->getCatalogData(),
            'items_catalog' => $this->getItemsCatalog(),
            'projectId' => $template->getProject()->getId(),
        ]);
    }

    private function handleCreate(Request $request): Response
    {
        // Prevent admins from creating APU via direct POST
        if ($this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Admins cannot create APUs');
        }

        $apuItem = $this->buildApuFromRequest($request);

        // Check tenant APU limit (optional parameter)
        $tenant = $this->getUser()->getTenant();
        $repo = $this->em->getRepository(APUItem::class);
        $current = $repo->count(['tenant' => $tenant]);
        $maxApus = $this->getParameter('limits.apus_per_tenant');
        if ($maxApus !== null && (int)$maxApus > 0 && $current >= (int)$maxApus) {
            $this->addFlash('error', 'apu.limit_reached');
            return $this->render('apu/create.html.twig', ['apu_item' => $apuItem, 'catalog_data' => $this->getCatalogData(), 'items_catalog' => $this->getItemsCatalog()]);
        }

        $this->em->persist($apuItem);
        $this->em->flush();

        $this->addFlash('success', 'flash.apu_created');

        return $this->redirectToRoute('app_apu_index');
    }

    private function getItemsCatalog(): array
    {
        $tenant = $this->getUser()->getTenant();
        $items = $this->em->getRepository(Item::class)->findBy(
            ['tenant' => $tenant, 'active' => true],
            ['code' => 'ASC']
        );
        return array_map(fn(Item $it) => [
            'id'   => $it->getId(),
            'code' => $it->getCode(),
            'name' => $it->getName(),
            'unit' => $it->getUnit(),
        ], $items);
    }

    private function getCatalogData(): array
    {
        $tenant = $this->getUser()->getTenant();

        $mapEquipment = fn(array $items) => array_map(fn(Equipment $e) => [
            'id'   => $e->getId(),
            'code' => $e->getCode(),
            'name' => $e->getName(),
            'unit' => $e->getUnit(),
        ], $items);

        $mapLabor = fn(array $items) => array_map(fn(Labor $e) => [
            'id'   => $e->getId(),
            'code' => $e->getCode(),
            'name' => $e->getDescription(),
            'unit' => $e->getUnit(),
        ], $items);

        $mapMaterial = fn(array $items) => array_map(fn(Material $e) => [
            'id'   => $e->getId(),
            'code' => $e->getCode(),
            'name' => $e->getName(),
            'unit' => $e->getUnit(),
        ], $items);

        $mapTransport = fn(array $items) => array_map(fn(Transport $e) => [
            'id'   => $e->getId(),
            'code' => $e->getCode(),
            'name' => $e->getName(),
            'unit' => $e->getUnit(),
        ], $items);

        return [
            'equipment' => $mapEquipment($this->em->getRepository(Equipment::class)->findBy(['tenant' => $tenant, 'active' => true], ['code' => 'ASC'])),
            'labor'     => $mapLabor($this->em->getRepository(Labor::class)->findBy(['tenant' => $tenant, 'active' => true], ['code' => 'ASC'])),
            'material'  => $mapMaterial($this->em->getRepository(Material::class)->findBy(['tenant' => $tenant, 'active' => true], ['code' => 'ASC'])),
            'transport' => $mapTransport($this->em->getRepository(Transport::class)->findBy(['tenant' => $tenant, 'active' => true], ['code' => 'ASC'])),
        ];
    }

    private function buildApuFromRequest(Request $request): APUItem
    {
        $data = $request->request->all();
        $tenant = $this->getUser()->getTenant();

        $apuItem = new APUItem();
        $apuItem->setTenant($tenant);
        $apuItem->setCreatedBy($this->getUser());
        $apuItem->setDescription($data['description'] ?? '');
        $apuItem->setUnit($data['unit'] ?? 'u');
        $apuItem->setKhu(isset($data['khu']) && $data['khu'] !== '' ? $data['khu'] : '1.0000');
        $apuItem->setProductivityUh(isset($data['rendimiento_uh']) && $data['rendimiento_uh'] !== '' ? $data['rendimiento_uh'] : '1.0000');
        $apuItem->setProfitPct(isset($data['utilidad_pct']) && $data['utilidad_pct'] !== '' ? (string)(float)$data['utilidad_pct'] : null);
        $apuItem->setIndirectCostPct(isset($data['indirect_cost_pct']) && $data['indirect_cost_pct'] !== '' ? (string)(float)$data['indirect_cost_pct'] : null);
        $apuItem->setOfferedPrice(isset($data['precio_ofertado']) && $data['precio_ofertado'] !== '' ? (string)(float)$data['precio_ofertado'] : null);

        // Procesar rubros (nueva estructura jerárquica)
        if (!empty($data['rubros']) && is_array($data['rubros'])) {
            $this->populateRubros($apuItem, $data['rubros'], $tenant);
        }

        $apuItem->calculateCosts();
        return $apuItem;
    }

    private function handleUpdate(Request $request, APUItem $apuItem, ?TemplateItem $templateItem = null): Response
    {
        $data = $request->request->all();
        $tenant = $apuItem->getTenant();

        $apuItem->setDescription($data['description'] ?? $apuItem->getDescription());
        if (!empty($data['unit'])) {
            $apuItem->setUnit($data['unit']);
        }
        $apuItem->setProfitPct(isset($data['utilidad_pct']) && $data['utilidad_pct'] !== '' ? (string)(float)$data['utilidad_pct'] : null);
        $apuItem->setIndirectCostPct(isset($data['indirect_cost_pct']) && $data['indirect_cost_pct'] !== '' ? (string)(float)$data['indirect_cost_pct'] : null);
        $apuItem->setOfferedPrice(isset($data['precio_ofertado']) && $data['precio_ofertado'] !== '' ? (string)(float)$data['precio_ofertado'] : null);

        // Eliminar rubros anteriores (cascade remove los componentes)
        foreach ($apuItem->getRubros() as $rubro) {
            $apuItem->removeRubro($rubro);
        }

        // Procesar rubros (nueva estructura jerárquica)
        if (!empty($data['rubros']) && is_array($data['rubros'])) {
            $this->populateRubros($apuItem, $data['rubros'], $tenant);
        }

        $apuItem->calculateCosts();
        $this->em->flush();
        $this->addFlash('success', 'flash.apu_updated');

        if ($templateItem) {
            $plantilla = $templateItem->getTemplate();
            return $this->redirectToRoute('app_template_show', [
                'projectId' => $plantilla->getProject()->getId(),
                'id'        => $plantilla->getId(),
            ]);
        }

        return $this->redirectToRoute('app_apu_index');
    }

    /**
     * Populates APURubro objects from form data array.
     * Expected structure: rubros[N][name], rubros[N][item_id],
     *   rubros[N][equipment][M][id|numero|tarifa],
     *   rubros[N][labor][M][id|numero|jor_hora],
     *   rubros[N][materials][M][id|cantidad|precio_unitario],
     *   rubros[N][transport][M][id|cantidad|dmt|tarifa_km]
     */
    private function populateRubros(APUItem $apuItem, array $rubrosData, $tenant): void
    {
        $position = 0;
        foreach ($rubrosData as $rubroData) {
            $rubro = new APURubro();
            $rubro->setName($rubroData['name'] ?? 'Rubro');
            $rubro->setPosition($position++);
            $rubro->setUnit(!empty($rubroData['unit']) ? $rubroData['unit'] : null);
            $rubro->setKhu(isset($rubroData['khu']) && $rubroData['khu'] !== '' ? (float)$rubroData['khu'] : null);
            $rubro->setProductivityUh(isset($rubroData['rendimiento_uh']) && $rubroData['rendimiento_uh'] !== '' ? (float)$rubroData['rendimiento_uh'] : null);

            if (!empty($rubroData['item_id'])) {
                $item = $this->em->getRepository(Item::class)->find((int)$rubroData['item_id']);
                if ($item && $item->getTenant()?->getId() === $tenant->getId()) {
                    $rubro->setItem($item);
                    if (empty($rubroData['name'])) {
                        $rubro->setName($item->getName());
                    }
                }
            }

            // Equipment
            foreach ($rubroData['equipment'] ?? [] as $equipData) {
                $equip = new APUEquipment();
                $equip->setTenant($tenant);
                if (!empty($equipData['id'])) {
                    $eq = $this->em->getRepository(Equipment::class)->find((int)$equipData['id']);
                    if ($eq) {
                        $equip->setEquipment($eq);
                        $equip->setDescription($eq->getName());
                    }
                }
                $equip->setNumber((int)($equipData['numero'] ?? 1));
                $equip->setRate((float)($equipData['tarifa'] ?? 0));
                $equip->setRendimientoUh(isset($equipData['rend_uh']) && $equipData['rend_uh'] !== '' ? (float)$equipData['rend_uh'] : null);
                $equip->setApuRubro($rubro);
                $rubro->addEquipment($equip);
                $apuItem->addEquipment($equip);
            }

            // Labor
            foreach ($rubroData['labor'] ?? [] as $laborData) {
                $labor = new APULabor();
                $labor->setTenant($tenant);
                if (!empty($laborData['id'])) {
                    $labEntity = $this->em->getRepository(Labor::class)->find((int)$laborData['id']);
                    if ($labEntity) $labor->setLabor($labEntity);
                }
                $labor->setNumber((int)($laborData['numero'] ?? 1));
                $labor->setJorHora((float)($laborData['jor_hora'] ?? 0));
                $labor->setRendimientoUh(isset($laborData['rend_uh']) && $laborData['rend_uh'] !== '' ? (float)$laborData['rend_uh'] : null);
                $labor->setApuRubro($rubro);
                $rubro->addLabor($labor);
                $apuItem->addLabor($labor);
            }

            // Materials
            foreach ($rubroData['materials'] ?? [] as $materialData) {
                $material = new APUMaterial();
                $material->setTenant($tenant);
                if (!empty($materialData['id'])) {
                    $matEntity = $this->em->getRepository(Material::class)->find((int)$materialData['id']);
                    if ($matEntity) $material->setMaterial($matEntity);
                }
                $material->setQuantity((float)($materialData['cantidad'] ?? 0));
                $material->setUnitPrice((float)($materialData['precio_unitario'] ?? 0));
                $material->setApuRubro($rubro);
                $rubro->addMaterial($material);
                $apuItem->addMaterial($material);
            }

            // Transport
            foreach ($rubroData['transport'] ?? [] as $transportData) {
                $transport = new APUTransport();
                $transport->setTenant($tenant);
                if (!empty($transportData['id'])) {
                    $trEntity = $this->em->getRepository(Transport::class)->find((int)$transportData['id']);
                    if ($trEntity) {
                        $transport->setTransport($trEntity);
                        $transport->setDescription($trEntity->getName());
                        $transport->setUnit($trEntity->getUnit() ?? '');
                    }
                } else {
                    $transport->setDescription($transportData['description'] ?? '');
                    $transport->setUnit($transportData['unidad'] ?? '');
                }
                $transport->setQuantity((float)($transportData['cantidad'] ?? 0));
                $transport->setDmt((float)($transportData['dmt'] ?? 0));
                $transport->setTarifaKm((float)($transportData['tarifa_km'] ?? 0));
                $transport->setApuRubro($rubro);
                $rubro->addTransport($transport);
                $apuItem->addTransport($transport);
            }

            $apuItem->addRubro($rubro);
        }
    }
}
