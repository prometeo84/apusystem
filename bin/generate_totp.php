#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use PragmaRX\Google2FA\Google2FA;
use App\Service\EncryptionService;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

// Cargar .env si existe (parsing simple)
function load_env_value(string $key): ?string
{
    $envPath = __DIR__ . '/../.env';
    if (!file_exists($envPath)) {
        return getenv($key) ?: null;
    }

    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (strpos($line, '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        [$k, $v] = explode('=', $line, 2);
        if ($k === $key) {
            return trim($v, " \t\"'\r\n");
        }
    }

    return getenv($key) ?: null;
}

$appSecret = load_env_value('APP_SECRET') ?: 'CHANGE_ME_TO_RANDOM_SECRET_KEY_32_CHARS';
$appName = load_env_value('TOTP_ISSUER') ?: load_env_value('APP_NAME') ?: 'APU System';

$google2fa = new Google2FA();
$secret = $google2fa->generateSecretKey();

// Build otpauth URI
$email = 'admin@demo.com';
$issuer = $appName;
$otpAuth = $google2fa->getQRCodeUrl($issuer, $email, $secret);

// Generate SVG QR data URI
$renderer = new ImageRenderer(new RendererStyle(400), new SvgImageBackEnd());
$writer = new Writer($renderer);
$svg = $writer->writeString($otpAuth);
$svgDataUri = 'data:image/svg+xml;base64,' . base64_encode($svg);

// Encrypt using EncryptionService (uses same logic que la app)
$encryption = new EncryptionService($appSecret);
try {
    $encrypted = $encryption->encrypt($secret);
} catch (\Throwable $e) {
    $encrypted = null;
}

// Mostrar resultados
echo "NEW TOTP SECRET (BASE32):\n" . $secret . "\n\n";
echo "OTP AUTH URI:\n" . $otpAuth . "\n\n";
echo "QR (SVG data URI):\n" . $svgDataUri . "\n\n";

if ($encrypted !== null) {
    echo "ENCRYPTED VALUE (to store in DB totp_secret):\n" . $encrypted . "\n\n";
    $sql = "UPDATE users SET totp_secret='" . addslashes($encrypted) . "', totp_enabled=1 WHERE email='" . addslashes($email) . "';";
    echo "SQL (run in DB to set secret):\n" . $sql . "\n";
} else {
    echo "Could not encrypt secret with local EncryptionService; store plaintext or run app-level encryption.\n";
    $sql = "UPDATE users SET totp_secret='" . addslashes($secret) . "', totp_enabled=1 WHERE email='" . addslashes($email) . "';";
    echo "SQL (store plaintext secret):\n" . $sql . "\n";
}

echo "\nNOTES:\n- Después de actualizar la DB, el usuario debe provisionar el secreto en su app de autenticador usando el secret o el QR.\n- También puedes ejecutar este script dentro del contenedor 'apache' para garantizar que las dependencias estén disponibles:\n  docker exec -i apache php /var/www/html/proyecto/bin/generate_totp.php\n";
