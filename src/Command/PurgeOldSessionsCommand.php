<?php

namespace App\Command;

use App\Entity\LoginSession;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:session:purge-old', description: 'Purge login sessions inactive for more than N days')]
class PurgeOldSessionsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private LoggerInterface $logger
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('days', null, InputOption::VALUE_REQUIRED, 'Number of days of inactivity to consider a session old', 30);
        $this->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run (do not persist changes)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $days = (int)$input->getOption('days');
        $dryRun = (bool)$input->getOption('dry-run');

        $cutoff = new \DateTime(sprintf('-%d days', $days));

        $repo = $this->em->getRepository(LoginSession::class);

        $qb = $repo->createQueryBuilder('ls')
            ->where('ls.isActive = true')
            ->andWhere('ls.lastActivityAt < :cutoff')
            ->setParameter('cutoff', $cutoff);

        $oldSessions = $qb->getQuery()->getResult();

        $count = count($oldSessions);
        $output->writeln(sprintf('Found %d sessions older than %d days (cutoff %s)', $count, $days, $cutoff->format(DATE_ATOM)));

        if ($count === 0) {
            return Command::SUCCESS;
        }

        foreach ($oldSessions as $s) {
            try {
                $s->invalidate();
                if (!$dryRun) {
                    $this->em->persist($s);
                }
            } catch (\Throwable $e) {
                $this->logger->error('Error invalidating old session', ['id' => $s->getId(), 'exception' => $e]);
            }
        }

        if (!$dryRun) {
            $this->em->flush();
        }

        $output->writeln(sprintf('%s %d sessions', $dryRun ? 'Would purge' : 'Purged', $count));

        return Command::SUCCESS;
    }
}
