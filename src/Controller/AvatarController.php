<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class AvatarController extends AbstractController
{
    #[Route('/uploads/avatars/{filename}', name: 'avatar_serve', methods: ['GET'])]
    public function serve(string $filename, Request $request): BinaryFileResponse
    {
        // Validate filename to prevent path traversal
        if (!preg_match('/^[A-Za-z0-9._-]+$/', $filename)) {
            throw $this->createNotFoundException('Invalid filename');
        }

        $path = $this->getParameter('kernel.project_dir') . '/public/uploads/avatars/' . $filename;

        if (!is_file($path) || !is_readable($path)) {
            throw $this->createNotFoundException('File not found');
        }

        $response = new BinaryFileResponse($path);
        $mime = @mime_content_type($path) ?: 'application/octet-stream';
        $response->headers->set('Content-Type', $mime);

        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $filename);
        $response->headers->set('Content-Disposition', $disposition);

        // Cache for 1 day
        $response->setPublic();
        $response->setMaxAge(86400);
        $response->setSharedMaxAge(86400);

        return $response;
    }
}
