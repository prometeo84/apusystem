<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DevErrorController
{
    #[Route('/__trigger_error_for_test', name: 'app_trigger_error_for_test')]
    public function trigger(): Response
    {
        // Lanzar una excepción deliberada para probar el listener
        throw new \RuntimeException('Prueba: excepción forzada para validar el envío de email por ErrorNotificationListener');
    }
}
