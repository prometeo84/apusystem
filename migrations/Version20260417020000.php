<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417020000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename apu_labor columns from Spanish to English';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE apu_labor RENAME COLUMN numero TO quantity");
        $this->addSql("ALTER TABLE apu_labor RENAME COLUMN jor_hora TO work_hours");
        $this->addSql("ALTER TABLE apu_labor RENAME COLUMN c_hora TO cost_per_hour");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE apu_labor RENAME COLUMN quantity TO numero");
        $this->addSql("ALTER TABLE apu_labor RENAME COLUMN work_hours TO jor_hora");
        $this->addSql("ALTER TABLE apu_labor RENAME COLUMN cost_per_hour TO c_hora");
    }
}
