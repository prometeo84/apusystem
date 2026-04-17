<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417030000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename apu_transport columns from Spanish to English';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE apu_transport RENAME COLUMN dmt TO avg_distance");
        $this->addSql("ALTER TABLE apu_transport RENAME COLUMN tarifa_km TO rate_per_km");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE apu_transport RENAME COLUMN avg_distance TO dmt");
        $this->addSql("ALTER TABLE apu_transport RENAME COLUMN rate_per_km TO tarifa_km");
    }
}
