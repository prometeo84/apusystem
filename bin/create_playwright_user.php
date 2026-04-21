<?php

use App\Kernel;
use App\Entity\Tenant;
use App\Entity\User;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    $envFile = dirname(__DIR__) . '/.env';
    if (!file_exists($envFile) && file_exists(dirname(__DIR__) . '/.env.test')) {
        $envFile = dirname(__DIR__) . '/.env.test';
    }
    (new Dotenv())->bootEnv($envFile);
}

$kernel = new Kernel($_SERVER['APP_ENV'] ?? 'dev', (bool)($_SERVER['APP_DEBUG'] ?? false));
$kernel->boot();
$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();

// Create tenant
// Ensure tenant exists
$tenant = $em->getRepository(Tenant::class)->findOneBy(['slug' => 'playwright-test']);
if (!$tenant) {
    $tenant = new Tenant();
    $tenant->setName('Playwright Tenant');
    $tenant->setSlug('playwright-test');
    $em->persist($tenant);
    $em->flush();
}

// Determine password from env or default to match Playwright tests
$playwrightPassword = getenv('ADMIN_PASSWORD') ?: 'Admin123!';
$passwordHash = password_hash($playwrightPassword, PASSWORD_BCRYPT);

// Find all users with that email and update them, or create one if none exist
$users = $em->getRepository(User::class)->findBy(['email' => 'admin@demo.com']);
if (count($users) === 0) {
    $user = new User();
    $user->setTenant($tenant)
        ->setEmail('admin@demo.com')
        ->setUsername('admin')
        ->setFirstName('Playwright')
        ->setLastName('Admin')
        ->setRole('ROLE_SUPER_ADMIN')
        ->setIsActive(true);
    $users = [$user];
}

foreach ($users as $user) {
    $user->setPassword($passwordHash);
    if (method_exists($user, 'setFailedLoginAttempts')) {
        $user->setFailedLoginAttempts(0);
    }
    if (method_exists($user, 'setLockedUntil')) {
        $user->setLockedUntil(null);
    }
    $em->persist($user);
}

$em->flush();

echo "Ensured " . count($users) . " user(s) with email admin@demo.com updated.\n";
