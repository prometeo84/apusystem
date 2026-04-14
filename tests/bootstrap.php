<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    $envFile = dirname(__DIR__) . '/.env';
    // Fall back to .env.test when .env is absent (e.g. in CI without a local .env file)
    if (!file_exists($envFile) && file_exists(dirname(__DIR__) . '/.env.test')) {
        $envFile = dirname(__DIR__) . '/.env.test';
    }
    (new Dotenv())->bootEnv($envFile);
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}
