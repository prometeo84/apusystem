<?php

namespace App\Command;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PurgeExpiredSessionsCommand extends Command
{
    protected static $defaultName = 'app:purge-expired-sessions';

    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct();
        $this->doctrine = $doctrine;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Marca como inactivas las sesiones expiradas en la base de datos')
            ->addOption('simulate', 's', InputOption::VALUE_NONE, 'Simular sin aplicar cambios');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption('simulate')) {
            $output->writeln('Simulación: no se aplicarán cambios.');
            return Command::SUCCESS;
        }

        $conn = $this->doctrine->getConnection();

        try {
            $affected = $conn->executeStatement('UPDATE login_sessions SET is_active = 0 WHERE expires_at < NOW()');
            $output->writeln(sprintf('Sesiones marcadas como inactivas: %d', $affected));
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
