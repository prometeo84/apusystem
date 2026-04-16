<?php
// Script para crear un APU de prueba en la primera tenant existente.
use App\Entity\Apu;
use App\Entity\Tenant;


// Intentar cargar variables desde .env si existe
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2) + [1 => '']);
        $v = trim($v, " \"'");
        putenv("$k=$v");
        $_ENV[$k] = $v;
        $_SERVER[$k] = $v;
    }
}

// Boot kernel (require autoload)
require __DIR__ . '/../vendor/autoload.php';

use App\Kernel;

$kernel = new Kernel($_SERVER['APP_ENV'] ?? 'dev', (bool) ($_SERVER['APP_DEBUG'] ?? true));
$kernel->boot();
$container = $kernel->getContainer();
$doctrine = $container->get('doctrine');
$em = $doctrine->getManager();

$tenant = $em->getRepository(Tenant::class)->findOneBy([]);
if (!$tenant) {
    echo "No tenant found, aborting.\n";
    exit(1);
}

$apu = new Apu();
$apu->setTenant($tenant);
$apu->setCode('TEST-APU-' . time());
$apu->setDescription('APU de prueba para E2E');
$apu->setUnit('u');
$apu->setQuantity('1');
$apu->setYield(null);
$apu->setUnitCost('0.00');
$apu->setTotalCost('0.00');

$em->persist($apu);
$em->flush();

echo "Created APU id=" . $apu->getId() . "\n";

return 0;
