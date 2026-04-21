<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260421190000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add created_by to projects, templates, apu_items, items and project_id to items';
    }

    public function up(Schema $schema): void
    {
        // projects
        $this->addSql('ALTER TABLE projects ADD created_by BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_projects_created_by FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL');

        // templates
        $this->addSql('ALTER TABLE templates ADD created_by BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE templates ADD CONSTRAINT FK_templates_created_by FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL');

        // apu_items
        $this->addSql('ALTER TABLE apu_items ADD created_by BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_items ADD CONSTRAINT FK_apu_items_created_by FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL');

        // items: project_id + created_by
        $this->addSql('ALTER TABLE items ADD project_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE items ADD created_by BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_items_project FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_items_created_by FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // items
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_items_project');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_items_created_by');
        $this->addSql('ALTER TABLE items DROP COLUMN project_id');
        $this->addSql('ALTER TABLE items DROP COLUMN created_by');

        // apu_items
        $this->addSql('ALTER TABLE apu_items DROP FOREIGN KEY FK_apu_items_created_by');
        $this->addSql('ALTER TABLE apu_items DROP COLUMN created_by');

        // templates
        $this->addSql('ALTER TABLE templates DROP FOREIGN KEY FK_templates_created_by');
        $this->addSql('ALTER TABLE templates DROP COLUMN created_by');

        // projects
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_projects_created_by');
        $this->addSql('ALTER TABLE projects DROP COLUMN created_by');
    }
}
