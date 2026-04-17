<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417010000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename apu_equipment columns from Spanish to English';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE apu_equipment RENAME COLUMN numero TO quantity");
        $this->addSql("ALTER TABLE apu_equipment RENAME COLUMN tarifa TO rate");
        $this->addSql("ALTER TABLE apu_equipment RENAME COLUMN c_hora TO cost_per_hour");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE apu_equipment RENAME COLUMN quantity TO numero");
        $this->addSql("ALTER TABLE apu_equipment RENAME COLUMN rate TO tarifa");
        $this->addSql("ALTER TABLE apu_equipment RENAME COLUMN cost_per_hour TO c_hora");
    }
}
