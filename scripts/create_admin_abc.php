<?php

use App\Entity\Tenant;
use App\Entity\User;

require dirname(__DIR__) . '/vendor/autoload.php';

$env = getenv('APP_ENV') ?: 'dev';
$_SERVER['APP_ENV'] = $env;
$_SERVER['APP_DEBUG'] = '0';

$kernel = new \App\Kernel($env, (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();
$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();

$tenant = $em->getRepository(Tenant::class)->findOneBy(['slug' => Tenant::PROTECTED_SLUG]);
if (!$tenant) {
    echo "Protected tenant not found\n";
    exit(1);
}

$email = 'admin@abc.com';
$existing = $em->getRepository(User::class)->findOneBy(['email' => $email]);
if ($existing) {
    echo "User $email already exists\n";
    exit(0);
}

$user = new User();
$user->setTenant($tenant);
$user->setEmail($email);
$user->setUsername('admin_abc');
$user->setFirstName('Admin');
$user->setLastName('ABC');
$user->setRole('admin');
$user->setPassword(password_hash('Admin123!', PASSWORD_BCRYPT));
$em->persist($user);
$em->flush();

echo "Created $email\n";
