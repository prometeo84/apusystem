<?php

namespace App\Service;

use App\Entity\RevitFile;
use App\Entity\APUItem;
use App\Entity\APUMaterial;
use App\Entity\Tenant;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RevitFileProcessor
{
    private const MAX_FILE_SIZE = 100 * 1024 * 1024; // 100MB
    private const ALLOWED_EXTENSIONS = ['ifc', 'json', 'rvt'];
    private const UPLOAD_DIR = 'uploads/revit';

    public function __construct(
        private EntityManagerInterface $em,
        private string $projectDir
    ) {}

    /**
     * Procesa archivo subido de Revit
     */
    public function processUploadedFile(
        UploadedFile $file,
        Tenant $tenant,
        User $uploadedBy
    ): RevitFile {
        // Validar archivo
        $this->validateFile($file);

        // Crear directorio si no existe
        $uploadPath = $this->projectDir . '/public/' . self::UPLOAD_DIR;
        if (!\file_exists($uploadPath)) {
            \mkdir($uploadPath, 0755, true);
        }

        // Generar nombre único
        $extension = $file->getClientOriginalExtension();
        $storedFilename = \sprintf(
            '%s_%s.%s',
            \date('Ymd_His'),
            \bin2hex(\random_bytes(8)),
            $extension
        );

        // Mover archivo (si falla, intentar copia como fallback)
        try {
            $file->move($uploadPath, $storedFilename);
        } catch (\Throwable $e) {
            $source = $file->getPathname();
            $dest = $uploadPath . '/' . $storedFilename;
            if (!@copy($source, $dest)) {
                throw new \RuntimeException(sprintf('Could not move the file "%s" to "%s" (%s)', $source, $dest, $e->getMessage()));
            }
        }
        $filePath = self::UPLOAD_DIR . '/' . $storedFilename;

        // Calcular hash
        $fullPath = $this->projectDir . '/public/' . $filePath;
        $fileHash = \hash_file('sha256', $fullPath);

        // Crear entidad
        $revitFile = new RevitFile();
        $revitFile->setTenant($tenant);
        $revitFile->setUploadedBy($uploadedBy);
        $revitFile->setOriginalFilename($file->getClientOriginalName());
        $revitFile->setStoredFilename($storedFilename);
        $revitFile->setFilePath($filePath);
        $revitFile->setFileType($extension);
        $revitFile->setFileSize((int)$file->getSize());
        $revitFile->setFileHash($fileHash);
        $revitFile->setStatus('pending');

        $this->em->persist($revitFile);
        $this->em->flush();

        // Procesar archivo según tipo
        try {
            if ($extension === 'json') {
                $this->processJsonFile($revitFile, $fullPath);
            } elseif ($extension === 'ifc') {
                $this->processIfcFile($revitFile, $fullPath);
            }

            $revitFile->setStatus('completed');
            $revitFile->setProcessedAt(new \DateTime());
        } catch (\Exception $e) {
            $revitFile->setStatus('error');
            $revitFile->setErrorMessage($e->getMessage());
        }

        $this->em->flush();

        return $revitFile;
    }

    /**
     * Procesa archivo JSON de Revit
     */
    private function processJsonFile(RevitFile $revitFile, string $filePath): void
    {
        $content = \file_get_contents($filePath);
        $data = \json_decode($content, true);

        if (!\is_array($data)) {
            throw new \RuntimeException('Archivo JSON inválido');
        }

        // Extraer metadatos
        $metadata = [
            'project_name' => $data['project_name'] ?? 'Sin nombre',
            'version' => $data['version'] ?? '1.0',
            'elements_count' => \count($data['elements'] ?? []),
            'categories' => $data['categories'] ?? [],
        ];

        $revitFile->setMetadata($metadata);

        // Procesar elementos y crear APUs
        $result = $this->createApusFromElements($data['elements'] ?? [], $revitFile);
        $revitFile->setProcessingResult($result);
    }

    /**
     * Procesa archivo IFC
     */
    private function processIfcFile(RevitFile $revitFile, string $filePath): void
    {
        // Lectura básica de IFC (simplificado)
        $content = \file_get_contents($filePath);

        // Extraer información básica
        \preg_match('/FILE_NAME\s*\(\s*\'([^\']+)\'/', $content, $matches);
        $projectName = $matches[1] ?? 'Sin nombre';

        // Contar elementos
        $elementCount = \substr_count($content, 'IFCWALL') +
            \substr_count($content, 'IFCSLAB') +
            \substr_count($content, 'IFCCOLUMN') +
            \substr_count($content, 'IFCBEAM');

        $metadata = [
            'project_name' => $projectName,
            'format' => 'IFC',
            'elements_count' => $elementCount,
        ];

        $revitFile->setMetadata($metadata);
        $revitFile->setProcessingResult([
            'message' => 'Archivo IFC procesado. Use la API REST para análisis detallado.',
            'elements_detected' => $elementCount
        ]);
    }

    /**
     * Crea APUs a partir de elementos de Revit
     */
    private function createApusFromElements(array $elements, RevitFile $revitFile): array
    {
        $created = 0;
        $skipped = 0;

        foreach ($elements as $element) {
            try {
                // Validar que tenga datos mínimos
                if (!isset($element['category']) || !isset($element['quantity'])) {
                    $skipped++;
                    continue;
                }

                // Crear APU Item
                $apu = new APUItem();
                $apu->setTenant($revitFile->getTenant());
                $apu->setDescription($element['name'] ?? $element['category']);
                $apu->setUnit($element['unit'] ?? 'm²');
                $apu->setKhu($element['khu'] ?? 1.0);
                $apu->setProductivityUh($element['rendimiento'] ?? 1.0);

                // Si tiene materiales, crearlos
                if (isset($element['materials']) && \is_array($element['materials'])) {
                    foreach ($element['materials'] as $matData) {
                        $material = new APUMaterial();
                        $material->setDescription($matData['name'] ?? 'Material');
                        $material->setUnit($matData['unit'] ?? 'kg');
                        $material->setQuantity($matData['quantity'] ?? 1.0);
                        $material->setUnitPrice($matData['price'] ?? 0.0);
                        $material->setApuItem($apu);
                        $apu->addMaterial($material);
                    }
                }

                $apu->calculateCosts();
                $this->em->persist($apu);
                $created++;
            } catch (\Exception $e) {
                $skipped++;
                continue;
            }
        }

        $this->em->flush();

        return [
            'created' => $created,
            'skipped' => $skipped,
            'total' => \count($elements)
        ];
    }

    /**
     * Valida archivo subido
     */
    private function validateFile(UploadedFile $file): void
    {
        // Validar tamaño
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new \RuntimeException(\sprintf(
                'El archivo es demasiado grande. Máximo: %d MB',
                self::MAX_FILE_SIZE / 1024 / 1024
            ));
        }

        // Validar extensión
        $extension = \strtolower($file->getClientOriginalExtension() ?? '');
        if (!\in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new \RuntimeException(\sprintf(
                'Tipo de archivo no permitido. Permitidos: %s',
                \implode(', ', self::ALLOWED_EXTENSIONS)
            ));
        }

        // Validar error de subida
        if ($file->getError() !== \UPLOAD_ERR_OK) {
            throw new \RuntimeException('Error al subir el archivo');
        }
    }

    /**
     * Elimina archivo físico
     */
    public function deleteFile(RevitFile $revitFile): void
    {
        $fullPath = $this->projectDir . '/public/' . $revitFile->getFilePath();

        if (\file_exists($fullPath)) {
            \unlink($fullPath);
        }

        $this->em->remove($revitFile);
        $this->em->flush();
    }
}
