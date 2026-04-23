<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260423010000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Normalize numeric column ALTERs to MySQL-compatible MODIFY syntax to avoid Postgres TYPE usage.';
    }

    public function up(Schema $schema): void
    {
        // labors
        $this->addSql('ALTER TABLE labors MODIFY number_a DECIMAL(14,4) NULL');
        $this->addSql('ALTER TABLE labors MODIFY jor_hour_b DECIMAL(14,4) NULL');
        $this->addSql('ALTER TABLE labors MODIFY rend_r DECIMAL(14,4) NULL');
        $this->addSql('ALTER TABLE labors MODIFY cost_hour_c DECIMAL(14,4) NULL');
        $this->addSql('ALTER TABLE labors MODIFY cost_total_d DECIMAL(14,4) NULL');

        // apu_materials
        $this->addSql('ALTER TABLE apu_materials MODIFY quantity DECIMAL(14,4) NOT NULL');
        $this->addSql('ALTER TABLE apu_materials MODIFY unit_price DECIMAL(14,4) NOT NULL');
        $this->addSql('ALTER TABLE apu_materials MODIFY cost_total DECIMAL(14,4) NULL');

        // apu_labor
        $this->addSql('ALTER TABLE apu_labor MODIFY cost_total DECIMAL(14,4) NULL');

        // apu_equipment
        $this->addSql('ALTER TABLE apu_equipment MODIFY cost_total DECIMAL(14,4) NULL');
    }

    public function down(Schema $schema): void
    {
        // no-op down; leave types as-is
    }
}
