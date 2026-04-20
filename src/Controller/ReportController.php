<?php

namespace App\Controller;

use App\Entity\Template;
use App\Entity\Projects;
use App\Service\BudgetReportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/reports')]
#[IsGranted('ROLE_USER')]
class ReportController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private BudgetReportService $reportService
    ) {}

    private function getTemplate(int $projectId, int $id): Template
    {
        $project = $this->em->getRepository(Projects::class)->findOneBy([
            'id' => $projectId,
            'tenant' => $this->getUser()->getTenant(),
        ]);
        if (!$project) {
            throw $this->createNotFoundException();
        }

        $template = $this->em->getRepository(Template::class)->findOneBy([
            'id' => $id,
            'project' => $project,
        ]);
        if (!$template) {
            throw $this->createNotFoundException();
        }

        return $template;
    }

    /** Vista previa HTML del reporte */
    #[Route('/project/{projectId}/plantilla/{id}', name: 'app_report_plantilla', requirements: ['projectId' => '\d+', 'id' => '\d+'])]
    public function preview(int $projectId, int $id): Response
    {
        $template = $this->getTemplate($projectId, $id);

        return $this->render('reports/preview.html.twig', [
            'template' => $template,
            'project'   => $template->getProject(),
            'html'      => $this->reportService->buildHtml($template),
        ]);
    }

    /** Exportar PDF del presupuesto */
    #[Route('/project/{projectId}/plantilla/{id}/pdf', name: 'app_report_plantilla_pdf', requirements: ['projectId' => '\d+', 'id' => '\d+'])]
    public function pdf(int $projectId, int $id): Response
    {
        $template = $this->getTemplate($projectId, $id);

        $filepath = $this->reportService->generatePdf($template);

        if (!file_exists($filepath)) {
            throw $this->createNotFoundException('report.pdf_error');
        }

        $real = realpath($filepath);
        $tmp = realpath(sys_get_temp_dir());
        if ($real === false || $tmp === false || strpos($real, $tmp) !== 0) {
            throw $this->createNotFoundException('report.pdf_error');
        }

        $safeName = preg_replace('/[^a-z0-9_\-]/i', '_', $template->getName());
        return $this->file($real, 'Presupuesto_' . $safeName . '.pdf');
    }

    /** Exportar Excel del presupuesto */
    #[Route('/project/{projectId}/plantilla/{id}/excel', name: 'app_report_plantilla_excel', requirements: ['projectId' => '\d+', 'id' => '\d+'])]
    public function excel(int $projectId, int $id): Response
    {
        $template = $this->getTemplate($projectId, $id);

        $filepath = $this->reportService->generateExcel($template);

        if (!file_exists($filepath)) {
            throw $this->createNotFoundException('report.excel_error');
        }

        $real = realpath($filepath);
        $tmp = realpath(sys_get_temp_dir());
        if ($real === false || $tmp === false || strpos($real, $tmp) !== 0) {
            throw $this->createNotFoundException('report.excel_error');
        }

        $safeName = preg_replace('/[^a-z0-9_\-]/i', '_', $template->getName());
        return $this->file($real, 'Presupuesto_' . $safeName . '.xlsx');
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

        $safeName = preg_replace('/[^a-z0-9_\-]/i', '_', $project->getName());
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

        $safeName = preg_replace('/[^a-z0-9_\-]/i', '_', $project->getName());
        return $this->file($filepath, 'Proyecto_' . $safeName . '.xlsx');
    }
}
