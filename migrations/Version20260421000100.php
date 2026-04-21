<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260421000100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create catalog tables: equipments, labors, materials, transports';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE equipments (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, tenant_id BIGINT UNSIGNED NOT NULL, code VARCHAR(100) NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(50) DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_EQUIP_TENANT (tenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipments ADD CONSTRAINT FK_EQUIP_TENANT FOREIGN KEY (tenant_id) REFERENCES tenants (id) ON DELETE CASCADE');

        $this->addSql('CREATE TABLE labors (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, tenant_id BIGINT UNSIGNED NOT NULL, code VARCHAR(100) NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(50) DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_LABOR_TENANT (tenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE labors ADD CONSTRAINT FK_LABOR_TENANT FOREIGN KEY (tenant_id) REFERENCES tenants (id) ON DELETE CASCADE');

        $this->addSql('CREATE TABLE materials (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, tenant_id BIGINT UNSIGNED NOT NULL, code VARCHAR(100) NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(50) DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_MATERIAL_TENANT (tenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE materials ADD CONSTRAINT FK_MATERIAL_TENANT FOREIGN KEY (tenant_id) REFERENCES tenants (id) ON DELETE CASCADE');

        $this->addSql('CREATE TABLE transports (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, tenant_id BIGINT UNSIGNED NOT NULL, code VARCHAR(100) NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(50) DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_TRANSPORT_TENANT (tenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transports ADD CONSTRAINT FK_TRANSPORT_TENANT FOREIGN KEY (tenant_id) REFERENCES tenants (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE transports DROP FOREIGN KEY FK_TRANSPORT_TENANT');
        $this->addSql('DROP TABLE transports');

        $this->addSql('ALTER TABLE materials DROP FOREIGN KEY FK_MATERIAL_TENANT');
        $this->addSql('DROP TABLE materials');

        $this->addSql('ALTER TABLE labors DROP FOREIGN KEY FK_LABOR_TENANT');
        $this->addSql('DROP TABLE labors');

        $this->addSql('ALTER TABLE equipments DROP FOREIGN KEY FK_EQUIP_TENANT');
        $this->addSql('DROP TABLE equipments');
    }
}
