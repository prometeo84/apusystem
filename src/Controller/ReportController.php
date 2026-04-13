<?php

namespace App\Controller;

use App\Entity\Plantilla;
use App\Entity\Projects;
use App\Service\BudgetReportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/reports')]
#[IsGranted('ROLE_USER')]
class ReportController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private BudgetReportService $reportService
    ) {}

    private function getPlantilla(int $projectId, int $id): Plantilla
    {
        $project = $this->em->getRepository(Projects::class)->findOneBy([
            'id' => $projectId,
            'tenant' => $this->getUser()->getTenant(),
        ]);
        if (!$project) {
            throw $this->createNotFoundException();
        }

        $plantilla = $this->em->getRepository(Plantilla::class)->findOneBy([
            'id' => $id,
            'proyecto' => $project,
        ]);
        if (!$plantilla) {
            throw $this->createNotFoundException();
        }

        return $plantilla;
    }

    /** Vista previa HTML del reporte */
    #[Route('/project/{projectId}/plantilla/{id}', name: 'app_report_plantilla', requirements: ['projectId' => '\d+', 'id' => '\d+'])]
    public function preview(int $projectId, int $id): Response
    {
        $plantilla = $this->getPlantilla($projectId, $id);

        return $this->render('reports/preview.html.twig', [
            'plantilla' => $plantilla,
            'project'   => $plantilla->getProyecto(),
            'html'      => $this->reportService->buildHtml($plantilla),
        ]);
    }

    /** Exportar PDF del presupuesto */
    #[Route('/project/{projectId}/plantilla/{id}/pdf', name: 'app_report_plantilla_pdf', requirements: ['projectId' => '\d+', 'id' => '\d+'])]
    public function pdf(int $projectId, int $id): Response
    {
        $plantilla = $this->getPlantilla($projectId, $id);

        $filepath = $this->reportService->generatePdf($plantilla);

        if (!file_exists($filepath)) {
            throw $this->createNotFoundException('report.pdf_error');
        }

        $safeName = preg_replace('/[^a-z0-9_\-]/i', '_', $plantilla->getNombre());
        return $this->file($filepath, 'Presupuesto_' . $safeName . '.pdf');
    }

    /** Exportar Excel del presupuesto */
    #[Route('/project/{projectId}/plantilla/{id}/excel', name: 'app_report_plantilla_excel', requirements: ['projectId' => '\d+', 'id' => '\d+'])]
    public function excel(int $projectId, int $id): Response
    {
        $plantilla = $this->getPlantilla($projectId, $id);

        $filepath = $this->reportService->generateExcel($plantilla);

        if (!file_exists($filepath)) {
            throw $this->createNotFoundException('report.excel_error');
        }

        $safeName = preg_replace('/[^a-z0-9_\-]/i', '_', $plantilla->getNombre());
        return $this->file($filepath, 'Presupuesto_' . $safeName . '.xlsx');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // REPORTE COMPLETO DEL PROYECTO
    // ─────────────────────────────────────────────────────────────────────────

    private function getProject(int $id): Projects
    {
        $project = $this->em->getRepository(Projects::class)->findOneBy([
            'id'     => $id,
            'tenant' => $this->getUser()->getTenant(),
        ]);
        if (!$project) {
            throw $this->createNotFoundException();
        }
        return $project;
    }

    /** Vista previa HTML del reporte completo del proyecto */
    #[Route('/project/{id}/full', name: 'app_report_project_full', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_ADMIN')]
    public function projectFull(int $id): Response
    {
        $project = $this->getProject($id);

        return $this->render('reports/project_preview.html.twig', [
            'project' => $project,
            'html'    => $this->reportService->buildProjectHtml($project),
        ]);
    }

    /** Exportar PDF del presupuesto completo del proyecto */
    #[Route('/project/{id}/full/pdf', name: 'app_report_project_full_pdf', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_ADMIN')]
    public function projectFullPdf(int $id): Response
    {
        $project = $this->getProject($id);

        $filepath = $this->reportService->generateProjectPdf($project);

        if (!file_exists($filepath)) {
            throw $this->createNotFoundException('report.pdf_error');
        }

        $safeName = preg_replace('/[^a-z0-9_\-]/i', '_', $project->getNombre());
        return $this->file($filepath, 'Proyecto_' . $safeName . '.pdf');
    }

    /** Exportar Excel del presupuesto completo del proyecto */
    #[Route('/project/{id}/full/excel', name: 'app_report_project_full_excel', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_ADMIN')]
    public function projectFullExcel(int $id): Response
    {
        $project = $this->getProject($id);

        $filepath = $this->reportService->generateProjectExcel($project);

        if (!file_exists($filepath)) {
            throw $this->createNotFoundException('report.excel_error');
        }

        $safeName = preg_replace('/[^a-z0-9_\-]/i', '_', $project->getNombre());
        return $this->file($filepath, 'Proyecto_' . $safeName . '.xlsx');
    }
}
