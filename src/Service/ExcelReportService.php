<?php

namespace App\Service;

use App\Entity\APUItem;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExcelReportService
{
    public function __construct(private TranslatorInterface $translator) {}

    public function generateAPUReport(APUItem $apuItem): string
    {
        $t = fn(string $key) => $this->translator->trans($key);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Configurar anchos de columnas
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

        // Título principal
        $sheet->setCellValue('A1', $t('apu.excel_title'));
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Datos principales
        $row = 3;
        $sheet->setCellValue('A' . $row, $t('apu.excel_description'));
        $sheet->setCellValue('B' . $row, $apuItem->getDescription());
        $sheet->mergeCells('B' . $row . ':E' . $row);
        $row++;

        $sheet->setCellValue('A' . $row, $t('apu.excel_unit'));
        $sheet->setCellValue('B' . $row, $apuItem->getUnit());
        $row++;

        $sheet->setCellValue('A' . $row, $t('apu.excel_khu'));
        $sheet->setCellValue('B' . $row, $apuItem->getKhu());
        $sheet->setCellValue('C' . $row, $t('apu.excel_rend'));
        $sheet->setCellValue('D' . $row, $apuItem->getProductivityUh());
        $row += 2;

        // Sección EQUIPO
        $sheet->setCellValue('A' . $row, $t('apu.equipment'));
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
        $row++;

        $sheet->setCellValue('A' . $row, $t('apu.col_description'));
        $sheet->setCellValue('B' . $row, $t('apu.col_number'));
        $sheet->setCellValue('C' . $row, $t('apu.col_rate'));
        $sheet->setCellValue('D' . $row, $t('apu.col_cost_hour'));
        $sheet->setCellValue('E' . $row, $t('apu.excel_col_total'));
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        $row++;

        $equipmentTotal = 0;
        foreach ($apuItem->getEquipment() as $equipment) {
            $sheet->setCellValue('A' . $row, $equipment->getDescription());
            $sheet->setCellValue('B' . $row, $equipment->getNumber());
            $sheet->setCellValue('C' . $row, $equipment->getTarifa());
            $sheet->setCellValue('D' . $row, $equipment->getCHora());
            $sheet->setCellValue('E' . $row, $equipment->getTotalCost());
            $equipmentTotal += $equipment->getTotalCost();
            $row++;
        }

        $sheet->setCellValue('D' . $row, $t('apu.excel_subtotal_equipment'));
        $sheet->setCellValue('E' . $row, $equipmentTotal);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
        $row += 2;

        // Sección MANO DE OBRA
        $sheet->setCellValue('A' . $row, $t('apu.labor'));
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
        $row++;

        $sheet->setCellValue('A' . $row, $t('apu.col_description'));
        $sheet->setCellValue('B' . $row, $t('apu.col_number'));
        $sheet->setCellValue('C' . $row, $t('apu.col_jh'));
        $sheet->setCellValue('D' . $row, $t('apu.col_cost_hour'));
        $sheet->setCellValue('E' . $row, $t('apu.excel_col_total'));
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        $row++;

        $laborTotal = 0;
        foreach ($apuItem->getLabor() as $labor) {
            $sheet->setCellValue('A' . $row, $labor->getLabor()?->getDescription() ?? '');
            $sheet->setCellValue('B' . $row, $labor->getNumber());
            $sheet->setCellValue('C' . $row, $labor->getJorHora());
            $sheet->setCellValue('D' . $row, $labor->getCHora());
            $sheet->setCellValue('E' . $row, $labor->getTotalCost());
            $laborTotal += $labor->getTotalCost();
            $row++;
        }

        $sheet->setCellValue('D' . $row, $t('apu.excel_subtotal_labor'));
        $sheet->setCellValue('E' . $row, $laborTotal);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
        $row += 2;

        // Sección MATERIALES
        $sheet->setCellValue('A' . $row, $t('apu.materials'));
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
        $row++;

        $sheet->setCellValue('A' . $row, $t('apu.col_description'));
        $sheet->setCellValue('B' . $row, $t('apu.col_unit'));
        $sheet->setCellValue('C' . $row, $t('apu.col_quantity'));
        $sheet->setCellValue('D' . $row, $t('apu.excel_col_p_unitario'));
        $sheet->setCellValue('E' . $row, $t('apu.excel_col_total'));
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        $row++;

        $materialTotal = 0;
        foreach ($apuItem->getMaterials() as $material) {
            $sheet->setCellValue('A' . $row, $material->getDescription());
            // APUMaterial uses getUnidad() (alias) to expose unit from related Material
            $sheet->setCellValue('B' . $row, $material->getUnidad());
            $sheet->setCellValue('C' . $row, $material->getQuantity());
            $sheet->setCellValue('D' . $row, $material->getUnitPrice());
            $sheet->setCellValue('E' . $row, $material->getTotalCost());
            $materialTotal += $material->getTotalCost();
            $row++;
        }

        $sheet->setCellValue('D' . $row, $t('apu.excel_subtotal_materials'));
        $sheet->setCellValue('E' . $row, $materialTotal);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
        $row += 2;

        // Sección TRANSPORTE
        $sheet->setCellValue('A' . $row, $t('apu.transport'));
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
        $row++;

        $sheet->setCellValue('A' . $row, $t('apu.col_description'));
        $sheet->setCellValue('B' . $row, $t('apu.col_unit'));
        $sheet->setCellValue('C' . $row, $t('apu.col_quantity'));
        $sheet->setCellValue('D' . $row, $t('apu.col_dmt'));
        $sheet->setCellValue('E' . $row, $t('apu.excel_col_total'));
        $sheet->getStyle('A' . $row . ':E' . $row)->getFont()->setBold(true);
        $row++;

        $transportTotal = 0;
        foreach ($apuItem->getTransport() as $transport) {
            $sheet->setCellValue('A' . $row, $transport->getDescription());
            $sheet->setCellValue('B' . $row, $transport->getUnit());
            $sheet->setCellValue('C' . $row, $transport->getQuantity());
            $sheet->setCellValue('D' . $row, $transport->getDmt());
            $sheet->setCellValue('E' . $row, $transport->getTotalCost());
            $transportTotal += $transport->getTotalCost();
            $row++;
        }

        $sheet->setCellValue('D' . $row, $t('apu.excel_subtotal_transport'));
        $sheet->setCellValue('E' . $row, $transportTotal);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
        $row += 2;

        // TOTAL GENERAL
        $sheet->setCellValue('D' . $row, $t('apu.excel_total_cost'));
        $sheet->setCellValue('E' . $row, $apuItem->getTotalCost());
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD966');
        $row++;

        // CALCULATION PRICE
        $sheet->setCellValue('D' . $row, $t('apu.precio_calculo'));
        $sheet->setCellValue('E' . $row, $apuItem->getCalculationPrice());
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFC000');
        $row++;

        // OFFERED PRICE
        $offeredPrice = $apuItem->getOfferedPrice() !== null
            ? (float) $apuItem->getOfferedPrice()
            : $apuItem->getCalculationPrice();
        $sheet->setCellValue('D' . $row, $t('apu.precio_ofertado') . ' (USD)');
        $sheet->setCellValue('E' . $row, $offeredPrice);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('00B050');
        $sheet->getStyle('E' . $row)->getFont()->getColor()->setARGB('FFFFFFFF');

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
