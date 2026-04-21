<?php

use App\Entity\Tenant;
use App\Entity\User;
use App\Entity\Projects;
use App\Entity\Template;
use App\Entity\APUItem;

$loader = require __DIR__ . '/../vendor/autoload.php';

// Load .env if Dotenv available and env not already set
if (!isset($_ENV['APP_ENV']) || !isset($_ENV['DATABASE_URL'])) {
    if (class_exists(\Symfony\Component\Dotenv\Dotenv::class)) {
        $dotenv = new \Symfony\Component\Dotenv\Dotenv();
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $dotenv->bootEnv($envFile);
        }
    }
}

// Boot the Symfony kernel
$kernel = new \App\Kernel($_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'dev', (bool) ($_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? true));
$kernel->boot();
$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();

echo "Starting demo seed...\n";

$em->getConnection()->beginTransaction();
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
        echo "Demo tenant created\n";
    }

    // Delete everything except demo tenant
    $qb = $em->createQueryBuilder();
    $qb->delete(Tenant::class, 't')
        ->where('t.slug != :slug')
        ->setParameter('slug', Tenant::PROTECTED_SLUG)
        ->getQuery()
        ->execute();

    // Create or ensure superadmin
    $userRepo = $em->getRepository(User::class);
    $super = $userRepo->findOneBy(['email' => 'admin@demo.com']);
    if (!$super) {
        $super = new User();
        $super->setTenant($demo);
        $super->setEmail('admin@demo.com');
        $super->setUsername('admin');
        $super->setFirstName('Super');
        $super->setLastName('Admin');
        // Hash the demo password using PHP's password_hash to avoid container service visibility issues
        $super->setPassword(password_hash('changeme', PASSWORD_DEFAULT));
        $super->setRole('super_admin');
        $em->persist($super);
        $em->flush();
        echo "Superadmin created\n";
    } else {
        $super->setTenant($demo);
        $em->persist($super);
        // Ensure password is hashed if not already (simple heuristic)
        if (strlen($super->getPassword()) < 60) {
            $super->setPassword(password_hash('changeme', PASSWORD_DEFAULT));
        }
        $em->flush();
    }

    // Seed a sample project, template and apu with createdBy = superadmin
    $project = new Projects();
    $project->setTenant($demo)
        ->setName('Demo Project')
        ->setCode('DEMO-1')
        ->setStatus('activo');
    if (method_exists($project, 'setCreatedBy')) {
        $project->setCreatedBy($super);
    }
    $em->persist($project);

    $template = new Template();
    $template->setTenant($demo)
        ->setProject($project)
        ->setName('Demo Template');
    if (method_exists($template, 'setCreatedBy')) {
        $template->setCreatedBy($super);
    }
    $em->persist($template);

    $apu = new APUItem();
    $apu->setTenant($demo)
        ->setDescription('Demo APU')
        ->setUnit('u')
        ->setKhu('1.0')
        ->setProductivityUh('1.0');
    if (method_exists($apu, 'setCreatedBy')) {
        $apu->setCreatedBy($super);
    }
    $em->persist($apu);

    $em->flush();
    $em->getConnection()->commit();

    echo "Seed completed.\n";
} catch (\Throwable $e) {
    $em->getConnection()->rollBack();
    echo "Error during seed: " . $e->getMessage() . "\n";
    exit(1);
}

return 0;
