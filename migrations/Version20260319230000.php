<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migración para crear tabla rate_limit_logs
 * Tabla necesaria para el sistema de rate limiting
 */
final class Version20260319230000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Crear tabla rate_limit_logs para control de rate limiting';
    }

    public function up(Schema $schema): void
    {
        // Crear tabla rate_limit_logs
        $this->addSql('
            CREATE TABLE IF NOT EXISTS rate_limit_logs (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                identifier VARCHAR(255) NOT NULL COMMENT "IP o identificador del cliente",
                endpoint VARCHAR(255) NOT NULL COMMENT "Ruta del endpoint (ej: /login)",
                attempts INT DEFAULT 1 COMMENT "Número de intentos",
                window_start DATETIME NOT NULL COMMENT "Inicio de la ventana de tiempo",
                window_end DATETIME NOT NULL COMMENT "Fin de la ventana de tiempo",
                exceeded_at DATETIME DEFAULT NULL COMMENT "Momento en que se excedió el límite",
                created_at DATETIME NOT NULL,
                INDEX idx_identifier_endpoint (identifier, endpoint),
                INDEX idx_window (window_end),
                INDEX idx_cleanup (window_end, created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ');
    }

    public function down(Schema $schema): void
    {
        // Eliminar tabla si se hace rollback
        $this->addSql('DROP TABLE IF EXISTS rate_limit_logs');
    }
}
