<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration para tablas de 2FA: recovery_codes y user_2fa_settings
 */
final class Version20260319220000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Crea tablas para recovery codes y configuración 2FA';
    }

    public function up(Schema $schema): void
    {
        // Tabla recovery_codes para códigos de recuperación 2FA
        $this->addSql('
            CREATE TABLE recovery_codes (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                code_hash VARCHAR(255) NOT NULL COMMENT "Hash del código de recuperación",
                used_at DATETIME DEFAULT NULL COMMENT "Fecha cuando fue usado",
                created_at DATETIME NOT NULL,
                INDEX idx_user_unused (user_id, used_at),
                CONSTRAINT fk_recovery_codes_user
                    FOREIGN KEY (user_id) REFERENCES users(id)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ');

        // Tabla user_2fa_settings para configuración de 2FA por usuario
        $this->addSql('
            CREATE TABLE user_2fa_settings (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL UNIQUE,
                backup_codes_count INT DEFAULT 0 COMMENT "Cantidad de códigos de respaldo disponibles",
                recovery_codes_last_generated DATETIME DEFAULT NULL COMMENT "Última vez que se generaron códigos",
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                CONSTRAINT fk_user_2fa_settings_user
                    FOREIGN KEY (user_id) REFERENCES users(id)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS user_2fa_settings');
        $this->addSql('DROP TABLE IF EXISTS recovery_codes');
    }
}
