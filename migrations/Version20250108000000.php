<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * APU System Tables Migration
 */
final class Version20250108000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create APU (Análisis de Precios Unitarios) system tables';
    }

    public function up(Schema $schema): void
    {
        // APU Items (Main table)
        $this->addSql('CREATE TABLE apu_items (
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
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // APU Equipment
        $this->addSql('CREATE TABLE apu_equipment (
            id INT AUTO_INCREMENT NOT NULL,
            apu_item_id INT NOT NULL,
            descripcion VARCHAR(255) NOT NULL,
            numero INT NOT NULL,
            tarifa NUMERIC(12, 2) NOT NULL,
            c_hora NUMERIC(10, 4) NOT NULL,
            INDEX IDX_APU_EQUIPMENT_ITEM (apu_item_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // APU Labor
        $this->addSql('CREATE TABLE apu_labor (
            id INT AUTO_INCREMENT NOT NULL,
            apu_item_id INT NOT NULL,
            descripcion VARCHAR(255) NOT NULL,
            numero INT NOT NULL,
            jor_hora NUMERIC(10, 4) NOT NULL,
            c_hora NUMERIC(12, 2) NOT NULL,
            INDEX IDX_APU_LABOR_ITEM (apu_item_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // APU Materials
        $this->addSql('CREATE TABLE apu_materials (
            id INT AUTO_INCREMENT NOT NULL,
            apu_item_id INT NOT NULL,
            descripcion VARCHAR(255) NOT NULL,
            unidad VARCHAR(20) NOT NULL,
            cantidad NUMERIC(10, 4) NOT NULL,
            precio_unitario NUMERIC(12, 2) NOT NULL,
            INDEX IDX_APU_MATERIALS_ITEM (apu_item_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // APU Transport
        $this->addSql('CREATE TABLE apu_transport (
            id INT AUTO_INCREMENT NOT NULL,
            apu_item_id INT NOT NULL,
            descripcion VARCHAR(255) NOT NULL,
            unidad VARCHAR(20) NOT NULL,
            cantidad NUMERIC(10, 4) NOT NULL,
            dmt NUMERIC(10, 2) NOT NULL COMMENT "Distancia Media de Transporte (km)",
            tarifa_km NUMERIC(12, 2) NOT NULL,
            INDEX IDX_APU_TRANSPORT_ITEM (apu_item_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Foreign Keys
        $this->addSql('ALTER TABLE apu_items ADD CONSTRAINT FK_APU_ITEMS_TENANT
            FOREIGN KEY (tenant_id) REFERENCES tenants (id)');
        $this->addSql('ALTER TABLE apu_equipment ADD CONSTRAINT FK_APU_EQUIPMENT_ITEM
            FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apu_labor ADD CONSTRAINT FK_APU_LABOR_ITEM
            FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apu_materials ADD CONSTRAINT FK_APU_MATERIALS_ITEM
            FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apu_transport ADD CONSTRAINT FK_APU_TRANSPORT_ITEM
            FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE apu_equipment DROP FOREIGN KEY FK_APU_EQUIPMENT_ITEM');
        $this->addSql('ALTER TABLE apu_labor DROP FOREIGN KEY FK_APU_LABOR_ITEM');
        $this->addSql('ALTER TABLE apu_materials DROP FOREIGN KEY FK_APU_MATERIALS_ITEM');
        $this->addSql('ALTER TABLE apu_transport DROP FOREIGN KEY FK_APU_TRANSPORT_ITEM');
        $this->addSql('ALTER TABLE apu_items DROP FOREIGN KEY FK_APU_ITEMS_TENANT');

        $this->addSql('DROP TABLE apu_transport');
        $this->addSql('DROP TABLE apu_materials');
        $this->addSql('DROP TABLE apu_labor');
        $this->addSql('DROP TABLE apu_equipment');
        $this->addSql('DROP TABLE apu_items');
    }
}
