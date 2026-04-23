<?php

namespace App\Controller;

use App\Entity\APUItem;
use App\Entity\APUEquipment;
use App\Entity\APULabor;
use App\Entity\APUMaterial;
use App\Entity\APUTransport;
use App\Entity\TemplateItem;
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

        return $this->render('apu/create.html.twig');
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
            'apu_item'     => $apuItem,
            'templateItem' => $templateItem,
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
            return $this->render('apu/create.html.twig', ['apu_item' => $apuItem]);
        }

        $this->em->persist($apuItem);
        $this->em->flush();

        $this->addFlash('success', 'flash.apu_created');

        return $this->redirectToRoute('app_apu_index');
    }

    private function buildApuFromRequest(Request $request): APUItem
    {
        $data = $request->request->all();

        $apuItem = new APUItem();
        $apuItem->setTenant($this->getUser()->getTenant());
        $apuItem->setCreatedBy($this->getUser());
        $apuItem->setDescription($data['description']);
        $apuItem->setUnit($data['unit']);
        $apuItem->setKhu((float)$data['khu']);
        $apuItem->setProductivityUh((float)$data['rendimiento_uh']);
        $apuItem->setProfitPct(isset($data['utilidad_pct']) ? (string)(float)$data['utilidad_pct'] : null);
        $apuItem->setOfferedPrice(isset($data['precio_ofertado']) && $data['precio_ofertado'] !== '' ? (string)(float)$data['precio_ofertado'] : null);

        // Sólo usuarios con ROLE_ADMIN pueden agregar componentes (equipment, labor, materials, transport)
        $allowComponents = $this->isGranted('ROLE_ADMIN');

        if ($allowComponents) {
            if (isset($data['equipment'])) {
                foreach ($data['equipment'] as $equipData) {
                    $equipment = new APUEquipment();
                    if (!empty($equipData['equipment_id'])) {
                        $eq = $this->em->getRepository(\App\Entity\Equipment::class)->find((int)$equipData['equipment_id']);
                        $equipment->setEquipment($eq);
                    }
                    $equipment->setNumber((int)$equipData['numero']);
                    $equipment->setRate((float)$equipData['tarifa']);
                    $equipment->setRendimientoUh(!empty($equipData['rendimiento']) ? (float)$equipData['rendimiento'] : null);
                    // C = A×B is computed by recalculate() inside calculateCosts()
                    // set tenant/project/template/template_item when available
                    $tenant = $apuItem->getTenant();
                    if ($tenant !== null) {
                        $equipment->setTenant($tenant);
                    }
                    if (!empty($data['project_id'])) {
                        $proj = $this->em->getRepository(\App\Entity\Projects::class)->find((int)$data['project_id']);
                        if ($proj) $equipment->setProject($proj);
                    }
                    if (!empty($data['template_id'])) {
                        $tpl = $this->em->getRepository(\App\Entity\Template::class)->find((int)$data['template_id']);
                        if ($tpl) $equipment->setTemplate($tpl);
                    }
                    if (!empty($equipData['template_item_id'])) {
                        $ti = $this->em->getRepository(\App\Entity\TemplateItem::class)->find((int)$equipData['template_item_id']);
                        if ($ti) $equipment->setTemplateItem($ti);
                    }
                    $apuItem->addEquipment($equipment);
                }
            }

            if (isset($data['labor'])) {
                foreach ($data['labor'] as $laborData) {
                    $labor = new APULabor();
                    // link to catalog labor if provided
                    if (!empty($laborData['labor_id'])) {
                        $labEntity = $this->em->getRepository(\App\Entity\Labor::class)->find((int)$laborData['labor_id']);
                        $labor->setLabor($labEntity);
                    }
                    $labor->setNumber((int)$laborData['numero']);
                    $labor->setJorHora((float)$laborData['jor_hora']);
                    $labor->setRendimientoUh(!empty($laborData['rendimiento']) ? (float)$laborData['rendimiento'] : null);
                    // C = A×B is computed by recalculate() inside calculateCosts()
                    // set tenant/project/template/template_item when available
                    $tenant = $apuItem->getTenant();
                    if ($tenant !== null) {
                        $labor->setTenant($tenant);
                    }
                    if (!empty($data['project_id'])) {
                        $proj = $this->em->getRepository(\App\Entity\Projects::class)->find((int)$data['project_id']);
                        if ($proj) $labor->setProject($proj);
                    }
                    if (!empty($data['template_id'])) {
                        $tpl = $this->em->getRepository(\App\Entity\Template::class)->find((int)$data['template_id']);
                        if ($tpl) $labor->setTemplate($tpl);
                    }
                    if (!empty($laborData['template_item_id'])) {
                        $ti = $this->em->getRepository(\App\Entity\TemplateItem::class)->find((int)$laborData['template_item_id']);
                        if ($ti) $labor->setTemplateItem($ti);
                    }
                    $apuItem->addLabor($labor);
                }
            }

            if (isset($data['materials'])) {
                foreach ($data['materials'] as $materialData) {
                    $material = new APUMaterial();
                    // If frontend provided catalog id, link to Material entity
                    if (!empty($materialData['id'])) {
                        $matEntity = $this->em->getRepository(\App\Entity\Material::class)->find((int)$materialData['id']);
                        $material->setMaterial($matEntity);
                        if (empty($materialData['unidad']) && $matEntity !== null) {
                            $materialData['unidad'] = $matEntity->getUnit();
                        }
                    }
                    $material->setQuantity((float)$materialData['cantidad']);
                    $material->setUnitPrice((float)$materialData['precio_unitario']);
                    // set tenant/project/template/template_item when available
                    $tenant = $apuItem->getTenant();
                    if ($tenant !== null) {
                        $material->setTenant($tenant);
                    }
                    if (!empty($data['project_id'])) {
                        $proj = $this->em->getRepository(\App\Entity\Projects::class)->find((int)$data['project_id']);
                        if ($proj) $material->setProject($proj);
                    }
                    if (!empty($data['template_id'])) {
                        $tpl = $this->em->getRepository(\App\Entity\Template::class)->find((int)$data['template_id']);
                        if ($tpl) $material->setTemplate($tpl);
                    }
                    if (!empty($materialData['template_item_id'])) {
                        $ti = $this->em->getRepository(\App\Entity\TemplateItem::class)->find((int)$materialData['template_item_id']);
                        if ($ti) $material->setTemplateItem($ti);
                    }
                    $apuItem->addMaterial($material);
                }
            }

            if (isset($data['transport'])) {
                foreach ($data['transport'] as $transportData) {
                    $transport = new APUTransport();
                    if (!empty($transportData['id'])) {
                        $trEntity = $this->em->getRepository(\App\Entity\Transport::class)->find((int)$transportData['id']);
                        $transport->setTransport($trEntity);
                        if ($trEntity) {
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
                    $tenant = $apuItem->getTenant();
                    if ($tenant !== null) $transport->setTenant($tenant);
                    if (!empty($data['project_id'])) {
                        $proj = $this->em->getRepository(\App\Entity\Projects::class)->find((int)$data['project_id']);
                        if ($proj) $transport->setProject($proj);
                    }
                    if (!empty($data['template_id'])) {
                        $tpl = $this->em->getRepository(\App\Entity\Template::class)->find((int)$data['template_id']);
                        if ($tpl) $transport->setTemplate($tpl);
                    }
                    $apuItem->addTransport($transport);
                }
            }
        }

        $apuItem->calculateCosts();

        return $apuItem;
    }

    private function handleUpdate(Request $request, APUItem $apuItem, ?TemplateItem $templateItem = null): Response
    {
        $data = $request->request->all();

        $apuItem->setDescription($data['description']);
        $apuItem->setUnit($data['unit']);
        $apuItem->setKhu((float)$data['khu']);
        $apuItem->setProductivityUh((float)$data['rendimiento_uh']);
        $apuItem->setProfitPct(isset($data['utilidad_pct']) ? (string)(float)$data['utilidad_pct'] : null);
        $apuItem->setOfferedPrice(isset($data['precio_ofertado']) && $data['precio_ofertado'] !== '' ? (string)(float)$data['precio_ofertado'] : null);

        // Sólo los administradores pueden modificar/replace los componentes.
        if ($this->isGranted('ROLE_ADMIN')) {
            // Eliminar elementos antiguos
            foreach ($apuItem->getEquipment() as $equipment) {
                $apuItem->removeEquipment($equipment);
            }
            foreach ($apuItem->getLabor() as $labor) {
                $apuItem->removeLabor($labor);
            }
            foreach ($apuItem->getMaterials() as $material) {
                $apuItem->removeMaterial($material);
            }
            foreach ($apuItem->getTransport() as $transport) {
                $apuItem->removeTransport($transport);
            }

            // Agregar nuevos elementos
            if (isset($data['equipment'])) {
                foreach ($data['equipment'] as $equipData) {
                    $equipment = new APUEquipment();
                    $equipment->setDescription($equipData['description']);
                    $equipment->setQuantity((int)$equipData['numero']);
                    $equipment->setTarifa((float)$equipData['tarifa']);
                    $equipment->setCHora((float)($equipData['c_hora'] ?? ((float)$equipData['numero'] * (float)$equipData['tarifa'])));
                    $apuItem->addEquipment($equipment);
                }
            }

            if (isset($data['labor'])) {
                foreach ($data['labor'] as $laborData) {
                    $labor = new APULabor();
                    if (!empty($laborData['labor_id'])) {
                        $labEntity = $this->em->getRepository(\App\Entity\Labor::class)->find((int)$laborData['labor_id']);
                        $labor->setLabor($labEntity);
                    }
                    $labor->setNumber((int)$laborData['numero']);
                    $labor->setJorHora((float)$laborData['jor_hora']);
                    $labor->setCHora((float)($laborData['c_hora'] ?? ((float)$laborData['numero'] * (float)$laborData['jor_hora'])));
                    $tenant = $apuItem->getTenant();
                    if ($tenant !== null) {
                        $labor->setTenant($tenant);
                    }
                    if (!empty($data['project_id'])) {
                        $proj = $this->em->getRepository(\App\Entity\Projects::class)->find((int)$data['project_id']);
                        if ($proj) $labor->setProject($proj);
                    }
                    if (!empty($data['template_id'])) {
                        $tpl = $this->em->getRepository(\App\Entity\Template::class)->find((int)$data['template_id']);
                        if ($tpl) $labor->setTemplate($tpl);
                    }
                    if (!empty($laborData['template_item_id'])) {
                        $ti = $this->em->getRepository(\App\Entity\TemplateItem::class)->find((int)$laborData['template_item_id']);
                        if ($ti) $labor->setTemplateItem($ti);
                    }
                    $apuItem->addLabor($labor);
                }
            }

            if (isset($data['materials'])) {
                foreach ($data['materials'] as $materialData) {
                    $material = new APUMaterial();
                    if (!empty($materialData['id'])) {
                        $matEntity = $this->em->getRepository(\App\Entity\Material::class)->find((int)$materialData['id']);
                        $material->setMaterial($matEntity);
                        if (empty($materialData['unidad']) && $matEntity !== null) {
                            $materialData['unidad'] = $matEntity->getUnit();
                        }
                    }
                    $material->setQuantity((float)$materialData['cantidad']);
                    $material->setUnitPrice((float)$materialData['precio_unitario']);
                    $tenant = $apuItem->getTenant();
                    if ($tenant !== null) {
                        $material->setTenant($tenant);
                    }
                    if (!empty($data['project_id'])) {
                        $proj = $this->em->getRepository(\App\Entity\Projects::class)->find((int)$data['project_id']);
                        if ($proj) $material->setProject($proj);
                    }
                    if (!empty($data['template_id'])) {
                        $tpl = $this->em->getRepository(\App\Entity\Template::class)->find((int)$data['template_id']);
                        if ($tpl) $material->setTemplate($tpl);
                    }
                    if (!empty($materialData['template_item_id'])) {
                        $ti = $this->em->getRepository(\App\Entity\TemplateItem::class)->find((int)$materialData['template_item_id']);
                        if ($ti) $material->setTemplateItem($ti);
                    }
                    $apuItem->addMaterial($material);
                }
            }

            if (isset($data['transport'])) {
                foreach ($data['transport'] as $transportData) {
                    $transport = new APUTransport();
                    if (!empty($transportData['id'])) {
                        $trEntity = $this->em->getRepository(\App\Entity\Transport::class)->find((int)$transportData['id']);
                        $transport->setTransport($trEntity);
                        if ($trEntity) {
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
                    $tenant = $apuItem->getTenant();
                    if ($tenant !== null) $transport->setTenant($tenant);
                    if (!empty($data['project_id'])) {
                        $proj = $this->em->getRepository(\App\Entity\Projects::class)->find((int)$data['project_id']);
                        if ($proj) $transport->setProject($proj);
                    }
                    if (!empty($data['template_id'])) {
                        $tpl = $this->em->getRepository(\App\Entity\Template::class)->find((int)$data['template_id']);
                        if ($tpl) $transport->setTemplate($tpl);
                    }
                    $apuItem->addTransport($transport);
                }
            }
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
}
