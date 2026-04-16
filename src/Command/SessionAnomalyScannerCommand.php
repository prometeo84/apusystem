<?php

namespace App\Command;

use App\Entity\LoginSession;
use App\Service\SessionAnomalyDetector;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:session:scan-anomalies', description: 'Scan active sessions for anomalies and invalidate suspicious ones')]
class SessionAnomalyScannerCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private SessionAnomalyDetector $detector,
        private LoggerInterface $logger
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repo = $this->em->getRepository(LoginSession::class);
        $sessions = $repo->findBy(['isActive' => true]);

        $invalidated = 0;

        foreach ($sessions as $s) {
            try {
                $user = $s->getUser();
                $should = $this->detector->detect($user, $s->getSessionId());
                if ($should) {
                    $s->invalidate();
                    $this->em->persist($s);
                    $invalidated++;
                    $this->logger->warning('Invalidated suspicious session', ['session' => $s->getId(), 'user' => $user->getUserIdentifier()]);
                }
            } catch (\Throwable $e) {
                $this->logger->error('Error scanning session', ['exception' => $e]);
            }
        }

        $this->em->flush();

        $output->writeln(sprintf('Scanned %d sessions, invalidated %d', count($sessions), $invalidated));
        return Command::SUCCESS;
    }
}
