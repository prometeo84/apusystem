<?php

namespace App\Controller;

use App\Entity\RevitFile;
use App\Service\RevitFileProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/revit')]
#[IsGranted('ROLE_USER')]
class RevitUploadController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private RevitFileProcessor $fileProcessor
    ) {}

    #[Route('/upload', name: 'app_revit_upload', methods: ['GET', 'POST'])]
    public function upload(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            /** @var UploadedFile|null $file */
            $file = $request->files->get('revit_file');

            if (!$file) {
                $this->addFlash('error', 'Debe seleccionar un archivo');
                return $this->redirectToRoute('app_revit_upload');
            }

            try {
                /** @var \App\Entity\User $user */
                $user = $this->getUser();

                $revitFile = $this->fileProcessor->processUploadedFile(
                    $file,
                    $user->getTenant(),
                    $user
                );

                $this->addFlash('success', \sprintf(
                    'Archivo "%s" subido correctamente. Estado: %s',
                    $revitFile->getOriginalFilename(),
                    $revitFile->getStatus()
                ));

                return $this->redirectToRoute('app_revit_files');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al procesar el archivo: ' . $e->getMessage());
                return $this->redirectToRoute('app_revit_upload');
            }
        }

        return $this->render('revit/upload.html.twig');
    }

    #[Route('/files', name: 'app_revit_files', methods: ['GET'])]
    public function listFiles(): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $files = $this->em->getRepository(RevitFile::class)
            ->findBy(
                ['tenant' => $user->getTenant()],
                ['uploadedAt' => 'DESC']
            );

        return $this->render('revit/files.html.twig', [
            'files' => $files,
        ]);
    }

    #[Route('/file/{id}', name: 'app_revit_file_detail', methods: ['GET'])]
    public function fileDetail(int $id): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $file = $this->em->getRepository(RevitFile::class)->find($id);

        if (!$file || $file->getTenant() !== $user->getTenant()) {
            throw $this->createNotFoundException('Archivo no encontrado');
        }

        return $this->render('revit/file_detail.html.twig', [
            'file' => $file,
        ]);
    }

    #[Route('/file/{id}/delete', name: 'app_revit_file_delete', methods: ['POST'])]
    public function deleteFile(int $id): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $file = $this->em->getRepository(RevitFile::class)->find($id);

        if (!$file || $file->getTenant() !== $user->getTenant()) {
            throw $this->createNotFoundException('Archivo no encontrado');
        }

        try {
            $this->fileProcessor->deleteFile($file);
            $this->addFlash('success', 'Archivo eliminado correctamente');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Error al eliminar el archivo: ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_revit_files');
    }

    #[Route('/file/{id}/reprocess', name: 'app_revit_file_reprocess', methods: ['POST'])]
    public function reprocessFile(int $id): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $file = $this->em->getRepository(RevitFile::class)->find($id);

        if (!$file || $file->getTenant() !== $user->getTenant()) {
            throw $this->createNotFoundException('Archivo no encontrado');
        }

        try {
            // Re-procesar archivo
            $file->setStatus('pending');
            $file->setErrorMessage(null);
            $this->em->flush();

            // Aquí iría la lógica de re-procesamiento
            // Por ahora solo cambiamos el estado

            $this->addFlash('success', 'Archivo marcado para re-procesamiento');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Error: ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_revit_file_detail', ['id' => $id]);
    }
}
