#!/usr/bin/env php
<?php

// Script para ejecutar migraciones directamente
require __DIR__ . '/vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Dotenv\Dotenv;

// Cargar entorno
(new Dotenv())->bootEnv(__DIR__ . '/.env');

// Conectar a la base de datos
$databaseUrl = $_ENV['DATABASE_URL'];
preg_match('/mysql:\/\/([^:]+):([^@]+)@([^:]+):(\d+)\/([^?]+)/', $databaseUrl, $matches);
[, $user, $password, $host, $port, $dbname] = $matches;

try {
    $connection = DriverManager::getConnection([
        'dbname' => $dbname,
        'user' => $user,
        'password' => $password,
        'host' => $host,
        'port' => $port,
        'driver' => 'pdo_mysql',
    ]);

    echo "📦 Creando tablas de APU...\n\n";

    // Crear tabla apu_items
    echo "✓ Creando tabla apu_items...\n";
    $connection->executeStatement('CREATE TABLE IF NOT EXISTS apu_items (
        id INT AUTO_INCREMENT NOT NULL,
        tenant_id INT DEFAULT NULL,
        description LONGTEXT NOT NULL,
        unit VARCHAR(20) NOT NULL,
        khu NUMERIC(10, 4) NOT NULL,
        rendimiento_uh NUMERIC(10, 4) NOT NULL,
        total_cost NUMERIC(15, 2) NOT NULL DEFAULT 0.00,
        equipment_cost NUMERIC(15, 2) NOT NULL DEFAULT 0.00,
        labor_cost NUMERIC(15, 2) NOT NULL DEFAULT 0.00,
        material_cost NUMERIC(15, 2) NOT NULL DEFAULT 0.00,
        transport_cost NUMERIC(15, 2) NOT NULL DEFAULT 0.00,
        created_at DATETIME NOT NULL,
        updated_at DATETIME NOT NULL,
        INDEX IDX_APU_TENANT (tenant_id),
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

    // Crear tabla apu_equipment
    echo "✓ Creando tabla apu_equipment...\n";
    $connection->executeStatement('CREATE TABLE IF NOT EXISTS apu_equipment (
        id INT AUTO_INCREMENT NOT NULL,
        apu_item_id INT NOT NULL,
        descripcion VARCHAR(255) NOT NULL,
        numero INT NOT NULL,
        tarifa NUMERIC(12, 2) NOT NULL,
        c_hora NUMERIC(10, 4) NOT NULL,
        INDEX IDX_APU_EQUIPMENT_ITEM (apu_item_id),
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

    // Crear tabla apu_labor
    echo "✓ Creando tabla apu_labor...\n";
    $connection->executeStatement('CREATE TABLE IF NOT EXISTS apu_labor (
        id INT AUTO_INCREMENT NOT NULL,
        apu_item_id INT NOT NULL,
        descripcion VARCHAR(255) NOT NULL,
        numero INT NOT NULL,
        jor_hora NUMERIC(10, 4) NOT NULL,
        c_hora NUMERIC(12, 2) NOT NULL,
        INDEX IDX_APU_LABOR_ITEM (apu_item_id),
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

    // Crear tabla apu_materials
    echo "✓ Creando tabla apu_materials...\n";
    $connection->executeStatement('CREATE TABLE IF NOT EXISTS apu_materials (
        id INT AUTO_INCREMENT NOT NULL,
        apu_item_id INT NOT NULL,
        descripcion VARCHAR(255) NOT NULL,
        unidad VARCHAR(20) NOT NULL,
        cantidad NUMERIC(10, 4) NOT NULL,
        precio_unitario NUMERIC(12, 2) NOT NULL,
        INDEX IDX_APU_MATERIALS_ITEM (apu_item_id),
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

    // Crear tabla apu_transport
    echo "✓ Creando tabla apu_transport...\n";
    $connection->executeStatement('CREATE TABLE IF NOT EXISTS apu_transport (
        id INT AUTO_INCREMENT NOT NULL,
        apu_item_id INT NOT NULL,
        descripcion VARCHAR(255) NOT NULL,
        unidad VARCHAR(20) NOT NULL,
        cantidad NUMERIC(10, 4) NOT NULL,
        dmt NUMERIC(10, 2) NOT NULL COMMENT "Distancia Media de Transporte (km)",
        tarifa_km NUMERIC(12, 2) NOT NULL,
        INDEX IDX_APU_TRANSPORT_ITEM (apu_item_id),
        PRIMARY KEY(id)
    ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

    // Añadir foreign keys (solo si no existen)
    echo "✓ Configurando relaciones...\n";

    try {
        $connection->executeStatement('ALTER TABLE apu_items
            ADD CONSTRAINT FK_APU_ITEMS_TENANT
            FOREIGN KEY (tenant_id) REFERENCES tenants (id)');
    } catch (\Exception $e) {
        // Ya existe
    }

    try {
        $connection->executeStatement('ALTER TABLE apu_equipment
            ADD CONSTRAINT FK_APU_EQUIPMENT_ITEM
            FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE CASCADE');
    } catch (\Exception $e) {
        // Ya existe
    }

    try {
        $connection->executeStatement('ALTER TABLE apu_labor
            ADD CONSTRAINT FK_APU_LABOR_ITEM
            FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE CASCADE');
    } catch (\Exception $e) {
        // Ya existe
    }

    try {
        $connection->executeStatement('ALTER TABLE apu_materials
            ADD CONSTRAINT FK_APU_MATERIALS_ITEM
            FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE CASCADE');
    } catch (\Exception $e) {
        // Ya existe
    }

    try {
        $connection->executeStatement('ALTER TABLE apu_transport
            ADD CONSTRAINT FK_APU_TRANSPORT_ITEM
            FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE CASCADE');
    } catch (\Exception $e) {
        // Ya existe
    }

    echo "\n✅ ¡Migración completada exitosamente!\n";
    echo "📊 Se crearon 5 tablas para el sistema APU:\n";
    echo "   - apu_items (tabla principal)\n";
    echo "   - apu_equipment (equipo)\n";
    echo "   - apu_labor (mano de obra)\n";
    echo "   - apu_materials (materiales)\n";
    echo "   - apu_transport (transporte)\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
