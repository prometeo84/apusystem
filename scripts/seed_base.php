<?php
// CLI helper to seed base tenant + superadmin after recreating schema
use App\Entity\Tenant;
use App\Entity\User;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

// Boot kernel
$env = getenv('APP_ENV') ?: 'prod';
$_SERVER['APP_ENV'] = $env;
$_SERVER['APP_DEBUG'] = '0';

$kernel = new \App\Kernel($env, (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();
$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();

// Create protected tenant
$tenant = new Tenant();
$tenant->setName('APU System');
$tenant->setSlug(Tenant::PROTECTED_SLUG);
$tenant->setIsActive(true);
$tenant->setPlan('basic');
$tenant->setMaxUsers(5);
$tenant->setMaxProjects(10);
$em->persist($tenant);

// Create superadmin user
$user = new User();
$user->setTenant($tenant);
$user->setEmail('superadmin@example.test');
$user->setUsername('superadmin');
$user->setFirstName('Super');
$user->setLastName('Admin');
$user->setRole('super_admin');
$hashed = password_hash('ChangeMe123!', PASSWORD_DEFAULT);
$user->setPassword($hashed);
$em->persist($user);

$em->flush();

echo "Seeded tenant '" . Tenant::PROTECTED_SLUG . "' and user 'superadmin'\n";
