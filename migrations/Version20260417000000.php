<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename apu table columns from Spanish to English';
    }

    public function up(Schema $schema): void
    {
        // Rename columns to English names
        $this->addSql("ALTER TABLE apu RENAME COLUMN proyecto_id TO project_id");
        $this->addSql("ALTER TABLE apu RENAME COLUMN codigo TO code");
        $this->addSql("ALTER TABLE apu RENAME COLUMN descripcion TO description");
        $this->addSql("ALTER TABLE apu RENAME COLUMN unidad TO unit");
        $this->addSql("ALTER TABLE apu RENAME COLUMN cantidad TO quantity");
        $this->addSql("ALTER TABLE apu RENAME COLUMN rendimiento TO yield");
        $this->addSql("ALTER TABLE apu RENAME COLUMN costo_unitario TO unit_cost");
        $this->addSql("ALTER TABLE apu RENAME COLUMN costo_total TO total_cost");
    }

    public function down(Schema $schema): void
    {
        // Revert column names to Spanish
        $this->addSql("ALTER TABLE apu RENAME COLUMN project_id TO proyecto_id");
        $this->addSql("ALTER TABLE apu RENAME COLUMN code TO codigo");
        $this->addSql("ALTER TABLE apu RENAME COLUMN description TO descripcion");
        $this->addSql("ALTER TABLE apu RENAME COLUMN unit TO unidad");
        $this->addSql("ALTER TABLE apu RENAME COLUMN quantity TO cantidad");
        $this->addSql("ALTER TABLE apu RENAME COLUMN yield TO rendimiento");
        $this->addSql("ALTER TABLE apu RENAME COLUMN unit_cost TO costo_unitario");
        $this->addSql("ALTER TABLE apu RENAME COLUMN total_cost TO costo_total");
    }
}
