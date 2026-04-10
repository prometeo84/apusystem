<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260410173013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plantilla_rubros (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, cantidad NUMERIC(15, 4) NOT NULL, orden INT NOT NULL, created_at DATETIME NOT NULL, plantilla_id BIGINT UNSIGNED NOT NULL, rubro_id BIGINT UNSIGNED NOT NULL, apu_item_id BIGINT UNSIGNED DEFAULT NULL, INDEX IDX_FFBF06D4A08F3969 (plantilla_id), INDEX IDX_FFBF06D496C5081 (rubro_id), UNIQUE INDEX UNIQ_FFBF06D4B5A5975C (apu_item_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE plantillas (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion LONGTEXT DEFAULT NULL, activa TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, tenant_id BIGINT UNSIGNED NOT NULL, proyecto_id BIGINT UNSIGNED NOT NULL, INDEX IDX_E91A52B79033212A (tenant_id), INDEX IDX_E91A52B7F625D1BA (proyecto_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE rubros (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, codigo VARCHAR(100) NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion LONGTEXT DEFAULT NULL, unidad VARCHAR(50) NOT NULL, tipo VARCHAR(20) NOT NULL, activo TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, tenant_id BIGINT UNSIGNED NOT NULL, INDEX IDX_2B29B68E9033212A (tenant_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE plantilla_rubros ADD CONSTRAINT FK_FFBF06D4A08F3969 FOREIGN KEY (plantilla_id) REFERENCES plantillas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plantilla_rubros ADD CONSTRAINT FK_FFBF06D496C5081 FOREIGN KEY (rubro_id) REFERENCES rubros (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE plantilla_rubros ADD CONSTRAINT FK_FFBF06D4B5A5975C FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE plantillas ADD CONSTRAINT FK_E91A52B79033212A FOREIGN KEY (tenant_id) REFERENCES tenants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plantillas ADD CONSTRAINT FK_E91A52B7F625D1BA FOREIGN KEY (proyecto_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rubros ADD CONSTRAINT FK_2B29B68E9033212A FOREIGN KEY (tenant_id) REFERENCES tenants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apu_items ADD utilidad_pct NUMERIC(5, 2) DEFAULT NULL, ADD precio_ofertado NUMERIC(15, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plantilla_rubros DROP FOREIGN KEY FK_FFBF06D4A08F3969');
        $this->addSql('ALTER TABLE plantilla_rubros DROP FOREIGN KEY FK_FFBF06D496C5081');
        $this->addSql('ALTER TABLE plantilla_rubros DROP FOREIGN KEY FK_FFBF06D4B5A5975C');
        $this->addSql('ALTER TABLE plantillas DROP FOREIGN KEY FK_E91A52B79033212A');
        $this->addSql('ALTER TABLE plantillas DROP FOREIGN KEY FK_E91A52B7F625D1BA');
        $this->addSql('ALTER TABLE rubros DROP FOREIGN KEY FK_2B29B68E9033212A');
        $this->addSql('DROP TABLE plantilla_rubros');
        $this->addSql('DROP TABLE plantillas');
        $this->addSql('DROP TABLE rubros');
        $this->addSql('ALTER TABLE apu_items DROP utilidad_pct, DROP precio_ofertado');
    }
}
