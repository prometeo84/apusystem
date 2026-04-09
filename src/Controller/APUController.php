<?php

namespace App\Controller;

use App\Entity\APUItem;
use App\Entity\APUEquipment;
use App\Entity\APULabor;
use App\Entity\APUMaterial;
use App\Entity\APUTransport;
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
        private EntityManagerInterface $em
    ) {}

    #[Route('/', name: 'app_apu_index')]
    public function index(): Response
    {
        $tenant = $this->getUser()->getTenant();

        $apuItems = $this->em->getRepository(APUItem::class)
            ->findBy(['tenant' => $tenant], ['createdAt' => 'DESC']);

        return $this->render('apu/index.html.twig', [
            'apu_items' => $apuItems,
        ]);
    }

    #[Route('/create', name: 'app_apu_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
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

        if ($request->isMethod('POST')) {
            return $this->handleUpdate($request, $apuItem);
        }

        return $this->render('apu/edit.html.twig', [
            'apu_item' => $apuItem,
        ]);
    }

    #[Route('/{id}/export/excel', name: 'app_apu_export_excel')]
    public function exportExcel(int $id): Response
    {
        $apuItem = $this->em->getRepository(APUItem::class)->find($id);

        if (!$apuItem || $apuItem->getTenant() !== $this->getUser()->getTenant()) {
            throw $this->createNotFoundException();
        }

        // Generar Excel (se implementará en el servicio)
        $excelService = $this->container->get('app.excel_report_service');
        $filepath = $excelService->generateAPUReport($apuItem);

        return $this->file($filepath, 'APU_' . $apuItem->getId() . '.xlsx');
    }

    private function handleCreate(Request $request): Response
    {
        $data = $request->request->all();

        $apuItem = new APUItem();
        $apuItem->setTenant($this->getUser()->getTenant());
        $apuItem->setDescription($data['description']);
        $apuItem->setUnit($data['unit']);
        $apuItem->setKhu((float)$data['khu']);
        $apuItem->setRendimientoUh((float)$data['rendimiento_uh']);

        // Equipo
        if (isset($data['equipment'])) {
            foreach ($data['equipment'] as $equipData) {
                $equipment = new APUEquipment();
                $equipment->setDescripcion($equipData['descripcion']);
                $equipment->setNumero((int)$equipData['numero']);
                $equipment->setTarifa((float)$equipData['tarifa']);
                $equipment->setCHora((float)$equipData['c_hora']);
                $apuItem->addEquipment($equipment);
            }
        }

        // Mano de Obra
        if (isset($data['labor'])) {
            foreach ($data['labor'] as $laborData) {
                $labor = new APULabor();
                $labor->setDescripcion($laborData['descripcion']);
                $labor->setNumero((int)$laborData['numero']);
                $labor->setJorHora((float)$laborData['jor_hora']);
                $labor->setCHora((float)$laborData['c_hora']);
                $apuItem->addLabor($labor);
            }
        }

        // Materiales
        if (isset($data['materials'])) {
            foreach ($data['materials'] as $materialData) {
                $material = new APUMaterial();
                $material->setDescripcion($materialData['descripcion']);
                $material->setUnidad($materialData['unidad']);
                $material->setCantidad((float)$materialData['cantidad']);
                $material->setPrecioUnitario((float)$materialData['precio_unitario']);
                $apuItem->addMaterial($material);
            }
        }

        // Transporte
        if (isset($data['transport'])) {
            foreach ($data['transport'] as $transportData) {
                $transport = new APUTransport();
                $transport->setDescripcion($transportData['descripcion']);
                $transport->setUnidad($transportData['unidad']);
                $transport->setCantidad((float)$transportData['cantidad']);
                $transport->setDmt((float)$transportData['dmt']);
                $transport->setTarifaKm((float)$transportData['tarifa_km']);
                $apuItem->addTransport($transport);
            }
        }

        // Calcular costos
        $apuItem->calculateCosts();

        $this->em->persist($apuItem);
        $this->em->flush();

        $this->addFlash('success', 'flash.apu_created');

        return $this->redirectToRoute('app_apu_index');
    }

    private function handleUpdate(Request $request, APUItem $apuItem): Response
    {
        $data = $request->request->all();

        $apuItem->setDescription($data['description']);
        $apuItem->setUnit($data['unit']);
        $apuItem->setKhu((float)$data['khu']);
        $apuItem->setRendimientoUh((float)$data['rendimiento_uh']);

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

        // Agregar nuevos elementos (mismo código que handleCreate)
        // ... (código similar al de handleCreate)

        $apuItem->calculateCosts();

        $this->em->flush();

        $this->addFlash('success', 'flash.apu_updated');

        return $this->redirectToRoute('app_apu_index');
    }
}
