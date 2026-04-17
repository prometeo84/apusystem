<?php

namespace App\Command;

use App\Service\RevitFileProcessor;
use App\Entity\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(name: 'app:process-revit-fixture', description: 'Procesa un fixture JSON de Revit y persiste RevitFile + APUs (modo dev)')]
class ProcessRevitFixtureCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private RevitFileProcessor $processor
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('path', InputArgument::REQUIRED, 'Ruta al archivo JSON (relativa al proyecto)');
        $this->addArgument('user', InputArgument::OPTIONAL, 'Email del usuario que realizará la subida', 'admin@demo.com');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $path = $input->getArgument('path');
        $userEmail = $input->getArgument('user');

        $full = realpath(getcwd() . '/' . $path);
        if (!$full || !is_file($full)) {
            $output->writeln('<error>Archivo no encontrado: ' . $path . '</error>');
            return Command::FAILURE;
        }

        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $userEmail]);
        if (!$user) {
            $output->writeln('<error>Usuario no encontrado: ' . $userEmail . '</error>');
            return Command::FAILURE;
        }

        // Construir UploadedFile en modo "test" para evitar is_uploaded_file checks
        $uploaded = new UploadedFile($full, basename($full), null, null, true);

        try {
            $revitFile = $this->processor->processUploadedFile($uploaded, $user->getTenant(), $user);
            $output->writeln('<info>Procesado OK: ' . $revitFile->getOriginalFilename() . ' - status: ' . $revitFile->getStatus() . '</info>');
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln('<error>Error procesando fixture: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }
}
