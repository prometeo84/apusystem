<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260408190000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create rate_limit_logs table if missing (idempotent)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE TABLE IF NOT EXISTS rate_limit_logs (
                id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                identifier VARCHAR(255) NOT NULL,
                endpoint VARCHAR(255) NOT NULL,
                attempts INT DEFAULT 1,
                window_start DATETIME DEFAULT CURRENT_TIMESTAMP,
                window_end DATETIME NOT NULL,
                exceeded_at DATETIME DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id),
                INDEX idx_identifier_endpoint (identifier, endpoint, window_end),
                INDEX idx_window_end (window_end)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS rate_limit_logs');
    }
}
