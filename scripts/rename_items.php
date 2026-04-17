<?php
// Safe rename helper for items table
$db = getenv('DB_DATABASE') ?: 'apu_system';
$host = getenv('DB_HOST') ?: 'mysql';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: 'root';
try {
    $pdo = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo "DB connect failed: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
$pairs = [
    ['nombre','name'],
    ['tipo','type'],
    ['activo','active'],
];
foreach ($pairs as [$old, $new]) {
    $q = $pdo->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='items' AND COLUMN_NAME=?");
    $q->execute([$old]);
    $hasOld = (int)$q->fetchColumn();
    $q->execute([$new]);
    $hasNew = (int)$q->fetchColumn();
    if ($hasOld > 0 && $hasNew === 0) {
        echo "Renaming $old -> $new...\n";
        try {
            $pdo->exec(sprintf('ALTER TABLE `items` RENAME COLUMN `%s` TO `%s`', $old, $new));
            echo "OK\n";
        } catch (Exception $e) {
            echo "Failed: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Skipping $old -> $new (hasOld={$hasOld}, hasNew={$hasNew})\n";
    }
}
