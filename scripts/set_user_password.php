<?php
// Usage: php scripts/set_user_password.php email "NewP@ssw0rd"
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/bootstrap.php';

use App\Kernel;

$email = $argv[1] ?? null;
$password = $argv[2] ?? null;

if (!$email || !$password) {
    echo "Usage: php scripts/set_user_password.php email \"NewPassword\"\n";
    exit(2);
}

$kernel = new Kernel('dev', true);
$kernel->boot();
$container = $kernel->getContainer();
$em = $container->get('doctrine')->getManager();
$user = $em->getRepository(\App\Entity\User::class)->findOneBy(['email' => $email]);

if (!$user) {
    echo "User not found: $email\n";
    exit(1);
}

$hasher = $container->get('security.password_hasher');
$hash = $hasher->hashPassword($user, $password);
$user->setPassword($hash);
$em->flush();

echo "Password updated for $email\n";
