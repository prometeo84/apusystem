<?php

namespace App\Service;

use App\Entity\Plantilla;
use App\Entity\Projects;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BudgetReportService
{
    /**
     * Genera HTML del reporte de presupuesto de una plantilla.
     * Usado tanto para PDF como para visualización web.
     */
    public function buildHtml(Plantilla $plantilla): string
    {
        $proyecto = $plantilla->getProyecto();
        $rubros   = $plantilla->getPlantillaRubros();
        $total    = $plantilla->getTotalPresupuesto();

        $rows = '';
        $i    = 1;
        foreach ($rubros as $pr) {
            $apu = $pr->getApuItem();
            $precioUnit = $apu ? number_format($pr->getPrecioUnitario(), 2) : '—';
            $subtotal   = $apu ? number_format($pr->getTotalCosto(), 2) : '—';
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
                htmlspecialchars($pr->getRubro()->getCodigo()),
                htmlspecialchars($pr->getRubro()->getNombre()),
                htmlspecialchars($pr->getRubro()->getUnidad()),
                number_format((float)$pr->getCantidad(), 2),
                $precioUnit,
                $subtotal
            );
        }

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
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
<h1>PRESUPUESTO DE OBRA</h1>
<h2>{$plantilla->getNombre()}</h2>
<table class="meta">
  <tr><td><b>Proyecto:</b></td><td>{$proyecto->getNombre()}</td><td><b>Código:</b></td><td>{$proyecto->getCodigo()}</td></tr>
  <tr><td><b>Cliente:</b></td><td>{$proyecto->getCliente()}</td><td><b>Ubicación:</b></td><td>{$proyecto->getUbicacion()}</td></tr>
  <tr><td><b>Fecha:</b></td><td>{$plantilla->getCreatedAt()->format('d/m/Y')}</td><td><b>Estado:</b></td><td>{$proyecto->getEstado()}</td></tr>
</table>

<table class="budget">
  <thead>
    <tr>
      <th>#</th><th>Código</th><th>Descripción del Rubro</th>
      <th style="text-align:center">Unidad</th>
      <th style="text-align:right">Cantidad</th>
      <th style="text-align:right">Precio Unit. USD</th>
      <th style="text-align:right">Total USD</th>
    </tr>
  </thead>
  <tbody>{$rows}</tbody>
  <tfoot>
    <tr class="total-row">
      <td colspan="6" style="text-align:right">TOTAL PRESUPUESTO</td>
      <td style="text-align:right">$' . number_format($total, 2) . '</td>
    </tr>
  </tfoot>
</table>
<div class="footer">Generado automáticamente — APU System</div>
</body>
</html>
HTML;
    }

    /**
     * Genera PDF binario de la plantilla.
     */
    public function generatePdf(Plantilla $plantilla): string
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
    public function generateExcel(Plantilla $plantilla): string
    {
        $proyecto = $plantilla->getProyecto();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Presupuesto');

        // Anchos de columna
        foreach (['A' => 5, 'B' => 12, 'C' => 42, 'D' => 10, 'E' => 12, 'F' => 16, 'G' => 16] as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // Título
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'PRESUPUESTO DE OBRA - ' . strtoupper($proyecto->getNombre()));
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a56db');
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB('FFFFFFFF');

        // Subtítulo
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', $plantilla->getNombre());
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Metadatos
        $meta = [
            ['Proyecto:', $proyecto->getNombre(), 'Código:', $proyecto->getCodigo()],
            ['Cliente:',  $proyecto->getCliente() ?? '—', 'Ubicación:', $proyecto->getUbicacion() ?? '—'],
            ['Fecha:',    $plantilla->getCreatedAt()->format('d/m/Y'), 'Estado:', $proyecto->getEstado()],
        ];
        $row = 3;
        foreach ($meta as $m) {
            $sheet->setCellValue('A' . $row, $m[0]);
            $sheet->mergeCells('B' . $row . ':C' . $row);
            $sheet->setCellValue('B' . $row, $m[1]);
            $sheet->setCellValue('D' . $row, $m[2]);
            $sheet->mergeCells('E' . $row . ':G' . $row);
            $sheet->setCellValue('E' . $row, $m[3]);
            $sheet->getStyle('A' . $row . ',D' . $row)->getFont()->setBold(true);
            $row++;
        }
        $row++;

        // Cabeceras tabla
        $headers = ['#', 'Código', 'Descripción del Rubro', 'Unidad', 'Cantidad', 'Precio Unit. USD', 'Total USD'];
        $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        foreach ($headers as $i => $h) {
            $sheet->setCellValue($cols[$i] . $row, $h);
        }
        $headerStyle = $sheet->getStyle('A' . $row . ':G' . $row);
        $headerStyle->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $headerStyle->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a56db');
        $headerStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $row++;

        // Datos
        $dataStart = $row;
        $i = 1;
        foreach ($plantilla->getPlantillaRubros() as $pr) {
            $apu = $pr->getApuItem();
            $sheet->setCellValue('A' . $row, $i++);
            $sheet->setCellValue('B' . $row, $pr->getRubro()->getCodigo());
            $sheet->setCellValue('C' . $row, $pr->getRubro()->getNombre());
            $sheet->setCellValue('D' . $row, $pr->getRubro()->getUnidad());
            $sheet->setCellValue('E' . $row, (float)$pr->getCantidad());
            $sheet->setCellValue('F' . $row, $apu ? $pr->getPrecioUnitario() : 0);
            $sheet->setCellValue('G' . $row, $apu ? $pr->getTotalCosto() : 0);

            $sheet->getStyle('E' . $row . ':G' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $row++;
        }

        // Total
        $sheet->setCellValue('F' . $row, 'TOTAL PRESUPUESTO');
        $sheet->setCellValue('G' . $row, $plantilla->getTotalPresupuesto());
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
        $plantillas = $proyecto->getPlantillas();
        $totalProyecto = 0.0;

        $sections = '';
        foreach ($plantillas as $plantilla) {
            $rubros = $plantilla->getPlantillaRubros();
            $totalPlantilla = $plantilla->getTotalPresupuesto();
            $totalProyecto += $totalPlantilla;

            $rows = '';
            $i = 1;
            foreach ($rubros as $pr) {
                $apu = $pr->getApuItem();
                $precioUnit = $apu ? number_format($pr->getPrecioUnitario(), 2) : '—';
                $subtotal   = $apu ? number_format($pr->getTotalCosto(), 2) : '—';
                $rows .= sprintf(
                    '<tr><td>%d</td><td>%s</td><td>%s</td><td style="text-align:center">%s</td>
                     <td style="text-align:right">%s</td><td style="text-align:right">$%s</td>
                     <td style="text-align:right">$%s</td></tr>',
                    $i++,
                    htmlspecialchars($pr->getRubro()->getCodigo()),
                    htmlspecialchars($pr->getRubro()->getNombre()),
                    htmlspecialchars($pr->getRubro()->getUnidad()),
                    number_format((float)$pr->getCantidad(), 2),
                    $precioUnit,
                    $subtotal
                );
            }

            $sections .= sprintf(
                '<h3 style="margin:20px 0 6px;font-size:13px;color:#1a56db;border-bottom:2px solid #1a56db;padding-bottom:4px;">%s</h3>
                 <table class="budget">
                   <thead><tr><th>#</th><th>Código</th><th>Descripción</th>
                   <th style="text-align:center">Unidad</th>
                   <th style="text-align:right">Cantidad</th>
                   <th style="text-align:right">Precio Unit.</th>
                   <th style="text-align:right">Total</th></tr></thead>
                   <tbody>%s</tbody>
                   <tfoot><tr class="total-row">
                     <td colspan="6" style="text-align:right">Subtotal %s</td>
                     <td style="text-align:right">$%s</td>
                   </tr></tfoot>
                 </table>',
                htmlspecialchars($plantilla->getNombre()),
                $rows,
                htmlspecialchars($plantilla->getNombre()),
                number_format($totalPlantilla, 2)
            );
        }

        $metaHtml = sprintf(
            '<table class="meta">
               <tr><td><b>Proyecto:</b></td><td>%s</td><td><b>Código:</b></td><td>%s</td></tr>
               <tr><td><b>Cliente:</b></td><td>%s</td><td><b>Ubicación:</b></td><td>%s</td></tr>
               <tr><td><b>Estado:</b></td><td>%s</td><td><b>Plantillas:</b></td><td>%d</td></tr>
             </table>',
            htmlspecialchars($proyecto->getNombre()),
            htmlspecialchars($proyecto->getCodigo()),
            htmlspecialchars($proyecto->getCliente() ?? '—'),
            htmlspecialchars($proyecto->getUbicacion() ?? '—'),
            htmlspecialchars($proyecto->getEstado()),
            $plantillas->count()
        );

        $totalHtml = sprintf(
            '<table class="budget" style="margin-top:20px">
               <tfoot><tr class="total-row">
                 <td colspan="6" style="text-align:right;font-size:14px">TOTAL GENERAL DEL PROYECTO</td>
                 <td style="text-align:right;font-size:14px">$%s</td>
               </tr></tfoot>
             </table>',
            number_format($totalProyecto, 2)
        );

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
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
<h1>PRESUPUESTO GENERAL DEL PROYECTO</h1>
<h2>{$proyecto->getNombre()}</h2>
{$metaHtml}
{$sections}
{$totalHtml}
<div class="footer">Generado automáticamente — APU System</div>
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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Presupuesto');

        foreach (['A' => 5, 'B' => 12, 'C' => 42, 'D' => 10, 'E' => 12, 'F' => 16, 'G' => 16] as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // Título
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'PRESUPUESTO GENERAL — ' . strtoupper($proyecto->getNombre()));
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a56db');
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB('FFFFFFFF');

        $meta = [
            ['Proyecto:', $proyecto->getNombre(), 'Código:', $proyecto->getCodigo()],
            ['Cliente:', $proyecto->getCliente() ?? '—', 'Estado:', $proyecto->getEstado()],
        ];
        $row = 2;
        foreach ($meta as $m) {
            $sheet->setCellValue('A' . $row, $m[0]);
            $sheet->mergeCells('B' . $row . ':C' . $row);
            $sheet->setCellValue('B' . $row, $m[1]);
            $sheet->setCellValue('D' . $row, $m[2]);
            $sheet->mergeCells('E' . $row . ':G' . $row);
            $sheet->setCellValue('E' . $row, $m[3]);
            $sheet->getStyle('A' . $row . ',D' . $row)->getFont()->setBold(true);
            $row++;
        }

        $totalProyecto = 0.0;

        foreach ($proyecto->getPlantillas() as $plantilla) {
            $row++;
            // Sección de plantilla
            $sheet->mergeCells('A' . $row . ':G' . $row);
            $sheet->setCellValue('A' . $row, '▶ ' . $plantilla->getNombre());
            $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(11);
            $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFdbeafe');
            $row++;

            // Cabecera
            $headers = ['#', 'Código', 'Descripción del Rubro', 'Unidad', 'Cantidad', 'Precio Unit. USD', 'Total USD'];
            $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
            foreach ($headers as $i => $h) {
                $sheet->setCellValue($cols[$i] . $row, $h);
            }
            $sheet->getStyle('A' . $row . ':G' . $row)->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle('A' . $row . ':G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a56db');
            $sheet->getStyle('A' . $row . ':G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $row++;

            $dataStart = $row;
            $n = 1;
            foreach ($plantilla->getPlantillaRubros() as $pr) {
                $apu = $pr->getApuItem();
                $sheet->setCellValue('A' . $row, $n++);
                $sheet->setCellValue('B' . $row, $pr->getRubro()->getCodigo());
                $sheet->setCellValue('C' . $row, $pr->getRubro()->getNombre());
                $sheet->setCellValue('D' . $row, $pr->getRubro()->getUnidad());
                $sheet->setCellValue('E' . $row, (float)$pr->getCantidad());
                $sheet->setCellValue('F' . $row, $apu ? $pr->getPrecioUnitario() : 0);
                $sheet->setCellValue('G' . $row, $apu ? $pr->getTotalCosto() : 0);
                $sheet->getStyle('E' . $row . ':G' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $row++;
            }

            $subtotal = $plantilla->getTotalPresupuesto();
            $totalProyecto += $subtotal;

            $sheet->setCellValue('F' . $row, 'Subtotal ' . $plantilla->getNombre());
            $sheet->setCellValue('G' . $row, $subtotal);
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
        $sheet->setCellValue('A' . $row, 'TOTAL GENERAL DEL PROYECTO');
        $sheet->setCellValue('G' . $row, $totalProyecto);
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
