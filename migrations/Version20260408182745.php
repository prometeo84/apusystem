<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408182745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Minimal, safe migration: align apu.proyecto_id with projects.id
        $this->addSql('ALTER TABLE apu CHANGE proyecto_id proyecto_id BIGINT UNSIGNED DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // Minimal down: revert apu.proyecto_id to INT (if needed)
        $this->addSql('ALTER TABLE apu CHANGE proyecto_id proyecto_id INT DEFAULT NULL');
    }
}
