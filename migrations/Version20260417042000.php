<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417042000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename template_items columns from Spanish to English';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE template_items RENAME COLUMN cantidad TO quantity");
        $this->addSql("ALTER TABLE template_items RENAME COLUMN orden TO `order`");
        $this->addSql("ALTER TABLE template_items RENAME COLUMN plantilla_id TO template_id");
        $this->addSql("ALTER TABLE template_items RENAME COLUMN rubro_id TO item_id");
        $this->addSql("ALTER TABLE template_items RENAME COLUMN apu_item_id TO apu_item_id");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE template_items RENAME COLUMN quantity TO cantidad");
        $this->addSql("ALTER TABLE template_items RENAME COLUMN `order` TO orden");
        $this->addSql("ALTER TABLE template_items RENAME COLUMN template_id TO plantilla_id");
        $this->addSql("ALTER TABLE template_items RENAME COLUMN item_id TO rubro_id");
        $this->addSql("ALTER TABLE template_items RENAME COLUMN apu_item_id TO apu_item_id");
    }
}
