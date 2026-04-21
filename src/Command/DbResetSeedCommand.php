<?php

namespace App\Command;

use App\Entity\Tenant;
use App\Entity\User;
use App\Entity\Projects;
use App\Entity\Template;
use App\Entity\APUItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DbResetSeedCommand extends Command
{
    protected static $defaultName = 'app:db:reset-seed';

    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Vacía la base de datos dejando solo el tenant demo y el superadmin, y siembra datos mínimos (projects, templates, apu) con created_by.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Ejecutar sin pedir confirmación');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$input->getOption('force')) {
            if (!$io->confirm('Esta acción eliminará datos. ¿Deseas continuar?', false)) {
                $io->warning('Operación cancelada');
                return Command::SUCCESS;
            }
        }

        $em = $this->em;
        $conn = $em->getConnection();

        $io->text('Starting DB reset and seed...');

        $em->beginTransaction();
        try {
            // Ensure demo tenant exists
            $tenantRepo = $em->getRepository(Tenant::class);
            $demo = $tenantRepo->findOneBy(['slug' => Tenant::PROTECTED_SLUG]);
            if (!$demo) {
                $demo = new Tenant();
                $demo->setName('Demo Company');
                $demo->setSlug(Tenant::PROTECTED_SLUG);
                $em->persist($demo);
                $em->flush();
                $io->text('Demo tenant created');
            }

            // Remove all tenants except demo
            $qb = $em->createQueryBuilder();
            $qb->delete(Tenant::class, 't')
                ->where('t.slug != :slug')
                ->setParameter('slug', Tenant::PROTECTED_SLUG);
            $qb->getQuery()->execute();

            $em->flush();

            // Remove all users not in demo tenant
            $userRepo = $em->getRepository(User::class);
            $super = $userRepo->findOneBy(['email' => 'admin@demo.com']);
            if (!$super) {
                $super = new User();
                $super->setTenant($demo);
                $super->setEmail('admin@demo.com');
                $super->setUsername('admin');
                $super->setFirstName('Super');
                $super->setLastName('Admin');
                // Hash password using PHP's password_hash to avoid service visibility issues
                $super->setPassword(password_hash('changeme', PASSWORD_DEFAULT));
                $super->setRole('super_admin');
                $em->persist($super);
                $em->flush();
                $io->text('Superadmin created (admin@demo.com)');
            } else {
                // ensure belongs to demo
                $super->setTenant($demo);
                $em->persist($super);
                // ensure password hashed if needed (simple heuristic)
                if (strlen($super->getPassword()) < 60) {
                    $super->setPassword(password_hash('changeme', PASSWORD_DEFAULT));
                }
                $em->flush();
            }

            // Seed a sample project with createdBy = superadmin
            $project = new Projects();
            $project->setTenant($demo)
                ->setName('Demo Project')
                ->setCode('DEMO-1')
                ->setStatus('activo');
            $project->setCreatedBy($super);
            $em->persist($project);

            // Template
            $template = new Template();
            $template->setTenant($demo)
                ->setProject($project)
                ->setName('Demo Template');
            $template->setCreatedBy($super);
            $em->persist($template);

            // APU
            $apu = new APUItem();
            $apu->setTenant($demo)
                ->setDescription('Demo APU')
                ->setUnit('u')
                ->setKhu('1.0')
                ->setProductivityUh('1.0');
            $apu->setCreatedBy($super);
            $em->persist($apu);

            $em->flush();
            $em->commit();

            $io->success('DB reset and seed completed');
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $em->rollback();
            $io->error('Error during DB reset: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
