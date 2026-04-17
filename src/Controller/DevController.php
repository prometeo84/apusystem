<?php

namespace App\Controller;

use App\Service\RevitFileProcessor;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/_dev')]
class DevController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private RevitFileProcessor $processor
    ) {}

    #[Route('/process-revit-fixture', name: 'app_dev_process_revit', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function processFixture(Request $request): Response
    {
        // Este endpoint está protegido por rol; permitir en entornos de prueba/dev

        $data = json_decode($request->getContent() ?: '{}', true);
        $path = $data['path'] ?? null;
        $userEmail = $data['user'] ?? 'admin@demo.com';

        if (!$path) {
            return $this->json(['error' => 'missing path'], Response::HTTP_BAD_REQUEST);
        }

        $projectDir = $this->getParameter('kernel.project_dir');
        $full = realpath($projectDir . '/' . $path);
        if (!$full || !is_file($full)) {
            return $this->json(['error' => 'file not found', 'path' => $path], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $userEmail]);
        if (!$user) {
            return $this->json(['error' => 'user not found', 'user' => $userEmail], Response::HTTP_BAD_REQUEST);
        }

        try {
            // usar UploadedFile en modo test
            $uploaded = new \Symfony\Component\HttpFoundation\File\UploadedFile($full, basename($full), null, null, true);
            $revitFile = $this->processor->processUploadedFile($uploaded, $user->getTenant(), $user);
            return $this->json(['ok' => true, 'file' => $revitFile->getOriginalFilename(), 'status' => $revitFile->getStatus()]);
        } catch (\Throwable $e) {
            $logPath = $this->getParameter('kernel.project_dir') . '/var/log/revit_processing_error.log';
            $entry = sprintf("[%s] %s: %s\n%s\n\n", (new \DateTime())->format('c'), get_class($e), $e->getMessage(), $e->getTraceAsString());
            @file_put_contents($logPath, $entry, FILE_APPEND | LOCK_EX);
            return $this->json(['error' => $e->getMessage(), 'trace_log' => 'var/log/revit_processing_error.log'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
