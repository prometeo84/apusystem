<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

#[AsCommand(
    name: 'app:test-email',
    description: 'Envía un correo de prueba a Mailpit',
)]
class TestEmailCommand extends Command
{
    public function __construct(
        private MailerInterface $mailer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('to', InputArgument::OPTIONAL, 'Dirección de correo destino', 'test@example.com')
            ->setHelp('Este comando envía un correo de prueba para verificar la configuración de Mailpit');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $toEmail = $input->getArgument('to');

        $io->title('🔧 Prueba de Envío de Correo - APU System');

        try {
            // Correo simple de prueba
            $email = (new Email())
                ->from(new Address('noreply@apusystem.com', 'APU System'))
                ->to(new Address($toEmail))
                ->subject('✅ Correo de Prueba - APU System')
                ->text('Este es un correo de prueba enviado desde APU System.')
                ->html('<h1>✅ Correo de Prueba</h1>
                    <p>Este es un correo de prueba enviado desde <strong>APU System</strong>.</p>
                    <p><small>Fecha: ' . date('d/m/Y H:i:s') . '</small></p>
                    <hr>
                    <p style="color: green;">Si ves este mensaje, el sistema de correo está funcionando correctamente.</p>
                    <p><strong>Configuración:</strong></p>
                    <ul>
                        <li>Servidor SMTP: Mailpit (Docker)</li>
                        <li>Puerto: 1025</li>
                        <li>Interfaz Web: <a href="http://localhost:8025">http://localhost:8025</a></li>
                    </ul>');

            $this->mailer->send($email);

            $io->success([
                'Correo enviado exitosamente',
                'Destinatario: ' . $toEmail,
                'Revisa Mailpit en: http://localhost:8025'
            ]);

            $io->note('El correo debería aparecer inmediatamente en la interfaz de Mailpit');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error([
                'Error al enviar el correo',
                'Mensaje: ' . $e->getMessage(),
                'Archivo: ' . $e->getFile() . ':' . $e->getLine()
            ]);

            $io->section('Verifica que:');
            $io->listing([
                'Mailpit esté ejecutándose (docker ps | grep mailpit)',
                'La configuración MAILER_DSN en .env sea correcta',
                'El puerto 1025 esté disponible'
            ]);

            return Command::FAILURE;
        }
    }
}
