<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class AvatarController extends AbstractController
{
    private const DEFAULT_AVATAR_SVG = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100"><circle cx="50" cy="50" r="50" fill="#dee2e6"/><circle cx="50" cy="38" r="18" fill="#adb5bd"/><ellipse cx="50" cy="90" rx="30" ry="22" fill="#adb5bd"/></svg>';

    #[Route('/uploads/avatars/{filename}', name: 'avatar_serve', methods: ['GET'])]
    public function serve(string $filename, Request $request): Response
    {
        // Validate filename to prevent path traversal (security: still throw exception)
        if (!preg_match('/^[A-Za-z0-9._-]+$/', $filename)) {
            throw $this->createNotFoundException('Invalid filename');
        }

        $path = $this->getParameter('kernel.project_dir') . '/public/uploads/avatars/' . $filename;

        if (!is_file($path) || !is_readable($path)) {
            // Return a default SVG avatar instead of throwing (avoids flooding error log)
            $response = new Response(self::DEFAULT_AVATAR_SVG, 200);
            $response->headers->set('Content-Type', 'image/svg+xml');
            $response->setPublic();
            $response->setMaxAge(3600);
            return $response;
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
