<?php
// Seed test users expected by Playwright E2E suite (new copy)
use App\Entity\Tenant;
use App\Entity\User;

require dirname(__DIR__) . '/vendor/autoload.php';

$env = getenv('APP_ENV') ?: 'prod';
$_SERVER['APP_ENV'] = $env;
$_SERVER['APP_DEBUG'] = '0';

$kernel = new \App\Kernel($env, (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();
$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();

// Find protected tenant
$tenantRepo = $em->getRepository(Tenant::class);
$tenant = $tenantRepo->findOneBy(['slug' => Tenant::PROTECTED_SLUG]);
if (!$tenant) {
    echo "Protected tenant not found\n";
    exit(1);
}

$users = [
    ['email' => 'admin@demo.com', 'username' => 'admin_demo', 'role' => 'admin', 'password' => 'Admin123!'],
    ['email' => 'admin@abc.com', 'username' => 'admin_abc', 'role' => 'admin', 'password' => 'Admin123!'],
    ['email' => 'admin@test.com', 'username' => 'admin_test', 'role' => 'admin', 'password' => 'Admin123!'],
    ['email' => 'user@demo.com', 'username' => 'user_demo', 'role' => 'user', 'password' => 'User123!'],
    ['email' => 'user@abc.com', 'username' => 'user_abc', 'role' => 'user', 'password' => 'Admin123!'],
];

foreach ($users as $u) {
    $existing = $em->getRepository(User::class)->findOneBy(['email' => $u['email']]);
    if ($existing) {
        echo "User {$u['email']} exists, skipping\n";
        continue;
    }
    $user = new User();
    $user->setTenant($tenant);
    $user->setEmail($u['email']);
    $user->setUsername($u['username']);
    $user->setFirstName(explode('@', $u['email'])[0]);
    $user->setLastName('Test');
    $user->setRole($u['role']);
    $user->setPassword(password_hash($u['password'], PASSWORD_DEFAULT));
    $em->persist($user);
    echo "Created {$u['email']}\n";
}
$em->flush();
echo "Seeded test users (new).\n";
