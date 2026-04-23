<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:list-users',
    description: 'List all users in the system'
)]
class ListUsersCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('tenant', 't', InputOption::VALUE_OPTIONAL, 'Filter by tenant slug or ID')
            ->addOption('role', 'r', InputOption::VALUE_OPTIONAL, 'Filter by role (user, admin, super_admin, manager)')
            ->addOption('active', null, InputOption::VALUE_NONE, 'Show only active (non-locked) users');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $qb = $this->em->getRepository(User::class)->createQueryBuilder('u')
            ->join('u.tenant', 't')
            ->orderBy('t.name', 'ASC')
            ->addOrderBy('u.email', 'ASC');

        $tenantFilter = $input->getOption('tenant');
        if ($tenantFilter !== null) {
            if (is_numeric($tenantFilter)) {
                $qb->andWhere('t.id = :tenant')->setParameter('tenant', (int)$tenantFilter);
            } else {
                $qb->andWhere('t.slug = :tenant')->setParameter('tenant', $tenantFilter);
            }
        }

        $roleFilter = $input->getOption('role');
        if ($roleFilter !== null) {
            $qb->andWhere('u.role = :role')->setParameter('role', $roleFilter);
        }

        if ($input->getOption('active')) {
            $qb->andWhere('u.isLocked = false OR u.isLocked IS NULL');
        }

        /** @var User[] $users */
        $users = $qb->getQuery()->getResult();

        if (empty($users)) {
            $output->writeln('<comment>No users found.</comment>');
            return Command::SUCCESS;
        }

        $table = new Table($output);
        $table->setHeaders(['ID', 'Email', 'Username', 'Role', 'Tenant', '2FA', 'Locked']);

        foreach ($users as $user) {
            $table->addRow([
                $user->getId(),
                $user->getEmail(),
                $user->getUsername(),
                $user->getRole(),
                $user->getTenant()->getName(),
                $user->isTotpEnabled() ? 'Yes' : 'No',
                method_exists($user, 'isLocked') && $user->isLocked() ? 'Yes' : 'No',
            ]);
        }

        $table->render();
        $output->writeln(sprintf('<info>Total: %d user(s)</info>', count($users)));

        return Command::SUCCESS;
    }
}
