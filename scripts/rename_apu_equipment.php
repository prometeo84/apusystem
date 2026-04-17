<?php
$dsn = "mysql:host=mysql;dbname=apu_system;charset=utf8mb4";
$user = 'root';
$pass = 'root';
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo "DB connect failed: ". $e->getMessage() . PHP_EOL;
    exit(1);
}
$pairs = [
    ['numero','quantity'],
    ['tarifa','rate'],
    ['c_hora','cost_per_hour'],
];
foreach ($pairs as $p) {
    list($old, $new) = $p;
    $qOld = $pdo->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='apu_equipment' AND COLUMN_NAME=?");
    $qOld->execute([$old]);
    $hasOld = (int)$qOld->fetchColumn();
    $qNew = $pdo->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='apu_equipment' AND COLUMN_NAME=?");
    $qNew->execute([$new]);
    $hasNew = (int)$qNew->fetchColumn();
    if ($hasOld > 0 && $hasNew === 0) {
        echo "Renaming $old -> $new...\n";
        $sql = sprintf('ALTER TABLE `apu_equipment` RENAME COLUMN `%s` TO `%s`', $old, $new);
        try {
            $pdo->exec($sql);
            echo "OK\n";
        } catch (Exception $e) {
            echo "Failed to rename $old: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Skipping $old -> $new (hasOld=$hasOld, hasNew=$hasNew)\n";
    }
}
