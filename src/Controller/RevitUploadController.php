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
                $this->addFlash('error', 'flash.select_file');
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

                $this->addFlash('success', $this->container->get('translator')->trans('flash.file_uploaded_status', [
                    '%filename%' => $revitFile->getOriginalFilename(),
                    '%status%' => $revitFile->getStatus()
                ]));

                return $this->redirectToRoute('app_revit_files');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->container->get('translator')->trans('flash.error_processing_file', ['%error%' => $e->getMessage()]));
                return $this->redirectToRoute('app_revit_upload');
            }
        }

        return $this->render('revit/upload.html.twig');
    }

    #[Route('/files', name: 'app_revit_files', methods: ['GET'])]
    public function listFiles(Request $request): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $perPage = 20;
        $currentPage = max(1, (int) $request->query->get('page', 1));

        $repo = $this->em->getRepository(RevitFile::class);
        $totalItems = $repo->count(['tenant' => $user->getTenant()]);
        $totalPages = max(1, (int) ceil($totalItems / $perPage));
        $currentPage = min($currentPage, $totalPages);

        $files = $repo->findBy(
            ['tenant' => $user->getTenant()],
            ['uploadedAt' => 'DESC'],
            $perPage,
            ($currentPage - 1) * $perPage
        );

        return $this->render('revit/files.html.twig', [
            'files'       => $files,
            'currentPage' => $currentPage,
            'totalPages'  => $totalPages,
            'totalItems'  => $totalItems,
            'perPage'     => $perPage,
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
            $this->addFlash('success', 'flash.file_deleted_success');
        } catch (\Exception $e) {
            $this->addFlash('error', $this->container->get('translator')->trans('flash.error_deleting_file', ['%error%' => $e->getMessage()]));
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

            $this->addFlash('success', 'flash.file_marked_reprocess');
        } catch (\Exception $e) {
            $this->addFlash('error', $this->container->get('translator')->trans('flash.error_generic_with_message', ['%error%' => $e->getMessage()]));
        }

        return $this->redirectToRoute('app_revit_file_detail', ['id' => $id]);
    }
}
