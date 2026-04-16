<?php

namespace App\Command;

use App\Entity\Tenant;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:protect-apu-tenant', description: 'Set tenant of superadmin to APU SYSTEM and protect it from edits')]
class ProtectApuTenantCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userRepo = $this->em->getRepository(User::class);
        $tenantRepo = $this->em->getRepository(Tenant::class);

        // Buscar usuario super_admin
        $superAdmins = $userRepo->createQueryBuilder('u')
            ->where('u.role = :role')
            ->setParameter('role', 'super_admin')
            ->getQuery()
            ->getResult();

        if (count($superAdmins) === 0) {
            $output->writeln('No se encontraron usuarios con role = super_admin');
            return Command::SUCCESS;
        }

        // Tomar el tenant del primer superadmin
        /** @var User $sa */
        $sa = $superAdmins[0];
        $tenant = $sa->getTenant();

        if ($tenant->isProtected()) {
            $output->writeln('El tenant ya está protegido: ' . $tenant->getName() . ' (' . $tenant->getSlug() . ')');
            return Command::SUCCESS;
        }

        // Verificar que no exista otro tenant con el slug protegido
        $existing = $tenantRepo->findOneBy(['slug' => Tenant::PROTECTED_SLUG]);
        if ($existing && $existing->getId() !== $tenant->getId()) {
            $output->writeln('Ya existe otro tenant con el slug protegido: ' . $existing->getName());
            $output->writeln('No se puede asignar el slug protegido a este tenant automáticamente.');
            return Command::FAILURE;
        }

        $tenant->setName('APU SYSTEM');
        $tenant->setSlug(Tenant::PROTECTED_SLUG);

        $this->em->persist($tenant);
        $this->em->flush();

        $output->writeln('Tenant actualizado y protegido: ' . $tenant->getName() . ' (' . $tenant->getSlug() . ')');
        $output->writeln('Ahora este tenant no podrá editarse o borrarse desde la interfaz.');

        return Command::SUCCESS;
    }
}
