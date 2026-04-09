<?php
// Comprueba y muestra el totp_secret descifrado y el OTP actual para admin@demo.com
require __DIR__ . '/../vendor/autoload.php';

// Preferir APP_SECRET desde entorno; si no existe usamos el valor generado localmente
$appSecret = getenv('APP_SECRET') ?: 'de80feace879d6e1456993b68cccf4c1a7510d98af99c5591da02071b548892e';

try {
    $pdo = new PDO('mysql:host=mysql;dbname=apu_system', 'root', 'root');
} catch (Throwable $e) {
    echo "DB_CONNECT_ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

$stmt = $pdo->prepare('SELECT totp_secret FROM users WHERE email = ?');
$stmt->execute(['admin@demo.com']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "NO_USER\n";
    exit(1);
}

$enc = new App\Service\EncryptionService($appSecret);
$dec = $enc->decryptOrNull($row['totp_secret']);
echo "DECRYPTED:" . ($dec ?? 'NULL') . PHP_EOL;

if ($dec) {
    $g = new PragmaRX\Google2FA\Google2FA();
    echo "CURRENT_OTP:" . $g->getCurrentOtp($dec) . PHP_EOL;
} else {
    echo "NO_OTP_GENERATED\n";
}

exit(0);
