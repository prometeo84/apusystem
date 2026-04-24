<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260424172348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apu_rubros (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, equipment_cost NUMERIC(15, 2) DEFAULT NULL, labor_cost NUMERIC(15, 2) DEFAULT NULL, material_cost NUMERIC(15, 2) DEFAULT NULL, transport_cost NUMERIC(15, 2) DEFAULT NULL, total_cost NUMERIC(15, 2) DEFAULT NULL, created_at DATETIME NOT NULL, apu_item_id BIGINT UNSIGNED NOT NULL, item_id BIGINT UNSIGNED DEFAULT NULL, INDEX IDX_86CAD56AB5A5975C (apu_item_id), INDEX IDX_86CAD56A126F525E (item_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE apu_rubros ADD CONSTRAINT FK_86CAD56AB5A5975C FOREIGN KEY (apu_item_id) REFERENCES apu_items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apu_rubros ADD CONSTRAINT FK_86CAD56A126F525E FOREIGN KEY (item_id) REFERENCES items (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE apu_equipment ADD apu_rubro_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_equipment ADD CONSTRAINT FK_A0026F4E7C5FB68 FOREIGN KEY (apu_rubro_id) REFERENCES apu_rubros (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_A0026F4E7C5FB68 ON apu_equipment (apu_rubro_id)');
        $this->addSql('ALTER TABLE apu_items ADD indirect_cost_pct NUMERIC(5, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_labor ADD apu_rubro_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_labor ADD CONSTRAINT FK_8AAC276BE7C5FB68 FOREIGN KEY (apu_rubro_id) REFERENCES apu_rubros (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_8AAC276BE7C5FB68 ON apu_labor (apu_rubro_id)');
        $this->addSql('ALTER TABLE apu_materials ADD apu_rubro_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_materials ADD CONSTRAINT FK_422FE5C2E7C5FB68 FOREIGN KEY (apu_rubro_id) REFERENCES apu_rubros (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_422FE5C2E7C5FB68 ON apu_materials (apu_rubro_id)');
        $this->addSql('ALTER TABLE apu_transport ADD apu_rubro_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_transport ADD CONSTRAINT FK_BF93D259E7C5FB68 FOREIGN KEY (apu_rubro_id) REFERENCES apu_rubros (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_BF93D259E7C5FB68 ON apu_transport (apu_rubro_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apu_rubros DROP FOREIGN KEY FK_86CAD56AB5A5975C');
        $this->addSql('ALTER TABLE apu_rubros DROP FOREIGN KEY FK_86CAD56A126F525E');
        $this->addSql('DROP TABLE apu_rubros');
        $this->addSql('ALTER TABLE apu_equipment DROP FOREIGN KEY FK_A0026F4E7C5FB68');
        $this->addSql('DROP INDEX IDX_A0026F4E7C5FB68 ON apu_equipment');
        $this->addSql('ALTER TABLE apu_equipment DROP apu_rubro_id');
        $this->addSql('ALTER TABLE apu_items DROP indirect_cost_pct');
        $this->addSql('ALTER TABLE apu_labor DROP FOREIGN KEY FK_8AAC276BE7C5FB68');
        $this->addSql('DROP INDEX IDX_8AAC276BE7C5FB68 ON apu_labor');
        $this->addSql('ALTER TABLE apu_labor DROP apu_rubro_id');
        $this->addSql('ALTER TABLE apu_materials DROP FOREIGN KEY FK_422FE5C2E7C5FB68');
        $this->addSql('DROP INDEX IDX_422FE5C2E7C5FB68 ON apu_materials');
        $this->addSql('ALTER TABLE apu_materials DROP apu_rubro_id');
        $this->addSql('ALTER TABLE apu_transport DROP FOREIGN KEY FK_BF93D259E7C5FB68');
        $this->addSql('DROP INDEX IDX_BF93D259E7C5FB68 ON apu_transport');
        $this->addSql('ALTER TABLE apu_transport DROP apu_rubro_id');
    }
}
