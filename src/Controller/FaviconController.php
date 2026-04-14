<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FaviconController
{
    #[Route('/favicon.ico', name: 'app_favicon')]
    public function favicon(): Response
    {

        $generated = __DIR__ . '/../../public/favicon_generated.ico';
        $standard = __DIR__ . '/../../public/favicon.ico';

        $path = file_exists($generated) ? $generated : $standard;
        if (file_exists($path)) {
            $response = new BinaryFileResponse($path);
            $response->headers->set('Content-Type', 'image/x-icon');
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, 'favicon.ico');
            $response->setMaxAge(86400);
            return $response;
        }

        return new Response('', 404);
    }
}
