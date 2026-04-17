<?php
// Safe rename helper for template_items table
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
    ['cantidad','quantity'],
    ['orden','order'],
    ['plantilla_id','template_id'],
    ['rubro_id','item_id'],
    ['apu_item_id','apu_item_id'],
];
foreach ($pairs as [$old, $new]) {
    $qOld = $pdo->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='template_items' AND COLUMN_NAME=?");
    $qOld->execute([$old]);
    $hasOld = (int)$qOld->fetchColumn();
    $qNew = $pdo->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='template_items' AND COLUMN_NAME=?");
    $qNew->execute([$new]);
    $hasNew = (int)$qNew->fetchColumn();
    if ($hasOld > 0 && $hasNew === 0) {
        echo "Renaming $old -> $new...\n";
        try {
            $pdo->exec(sprintf('ALTER TABLE `template_items` RENAME COLUMN `%s` TO `%s`', $old, $new));
            echo "OK\n";
        } catch (Exception $e) {
            echo "Failed to rename $old: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Skipping $old -> $new (hasOld={$hasOld}, hasNew={$hasNew})\n";
    }
}
