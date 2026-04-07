<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260407000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add tenant-level theme fields (primary/secondary colors and mode) to tenants table';
    }

    public function up(Schema $schema): void
    {
        // Add nullable columns and populate defaults for existing tenants
        $this->addSql("ALTER TABLE tenants ADD COLUMN theme_primary_color VARCHAR(7) DEFAULT NULL");
        $this->addSql("ALTER TABLE tenants ADD COLUMN theme_secondary_color VARCHAR(7) DEFAULT NULL");
        $this->addSql("ALTER TABLE tenants ADD COLUMN theme_mode VARCHAR(10) DEFAULT NULL");

        // Set sensible defaults for existing rows
        $this->addSql("UPDATE tenants SET theme_primary_color = '#667eea' WHERE theme_primary_color IS NULL");
        $this->addSql("UPDATE tenants SET theme_secondary_color = '#764ba2' WHERE theme_secondary_color IS NULL");
        $this->addSql("UPDATE tenants SET theme_mode = 'light' WHERE theme_mode IS NULL");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tenants DROP COLUMN IF EXISTS theme_primary_color');
        $this->addSql('ALTER TABLE tenants DROP COLUMN IF EXISTS theme_secondary_color');
        $this->addSql('ALTER TABLE tenants DROP COLUMN IF EXISTS theme_mode');
    }
}
