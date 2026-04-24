<?php

namespace App\Service;

use App\Entity\Template;
use App\Entity\Projects;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Contracts\Translation\TranslatorInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BudgetReportService
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    private function safeSetCellValue($sheet, string $coordinate, $value): void
    {
        // If a range was accidentally provided (e.g. "A1:B1"), use the first cell
        if (strpos($coordinate, ':') !== false) {
            $parts = explode(':', $coordinate);
            $coordinate = $parts[0];
        }
        // PhpSpreadsheet expects a single cell coordinate here
        $sheet->setCellValue($coordinate, $value);
    }
    /**
     * Genera HTML del reporte de presupuesto de una plantilla.
     * Usado tanto para PDF como para visualización web.
     */
    public function buildHtml(Template $plantilla): string
    {
        $proyecto = $plantilla->getProject();
        $rubros   = $plantilla->getItems();
        $total    = $plantilla->getTotalBudget();

        $rows = '';
        $i    = 1;
        foreach ($rubros as $pr) {
            $apu = $pr->getApuItem();
            $precioUnit = $apu ? number_format($pr->getUnitPrice(), 2) : '—';
            $subtotal   = $apu ? number_format($pr->getTotalCost(), 2) : '—';
            $rows .= sprintf(
                '<tr>
                    <td>%d</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td style="text-align:center">%s</td>
                    <td style="text-align:right">%s</td>
                    <td style="text-align:right">$%s</td>
                    <td style="text-align:right">$%s</td>
                </tr>',
                $i++,
                htmlspecialchars($pr->getItem()->getCode()),
                htmlspecialchars($pr->getItem()->getName()),
                htmlspecialchars($pr->getItem()->getUnit()),
                '—',
                $precioUnit,
                $subtotal
            );
        }

        $locale = $this->translator->getLocale();
        $title = $this->translator->trans('report.budget_title');
        $projectLabel = $this->translator->trans('report.project_label');
        $codeLabel = $this->translator->trans('report.code_label');
        $clientLabel = $this->translator->trans('report.client_label');
        $locationLabel = $this->translator->trans('report.location_label');
        $dateLabel = $this->translator->trans('report.date_label');
        $statusLabel = $this->translator->trans('report.status_label');
        $colCode = $this->translator->trans('report.table.col_code');
        $colDesc = $this->translator->trans('report.table.col_description');
        $colUnit = $this->translator->trans('report.table.col_unit');
        $colQty = $this->translator->trans('report.table.col_quantity');
        $colUnitPrice = $this->translator->trans('report.table.col_unit_price');
        $colTotal = $this->translator->trans('report.table.col_total');
        $totalLabel = $this->translator->trans('report.total_label');
        $generated = $this->translator->trans('report.generated_by');

        $totalFormatted = number_format((float)$total, 2, '.', ',');
        $totalFormattedWithDollar = '$' . $totalFormatted;

        return <<<HTML
<!DOCTYPE html>
<html lang="{$locale}">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; color: #333; }
    h1 { font-size: 16px; text-align: center; margin: 0 0 4px; }
    h2 { font-size: 13px; text-align: center; color: #555; margin: 0 0 12px; }
    .meta { font-size: 10px; color: #666; margin-bottom: 16px; }
    .meta td { padding: 2px 8px 2px 0; }
    table.budget { width: 100%; border-collapse: collapse; margin-top: 10px; }
    table.budget th { background: #1a56db; color: #fff; padding: 6px 4px; text-align: left; }
    table.budget td { padding: 5px 4px; border-bottom: 1px solid #e5e7eb; }
    table.budget tr:nth-child(even) td { background: #f8faff; }
    .total-row td { font-weight: bold; background: #e0e7ff; padding: 7px 4px; border-top: 2px solid #1a56db; }
    .footer { margin-top: 20px; font-size: 9px; color: #aaa; text-align: center; }
</style>
</head>
<body>
<h1>{$title}</h1>
<h2>{$plantilla->getName()}</h2>
<table class="meta">
    <tr><td><b>{$projectLabel}</b></td><td>{$proyecto->getName()}</td><td><b>{$codeLabel}</b></td><td>{$proyecto->getCode()}</td></tr>
    <tr><td><b>{$clientLabel}</b></td><td>{$proyecto->getClient()}</td><td><b>{$locationLabel}</b></td><td>{$proyecto->getLocation()}</td></tr>
    <tr><td><b>{$dateLabel}</b></td><td>{$plantilla->getCreatedAt()->format('d/m/Y')}</td><td><b>{$statusLabel}</b></td><td>{$proyecto->getStatus()}</td></tr>
</table>

<table class="budget">
    <thead>
        <tr>
            <th>#</th><th>{$colCode}</th><th>{$colDesc}</th>
            <th style="text-align:center">{$colUnit}</th>
            <th style="text-align:right">{$colQty}</th>
            <th style="text-align:right">{$colUnitPrice}</th>
            <th style="text-align:right">{$colTotal}</th>
        </tr>
    </thead>
    <tbody>{$rows}</tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="6" style="text-align:right">{$totalLabel}</td>
            <td style="text-align:right">{$totalFormattedWithDollar}</td>
        </tr>
    </tfoot>
</table>
<div class="footer">{$generated}</div>
</body>
</html>
HTML;
    }

    /**
     * Genera PDF binario de la plantilla.
     */
    public function generatePdf(Template $plantilla): string
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($this->buildHtml($plantilla));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = sys_get_temp_dir() . '/presupuesto_' . $plantilla->getId() . '_' . time() . '.pdf';
        file_put_contents($filename, $dompdf->output());

        return $filename;
    }

    /**
     * Genera Excel (.xlsx) del presupuesto de la plantilla.
     */
    public function generateExcel(Template $plantilla): string
    {
        $t = fn(string $key) => $this->translator->trans($key);
        $proyecto = $plantilla->getProject();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($t('report.excel_sheet_title'));

        // Anchos de columna
        foreach (['A' => 5, 'B' => 12, 'C' => 42, 'D' => 10, 'E' => 12, 'F' => 16, 'G' => 16] as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // Título
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', $t('report.excel_budget_prefix') . strtoupper($proyecto->getName()));
        file_put_contents(__DIR__ . '/../../var/log/budget_debug.log', "style:A1\n", FILE_APPEND);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a56db');
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB('FFFFFFFF');

        // Subtítulo
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', $plantilla->getName());
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Metadatos
        $meta = [
            [$t('report.excel_meta_project'), $proyecto->getName(), $t('report.excel_meta_code'), $proyecto->getCode()],
            [$t('report.excel_meta_client'), $proyecto->getClient() ?? '—', $t('report.excel_meta_location'), $proyecto->getLocation() ?? '—'],
            [$t('report.excel_meta_date'), $plantilla->getCreatedAt()->format('d/m/Y'), $t('report.excel_meta_status'), $proyecto->getStatus()],
        ];
        $row = 3;
        foreach ($meta as $m) {
            $this->safeSetCellValue($sheet, 'A' . $row, $m[0]);
            $sheet->mergeCells('B' . $row . ':C' . $row);
            $this->safeSetCellValue($sheet, 'B' . $row, $m[1]);
            $this->safeSetCellValue($sheet, 'D' . $row, $m[2]);
            $sheet->mergeCells('E' . $row . ':G' . $row);
            $this->safeSetCellValue($sheet, 'E' . $row, $m[3]);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true);
            $sheet->getStyle('D' . $row)->getFont()->setBold(true);
            $row++;
        }
        $row++;

        // Cabeceras tabla
        $headers = [$t('report.table.col_number'), $t('report.table.col_code'), $t('report.table.col_rubro_description'), $t('report.table.col_unit'), $t('report.table.col_quantity'), $t('report.table.col_unit_price'), $t('report.table.col_total')];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach ($headers as $i => $h) {
            $this->safeSetCellValue($sheet, $cols[$i] . $row, $h);
        }
        $headerStyle = $sheet->getStyle('A' . $row . ':G' . $row);
        $headerStyle->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a56db');
        $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $row++;

        // Datos
        $dataStart = $row;
        $i = 1;
        foreach ($plantilla->getItems() as $pr) {
            $apu = $pr->getApuItem();
            $this->safeSetCellValue($sheet, 'A' . $row, $i++);
            $this->safeSetCellValue($sheet, 'B' . $row, $pr->getItem()->getCode());
            $this->safeSetCellValue($sheet, 'C' . $row, $pr->getItem()->getName());
            $this->safeSetCellValue($sheet, 'D' . $row, $pr->getItem()->getUnit());
            // Quantity removed from TemplateItem structure — leave cell empty
            $this->safeSetCellValue($sheet, 'E' . $row, '');
            $this->safeSetCellValue($sheet, 'F' . $row, $apu ? $pr->getUnitPrice() : 0);
            $this->safeSetCellValue($sheet, 'G' . $row, $apu ? $pr->getTotalCost() : 0);

            $sheet->getStyle('E' . $row . ':G' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $row++;
        }

        // Total
        $this->safeSetCellValue($sheet, 'F' . $row, $t('report.total_label'));
        $this->safeSetCellValue($sheet, 'G' . $row, $plantilla->getTotalBudget());
        $totalStyle = $sheet->getStyle('A' . $row . ':G' . $row);
        $totalStyle->getFont()->setBold(true)->setSize(12);
        $totalStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFe0e7ff');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('"$"#,##0.00');

        // Bordes
        $sheet->getStyle('A' . ($dataStart - 1) . ':G' . $row)
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $filename = sys_get_temp_dir() . '/presupuesto_' . $plantilla->getId() . '_' . time() . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $filename;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // REPORTE COMPLETO DEL PROYECTO (todas las plantillas)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Genera HTML del reporte global del proyecto (agrupa por plantilla).
     */
    public function buildProjectHtml(Projects $proyecto): string
    {
        $plantillas = $proyecto->getTemplates();
        $totalProyecto = 0.0;

        $sections = '';
        foreach ($plantillas as $plantilla) {
            $rubros = $plantilla->getItems();
            $totalPlantilla = $plantilla->getTotalBudget();
            $totalProyecto += $totalPlantilla;

            $rows = '';
            $i = 1;
            foreach ($rubros as $pr) {
                $apu = $pr->getApuItem();
                $precioUnit = $apu ? number_format($pr->getUnitPrice(), 2) : '—';
                $subtotal   = $apu ? number_format($pr->getTotalCost(), 2) : '—';
                $rows .= sprintf(
                    '<tr><td>%d</td><td>%s</td><td>%s</td><td style="text-align:center">%s</td>
                     <td style="text-align:right">%s</td><td style="text-align:right">$%s</td>
                     <td style="text-align:right">$%s</td></tr>',
                    $i++,
                    htmlspecialchars($pr->getItem()->getCode()),
                    htmlspecialchars($pr->getItem()->getName()),
                    htmlspecialchars($pr->getItem()->getUnit()),
                    '—',
                    $precioUnit,
                    $subtotal
                );
            }

            $sections .= sprintf(
                '<h3 style="margin:20px 0 6px;font-size:13px;color:#1a56db;border-bottom:2px solid #1a56db;padding-bottom:4px;">%s</h3>
                 <table class="budget">
                   <thead><tr><th>%s</th><th>%s</th><th>%s</th>
                   <th style="text-align:center">%s</th>
                   <th style="text-align:right">%s</th>
                   <th style="text-align:right">%s</th>
                   <th style="text-align:right">%s</th></tr></thead>
                   <tbody>%s</tbody>
                   <tfoot><tr class="total-row">
                     <td colspan="6" style="text-align:right">%s %s</td>
                     <td style="text-align:right">$%s</td>
                   </tr></tfoot>
                 </table>',
                htmlspecialchars($plantilla->getName()),
                $this->translator->trans('report.table.col_number'),
                $this->translator->trans('report.table.col_code'),
                $this->translator->trans('report.table.col_description'),
                $this->translator->trans('report.table.col_unit'),
                $this->translator->trans('report.table.col_quantity'),
                $this->translator->trans('report.table.col_unit_price'),
                $this->translator->trans('report.table.col_total'),
                $rows,
                $this->translator->trans('report.subtotal_template'),
                htmlspecialchars($plantilla->getName()),
                number_format($totalPlantilla, 2)
            );
        }

        $locale = $this->translator->getLocale();
        $title = $this->translator->trans('report.project_full_title');
        $projectLabel = $this->translator->trans('report.project_label');
        $codeLabel = $this->translator->trans('report.code_label');
        $clientLabel = $this->translator->trans('report.client_label');
        $locationLabel = $this->translator->trans('report.location_label');
        $statusLabel = $this->translator->trans('report.status_label');
        $templatesLabel = $this->translator->trans('report.templates_label');
        $totalGeneral = $this->translator->trans('report.total_general');
        $generated = $this->translator->trans('report.generated_by');

        $metaHtml = sprintf(
            '<table class="meta">
                             <tr><td><b>%s</b></td><td>%s</td><td><b>%s</b></td><td>%s</td></tr>
                             <tr><td><b>%s</b></td><td>%s</td><td><b>%s</b></td><td>%s</td></tr>
                             <tr><td><b>%s</b></td><td>%s</td><td><b>%s</b></td><td>%d</td></tr>
                         </table>',
            $projectLabel,
            htmlspecialchars($proyecto->getName()),
            $codeLabel,
            htmlspecialchars($proyecto->getCode()),
            $clientLabel,
            htmlspecialchars($proyecto->getClient() ?? '—'),
            $locationLabel,
            htmlspecialchars($proyecto->getLocation() ?? '—'),
            $statusLabel,
            htmlspecialchars($proyecto->getStatus()),
            $templatesLabel,
            $plantillas->count()
        );

        $totalHtml = sprintf(
            '<table class="budget" style="margin-top:20px">
                             <tfoot><tr class="total-row">
                                 <td colspan="6" style="text-align:right;font-size:14px">%s</td>
                                 <td style="text-align:right;font-size:14px">$%s</td>
                             </tr></tfoot>
                         </table>',
            $totalGeneral,
            number_format($totalProyecto, 2)
        );

        return <<<HTML
<!DOCTYPE html>
<html lang="{$locale}">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; color: #333; }
    h1 { font-size: 16px; text-align: center; margin: 0 0 4px; }
    h2 { font-size: 13px; text-align: center; color: #555; margin: 0 0 12px; }
    .meta { font-size: 10px; color: #666; margin-bottom: 10px; }
    .meta td { padding: 2px 8px 2px 0; }
    table.budget { width: 100%; border-collapse: collapse; }
    table.budget th { background: #1a56db; color: #fff; padding: 6px 4px; text-align: left; }
    table.budget td { padding: 5px 4px; border-bottom: 1px solid #e5e7eb; }
    table.budget tr:nth-child(even) td { background: #f8faff; }
    .total-row td { font-weight: bold; background: #e0e7ff; padding: 7px 4px; border-top: 2px solid #1a56db; }
    .footer { margin-top: 20px; font-size: 9px; color: #aaa; text-align: center; }
</style>
</head>
<body>
<h1>{$title}</h1>
<h2>{$proyecto->getName()}</h2>
{$metaHtml}
{$sections}
{$totalHtml}
<div class="footer">{$generated}</div>
</body>
</html>
HTML;
    }

    /**
     * Genera PDF del reporte completo del proyecto.
     */
    public function generateProjectPdf(Projects $proyecto): string
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($this->buildProjectHtml($proyecto));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = sys_get_temp_dir() . '/proyecto_' . $proyecto->getId() . '_' . time() . '.pdf';
        file_put_contents($filename, $dompdf->output());

        return $filename;
    }

    /**
     * Genera Excel del reporte completo del proyecto.
     */
    public function generateProjectExcel(Projects $proyecto): string
    {
        $t = fn(string $key) => $this->translator->trans($key);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($t('report.excel_sheet_title'));

        foreach (['A' => 5, 'B' => 12, 'C' => 42, 'D' => 10, 'E' => 12, 'F' => 16, 'G' => 16] as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // Título
        $sheet->mergeCells('A1:G1');
        $this->safeSetCellValue($sheet, 'A1', $t('report.excel_project_prefix') . strtoupper($proyecto->getName()));
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a56db');
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB('FFFFFFFF');

        $meta = [
            [$t('report.excel_meta_project'), $proyecto->getName(), $t('report.excel_meta_code'), $proyecto->getCode()],
            [$t('report.excel_meta_client'), $proyecto->getClient() ?? '—', $t('report.excel_meta_status'), $proyecto->getStatus()],
        ];
        $row = 2;
        foreach ($meta as $m) {
            $this->safeSetCellValue($sheet, 'A' . $row, $m[0]);
            $sheet->mergeCells('B' . $row . ':C' . $row);
            $this->safeSetCellValue($sheet, 'B' . $row, $m[1]);
            $this->safeSetCellValue($sheet, 'D' . $row, $m[2]);
            $sheet->mergeCells('E' . $row . ':G' . $row);
            $this->safeSetCellValue($sheet, 'E' . $row, $m[3]);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true);
            $sheet->getStyle('D' . $row)->getFont()->setBold(true);
            $row++;
        }

        $totalProyecto = 0.0;

        foreach ($proyecto->getTemplates() as $plantilla) {
            $row++;
            // Sección de plantilla
            $sheet->mergeCells('A' . $row . ':G' . $row);
            $this->safeSetCellValue($sheet, 'A' . $row, '▶ ' . $plantilla->getName());
            file_put_contents(__DIR__ . '/../../var/log/budget_debug.log', "style:A" . $row . "\n", FILE_APPEND);
            $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(11);
            $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFdbeafe');
            $row++;

            // Cabecera
            $headers = [$t('report.table.col_number'), $t('report.table.col_code'), $t('report.table.col_rubro_description'), $t('report.table.col_unit'), $t('report.table.col_quantity'), $t('report.table.col_unit_price'), $t('report.table.col_total')];
            $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
            foreach ($headers as $i => $h) {
                $this->safeSetCellValue($sheet, $cols[$i] . $row, $h);
            }
            file_put_contents(__DIR__ . '/../../var/log/budget_debug.log', "style:A" . $row . ":G" . $row . "\n", FILE_APPEND);
            $sheet->getStyle('A' . $row . ':G' . $row)->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle('A' . $row . ':G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a56db');
            $sheet->getStyle('A' . $row . ':G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $row++;

            $dataStart = $row;
            $n = 1;
            foreach ($plantilla->getItems() as $pr) {
                $apu = $pr->getApuItem();
                $this->safeSetCellValue($sheet, 'A' . $row, $n++);
                $this->safeSetCellValue($sheet, 'B' . $row, $pr->getItem()->getCode());
                $this->safeSetCellValue($sheet, 'C' . $row, $pr->getItem()->getName());
                $this->safeSetCellValue($sheet, 'D' . $row, $pr->getItem()->getUnit());
                // Quantity removed from TemplateItem structure — leave cell empty
                $this->safeSetCellValue($sheet, 'E' . $row, '');
                $this->safeSetCellValue($sheet, 'F' . $row, $apu ? $pr->getUnitPrice() : 0);
                $this->safeSetCellValue($sheet, 'G' . $row, $apu ? $pr->getTotalCost() : 0);
                $sheet->getStyle('E' . $row . ':G' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $row++;
            }

            $subtotal = $plantilla->getTotalBudget();
            $totalProyecto += $subtotal;

            $this->safeSetCellValue($sheet, 'F' . $row, $t('report.subtotal_template') . ' ' . $plantilla->getName());
            $this->safeSetCellValue($sheet, 'G' . $row, $subtotal);
            $sheet->getStyle('A' . $row . ':G' . $row)->getFont()->setBold(true);
            $sheet->getStyle('A' . $row . ':G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFe0e7ff');
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('"$"#,##0.00');

            if ($dataStart <= $row) {
                $sheet->getStyle('A' . ($dataStart - 1) . ':G' . $row)
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
        }

        // Total general
        $row += 2;
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $this->safeSetCellValue($sheet, 'A' . $row, $t('report.total_general'));
        $this->safeSetCellValue($sheet, 'G' . $row, $totalProyecto);
        $sheet->getStyle('A' . $row . ':G' . $row)->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A' . $row . ':G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a56db');
        $sheet->getStyle('A' . $row . ':G' . $row)->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('"$"#,##0.00');

        $filename = sys_get_temp_dir() . '/proyecto_' . $proyecto->getId() . '_' . time() . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $filename;
    }
}
