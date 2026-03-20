<?php

namespace App\Service;

use App\Entity\APUItem;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExcelReportService
{
    public function generateAPUReport(APUItem $apuItem): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Configurar anchos de columnas
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

        // Título principal
        $sheet->setCellValue('A1', 'ANÁLISIS DE PRECIOS UNITARIOS');
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Datos principales
        $row = 3;
        $sheet->setCellValue('A' . $row, 'Descripción:');
        $sheet->setCellValue('B' . $row, $apuItem->getDescription());
        $sheet->mergeCells('B' . $row . ':E' . $row);
        $row++;

        $sheet->setCellValue('A' . $row, 'Unidad:');
        $sheet->setCellValue('B' . $row, $apuItem->getUnit());
        $row++;

        $sheet->setCellValue('A' . $row, 'K(H/U):');
        $sheet->setCellValue('B' . $row, $apuItem->getKhu());
        $sheet->setCellValue('C' . $row, 'Rend. u/h:');
        $sheet->setCellValue('D' . $row, $apuItem->getRendimientoUh());
        $row += 2;

        // Sección EQUIPO
        $sheet->setCellValue('A' . $row, 'EQUIPO');
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
        $row++;

        $sheet->setCellValue('A' . $row, 'Descripción');
        $sheet->setCellValue('B' . $row, 'Número');
        $sheet->setCellValue('C' . $row, 'Tarifa');
        $sheet->setCellValue('D' . $row, 'C/HORA');
        $sheet->setCellValue('E' . $row, 'Total');
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        $row++;

        $equipmentTotal = 0;
        foreach ($apuItem->getEquipment() as $equipment) {
            $sheet->setCellValue('A' . $row, $equipment->getDescripcion());
            $sheet->setCellValue('B' . $row, $equipment->getNumero());
            $sheet->setCellValue('C' . $row, $equipment->getTarifa());
            $sheet->setCellValue('D' . $row, $equipment->getCHora());
            $sheet->setCellValue('E' . $row, $equipment->getTotalCost());
            $equipmentTotal += $equipment->getTotalCost();
            $row++;
        }

        $sheet->setCellValue('D' . $row, 'Subtotal Equipo:');
        $sheet->setCellValue('E' . $row, $equipmentTotal);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
        $row += 2;

        // Sección MANO DE OBRA
        $sheet->setCellValue('A' . $row, 'MANO DE OBRA');
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
        $row++;

        $sheet->setCellValue('A' . $row, 'Descripción');
        $sheet->setCellValue('B' . $row, 'Número');
        $sheet->setCellValue('C' . $row, 'JOR./HORA');
        $sheet->setCellValue('D' . $row, 'C/HORA');
        $sheet->setCellValue('E' . $row, 'Total');
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        $row++;

        $laborTotal = 0;
        foreach ($apuItem->getLabor() as $labor) {
            $sheet->setCellValue('A' . $row, $labor->getDescripcion());
            $sheet->setCellValue('B' . $row, $labor->getNumero());
            $sheet->setCellValue('C' . $row, $labor->getJorHora());
            $sheet->setCellValue('D' . $row, $labor->getCHora());
            $sheet->setCellValue('E' . $row, $labor->getTotalCost());
            $laborTotal += $labor->getTotalCost();
            $row++;
        }

        $sheet->setCellValue('D' . $row, 'Subtotal Mano de Obra:');
        $sheet->setCellValue('E' . $row, $laborTotal);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
        $row += 2;

        // Sección MATERIALES
        $sheet->setCellValue('A' . $row, 'MATERIALES');
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        $row++;

        $sheet->setCellValue('A' . $row, 'Descripción');
        $sheet->setCellValue('B' . $row, 'Unidad');
        $sheet->setCellValue('C' . $row, 'Cantidad');
        $sheet->setCellValue('D' . $row, 'P. Unitario');
        $sheet->setCellValue('E' . $row, 'Total');
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        $row++;

        $materialTotal = 0;
        foreach ($apuItem->getMaterials() as $material) {
            $sheet->setCellValue('A' . $row, $material->getDescripcion());
            $sheet->setCellValue('B' . $row, $material->getUnidad());
            $sheet->setCellValue('C' . $row, $material->getCantidad());
            $sheet->setCellValue('D' . $row, $material->getPrecioUnitario());
            $sheet->setCellValue('E' . $row, $material->getTotalCost());
            $materialTotal += $material->getTotalCost();
            $row++;
        }

        $sheet->setCellValue('D' . $row, 'Subtotal Materiales:');
        $sheet->setCellValue('E' . $row, $materialTotal);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
        $row += 2;

        // Sección TRANSPORTE
        $sheet->setCellValue('A' . $row, 'TRANSPORTE');
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $row++;

        $sheet->setCellValue('A' . $row, 'Descripción');
        $sheet->setCellValue('B' . $row, 'Unidad');
        $sheet->setCellValue('C' . $row, 'Cantidad');
        $sheet->setCellValue('D' . $row, 'DMT (km)');
        $sheet->setCellValue('E' . $row, 'Total');
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        $row++;

        $transportTotal = 0;
        foreach ($apuItem->getTransport() as $transport) {
            $sheet->setCellValue('A' . $row, $transport->getDescripcion());
            $sheet->setCellValue('B' . $row, $transport->getUnidad());
            $sheet->setCellValue('C' . $row, $transport->getCantidad());
            $sheet->setCellValue('D' . $row, $transport->getDmt());
            $sheet->setCellValue('E' . $row, $transport->getTotalCost());
            $transportTotal += $transport->getTotalCost();
            $row++;
        }

        $sheet->setCellValue('D' . $row, 'Subtotal Transporte:');
        $sheet->setCellValue('E' . $row, $transportTotal);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
        $row += 2;

        // TOTAL GENERAL
        $sheet->setCellValue('D' . $row, 'COSTO TOTAL:');
        $sheet->setCellValue('E' . $row, $apuItem->getTotalCost());
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD966');

        // Formato de números
        $sheet->getStyle('C3:E' . $row)->getNumberFormat()->setFormatCode('#,##0.00');

        // Bordes
        $sheet->getStyle('A1:E' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Guardar archivo
        $filename = sys_get_temp_dir() . '/apu_' . $apuItem->getId() . '_' . time() . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $filename;
    }
}
