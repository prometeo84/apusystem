<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417043000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename apu_items columns from Spanish to English';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE apu_items RENAME COLUMN rendimiento_uh TO productivity_uh");
        $this->addSql("ALTER TABLE apu_items RENAME COLUMN utilidad_pct TO profit_pct");
        $this->addSql("ALTER TABLE apu_items RENAME COLUMN precio_ofertado TO offered_price");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE apu_items RENAME COLUMN productivity_uh TO rendimiento_uh");
        $this->addSql("ALTER TABLE apu_items RENAME COLUMN profit_pct TO utilidad_pct");
        $this->addSql("ALTER TABLE apu_items RENAME COLUMN offered_price TO precio_ofertado");
    }
}
