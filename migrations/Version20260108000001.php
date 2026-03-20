<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration para crear tabla revit_files
 */
final class Version20260108000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Crear tabla revit_files para almacenar archivos Revit subidos (IFC/JSON/RVT)';
    }

    public function up(Schema $schema): void
    {
        // Crear tabla revit_files
        $this->addSql('CREATE TABLE revit_files (
            id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
            tenant_id BIGINT UNSIGNED NOT NULL,
            uploaded_by_id BIGINT UNSIGNED NOT NULL,
            original_filename VARCHAR(255) NOT NULL,
            stored_filename VARCHAR(255) NOT NULL,
            file_path VARCHAR(255) NOT NULL,
            file_type VARCHAR(50) NOT NULL,
            file_size INT UNSIGNED NOT NULL,
            file_hash VARCHAR(64) NOT NULL,
            status VARCHAR(50) NOT NULL,
            metadata JSON DEFAULT NULL,
            processing_result JSON DEFAULT NULL,
            error_message TEXT DEFAULT NULL,
            uploaded_at DATETIME NOT NULL,
            processed_at DATETIME DEFAULT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            INDEX IDX_93F26D7B9033212A (tenant_id),
            INDEX IDX_93F26D7BA2B28FE8 (uploaded_by_id),
            INDEX IDX_93F26D7B_STATUS (status),
            INDEX IDX_93F26D7B_TYPE (file_type),
            PRIMARY KEY (id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE=InnoDB');

        // Agregar foreign keys
        $this->addSql('ALTER TABLE revit_files
            ADD CONSTRAINT FK_93F26D7B9033212A
            FOREIGN KEY (tenant_id)
            REFERENCES tenants (id)
            ON DELETE CASCADE');

        $this->addSql('ALTER TABLE revit_files
            ADD CONSTRAINT FK_93F26D7BA2B28FE8
            FOREIGN KEY (uploaded_by_id)
            REFERENCES users (id)
            ON DELETE RESTRICT');
    }

    public function down(Schema $schema): void
    {
        // Eliminar tabla revit_files
        $this->addSql('DROP TABLE IF EXISTS revit_files');
    }
}
