<?php
require __DIR__ . '/../vendor/autoload.php';
if (file_exists(__DIR__ . '/../.env')) {
    (new Symfony\Component\Dotenv\Dotenv())->load(__DIR__ . '/../.env');
}

use App\Kernel;

$env = $_SERVER['APP_ENV'] ?? 'dev';
$debug = (bool) ($_SERVER['APP_DEBUG'] ?? true);
$kernel = new Kernel($env, $debug);
$kernel->boot();
$container = $kernel->getContainer();

$conn = $container->get('doctrine')->getConnection();
// Map to DB column names (entity property 'nombre' maps to column 'name')
$rows = $conn->fetchAllAssociative('SELECT id, name FROM projects ORDER BY id DESC LIMIT 50');
if (!$rows) {
    echo "No projects found or DB connection failed.\n";
    exit(1);
}

foreach ($rows as $r) {
    echo sprintf("%d\t%s\n", $r['id'], $r['name']);
}

exit(0);
