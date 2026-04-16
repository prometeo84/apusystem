<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260416000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create remember_me_tokens table for persistent remember-me tokens';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE TABLE IF NOT EXISTS remember_me_tokens (
                id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                user_id BIGINT UNSIGNED NOT NULL,
                series VARCHAR(88) NOT NULL,
                token_value VARCHAR(88) NOT NULL,
                last_used DATETIME NOT NULL,
                ip_address VARCHAR(45) DEFAULT NULL,
                user_agent TEXT DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id),
                UNIQUE INDEX uniq_series (series),
                INDEX idx_user_last_used (user_id, last_used),
                CONSTRAINT fk_rm_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS remember_me_tokens');
    }
}
