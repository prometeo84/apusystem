<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/test')]
#[IsGranted('ROLE_SUPER_ADMIN')]
class TestController extends AbstractController
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    #[Route('/logs', name: 'app_test_logs')]
    public function testLogs(): Response
    {
        // Probar diferentes niveles de log con timezone
        $timezone = date_default_timezone_get();
        $currentTime = new \DateTime();

        $this->logger->debug('Test DEBUG log', [
            'timezone' => $timezone,
            'time' => $currentTime->format('Y-m-d H:i:s T'),
            'test' => 'debug_message'
        ]);

        $this->logger->info('Test INFO log', [
            'timezone' => $timezone,
            'time' => $currentTime->format('Y-m-d H:i:s T'),
            'test' => 'info_message'
        ]);

        $this->logger->warning('Test WARNING log', [
            'timezone' => $timezone,
            'time' => $currentTime->format('Y-m-d H:i:s T'),
            'test' => 'warning_message'
        ]);

        $this->logger->error('Test ERROR log', [
            'timezone' => $timezone,
            'time' => $currentTime->format('Y-m-d H:i:s T'),
            'test' => 'error_message',
            'stack_trace' => debug_backtrace()
        ]);

        try {
            // Generar un error intencional
            throw new \RuntimeException('Este es un error de prueba generado intencionalmente');
        } catch (\Exception $e) {
            $this->logger->critical('Test CRITICAL log - Exception capturada', [
                'timezone' => $timezone,
                'time' => $currentTime->format('Y-m-d H:i:s T'),
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        $this->addFlash('success', 'flash.test_logs_generated');

        return $this->render('test/logs.html.twig', [
            'timezone' => $timezone,
            'time' => $currentTime->format('Y-m-d H:i:s T'),
        ]);
    }

    #[Route('/error', name: 'app_test_error')]
    public function testError(): Response
    {
        // Generar un error sin capturar para probar el manejo de excepciones
        throw new \RuntimeException('Error de prueba no capturado - debe aparecer en los logs');
    }

    #[Route('/mail', name: 'app_test_mail')]
    public function testMail(): Response
    {
        // Este endpoint se usará para probar el envío de correos
        return $this->render('test/mail.html.twig');
    }
}
