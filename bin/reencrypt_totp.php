<?php
// Script de utilidad: encripta el totp_secret actual del admin@demo.com
require __DIR__ . '/../vendor/autoload.php';

use App\Service\EncryptionService;

// APP_SECRET hardcoded en este script para ejecutar en el contenedor.
// Está tomado desde .env.dev generado localmente.
$appSecret = 'de80feace879d6e1456993b68cccf4c1a7510d98af99c5591da02071b548892e';

try {
    $enc = new EncryptionService($appSecret);
} catch (Throwable $e) {
    echo "EncryptionService init failed: " . $e->getMessage() . PHP_EOL;
    exit(2);
}

$pdo = new PDO('mysql:host=mysql;dbname=apu_system', 'root', 'root');
$stmt = $pdo->prepare('SELECT id, email, totp_secret FROM users WHERE email = ?');
$stmt->execute(['admin@demo.com']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "User not found\n";
    exit(1);
}

echo "Found user: " . $row['email'] . "\n";
echo "Current totp_secret (raw): " . $row['totp_secret'] . "\n";

try {
    $cipher = $enc->encrypt($row['totp_secret']);
} catch (Throwable $e) {
    echo "Encryption failed: " . $e->getMessage() . PHP_EOL;
    exit(3);
}

$u = $pdo->prepare('UPDATE users SET totp_secret = ? WHERE id = ?');
$u->execute([$cipher, $row['id']]);
echo "Updated rows: " . $u->rowCount() . "\n";

$verify = $pdo->prepare('SELECT totp_secret FROM users WHERE id = ?');
$verify->execute([$row['id']]);
$new = $verify->fetch(PDO::FETCH_ASSOC);
echo "Stored cipher: " . $new['totp_secret'] . "\n";
echo "Decrypt check: " . ($enc->decryptOrNull($new['totp_secret']) ?? 'NULL') . "\n";

echo "Done.\n";
