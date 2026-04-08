<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408182510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rate_limit_logs');
        $this->addSql('ALTER TABLE apu CHANGE proyecto_id proyecto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projects DROP client_contact, DROP currency, DROP created_by, DROP estado, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE code code VARCHAR(100) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(50) NOT NULL, CHANGE total_budget total_budget NUMERIC(15, 2) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A49033212A FOREIGN KEY (tenant_id) REFERENCES tenants (id)');
        $this->addSql('CREATE INDEX IDX_5C93B3A49033212A ON projects (tenant_id)');
        $this->addSql('ALTER TABLE recovery_codes CHANGE code_hash code_hash VARCHAR(255) NOT NULL, CHANGE used_at used_at DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_93F26D7B_STATUS ON revit_files');
        $this->addSql('DROP INDEX IDX_93F26D7B_TYPE ON revit_files');
        $this->addSql('ALTER TABLE revit_files CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE file_size file_size INT NOT NULL, CHANGE error_message error_message LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX idx_severity ON security_events');
        $this->addSql('ALTER TABLE security_events CHANGE severity severity VARCHAR(20) NOT NULL, CHANGE user_agent user_agent LONGTEXT DEFAULT NULL, CHANGE event_data event_data JSON DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE security_events RENAME INDEX idx_tenant_id TO IDX_6568A15F9033212A');
        $this->addSql('DROP INDEX idx_slug ON tenants');
        $this->addSql('DROP INDEX idx_is_active ON tenants');
        $this->addSql('ALTER TABLE tenants CHANGE uuid uuid VARCHAR(36) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(100) NOT NULL, CHANGE domain domain VARCHAR(255) DEFAULT NULL, CHANGE currency currency VARCHAR(3) NOT NULL, CHANGE is_active is_active TINYINT NOT NULL, CHANGE plan plan VARCHAR(50) NOT NULL, CHANGE max_users max_users INT NOT NULL, CHANGE max_projects max_projects INT NOT NULL, CHANGE plan_auto_renew plan_auto_renew TINYINT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tenants RENAME INDEX uuid TO UNIQ_B8FC96BBD17F50A6');
        $this->addSql('ALTER TABLE tenants RENAME INDEX slug TO UNIQ_B8FC96BB989D9B62');
        $this->addSql('ALTER TABLE user_2fa_settings CHANGE backup_codes_count backup_codes_count INT DEFAULT 0 NOT NULL, CHANGE recovery_codes_last_generated recovery_codes_last_generated DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user_2fa_settings RENAME INDEX user_id TO UNIQ_A8C3D0C8A76ED395');
        $this->addSql('DROP INDEX idx_email ON users');
        $this->addSql('DROP INDEX idx_role ON users');
        $this->addSql('DROP INDEX idx_tenant_active ON users');
        $this->addSql('DROP INDEX unique_email_per_tenant ON users');
        $this->addSql('DROP INDEX unique_username_per_tenant ON users');
        $this->addSql('ALTER TABLE users CHANGE uuid uuid VARCHAR(36) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE role role VARCHAR(20) NOT NULL, CHANGE is_active is_active TINYINT NOT NULL, CHANGE failed_login_attempts failed_login_attempts INT NOT NULL, CHANGE require_password_change require_password_change TINYINT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE locale locale VARCHAR(5) NOT NULL, CHANGE theme_primary_color theme_primary_color VARCHAR(7) DEFAULT NULL, CHANGE theme_secondary_color theme_secondary_color VARCHAR(7) DEFAULT NULL, CHANGE theme_mode theme_mode VARCHAR(10) NOT NULL, CHANGE totp_enabled totp_enabled TINYINT NOT NULL, CHANGE webauthn_enabled webauthn_enabled TINYINT NOT NULL');
        $this->addSql('ALTER TABLE users RENAME INDEX uuid TO UNIQ_1483A5E9D17F50A6');
        $this->addSql('ALTER TABLE webauthn_credentials RENAME INDEX idx_webauthn_user TO IDX_DFEA8490A76ED395');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rate_limit_logs (id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, identifier VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, endpoint VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, attempts INT DEFAULT 1, window_start DATETIME DEFAULT CURRENT_TIMESTAMP, window_end DATETIME NOT NULL, exceeded_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX idx_identifier_endpoint (identifier, endpoint, window_end), INDEX idx_window_end (window_end), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apu CHANGE proyecto_id proyecto_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A49033212A');
        $this->addSql('DROP INDEX IDX_5C93B3A49033212A ON projects');
        $this->addSql('ALTER TABLE projects ADD client_contact VARCHAR(255) DEFAULT NULL, ADD currency VARCHAR(3) DEFAULT \'COP\', ADD created_by BIGINT UNSIGNED NOT NULL, ADD estado VARCHAR(50) DEFAULT \'planificacion\' NOT NULL, CHANGE id id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE code code VARCHAR(50) NOT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE location location VARCHAR(500) DEFAULT NULL, CHANGE status status ENUM(\'draft\', \'active\', \'completed\', \'cancelled\') DEFAULT \'draft\', CHANGE total_budget total_budget NUMERIC(20, 2) DEFAULT \'0.00\', CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE recovery_codes CHANGE code_hash code_hash VARCHAR(255) NOT NULL COMMENT \'Hash del código de recuperación\', CHANGE used_at used_at DATETIME DEFAULT NULL COMMENT \'Fecha cuando fue usado\'');
        $this->addSql('ALTER TABLE revit_files CHANGE id id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE file_size file_size INT UNSIGNED NOT NULL, CHANGE error_message error_message TEXT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_93F26D7B_STATUS ON revit_files (status)');
        $this->addSql('CREATE INDEX IDX_93F26D7B_TYPE ON revit_files (file_type)');
        $this->addSql('ALTER TABLE security_events CHANGE severity severity ENUM(\'INFO\', \'WARNING\', \'CRITICAL\') DEFAULT \'INFO\', CHANGE user_agent user_agent TEXT DEFAULT NULL, CHANGE event_data event_data JSON DEFAULT NULL COMMENT \'Datos adicionales del evento\', CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('CREATE INDEX idx_severity ON security_events (severity)');
        $this->addSql('ALTER TABLE security_events RENAME INDEX idx_6568a15f9033212a TO idx_tenant_id');
        $this->addSql('ALTER TABLE tenants CHANGE uuid uuid CHAR(36) NOT NULL COMMENT \'UUID Ãºnico del tenant\', CHANGE name name VARCHAR(255) NOT NULL COMMENT \'Nombre de la empresa\', CHANGE slug slug VARCHAR(100) NOT NULL COMMENT \'Identificador URL-friendly\', CHANGE domain domain VARCHAR(255) DEFAULT NULL COMMENT \'Dominio personalizado (opcional)\', CHANGE currency currency VARCHAR(3) DEFAULT \'COP\', CHANGE is_active is_active TINYINT DEFAULT 1, CHANGE plan plan VARCHAR(50) DEFAULT \'basic\' COMMENT \'basic, professional, enterprise\', CHANGE max_users max_users INT DEFAULT 5, CHANGE max_projects max_projects INT DEFAULT 10, CHANGE plan_auto_renew plan_auto_renew TINYINT DEFAULT 0, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('CREATE INDEX idx_slug ON tenants (slug)');
        $this->addSql('CREATE INDEX idx_is_active ON tenants (is_active)');
        $this->addSql('ALTER TABLE tenants RENAME INDEX uniq_b8fc96bb989d9b62 TO slug');
        $this->addSql('ALTER TABLE tenants RENAME INDEX uniq_b8fc96bbd17f50a6 TO uuid');
        $this->addSql('ALTER TABLE user_2fa_settings CHANGE backup_codes_count backup_codes_count INT DEFAULT 0 COMMENT \'Cantidad de códigos de respaldo disponibles\', CHANGE recovery_codes_last_generated recovery_codes_last_generated DATETIME DEFAULT NULL COMMENT \'Última vez que se generaron códigos\'');
        $this->addSql('ALTER TABLE user_2fa_settings RENAME INDEX uniq_a8c3d0c8a76ed395 TO user_id');
        $this->addSql('ALTER TABLE users CHANGE uuid uuid CHAR(36) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL COMMENT \'Hasheado con bcrypt\', CHANGE role role ENUM(\'super_admin\', \'admin\', \'manager\', \'user\') DEFAULT \'user\', CHANGE is_active is_active TINYINT DEFAULT 1, CHANGE failed_login_attempts failed_login_attempts INT DEFAULT 0, CHANGE require_password_change require_password_change TINYINT DEFAULT 0, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE totp_enabled totp_enabled TINYINT DEFAULT 0 NOT NULL, CHANGE webauthn_enabled webauthn_enabled TINYINT DEFAULT 0 NOT NULL, CHANGE locale locale VARCHAR(5) DEFAULT \'es\', CHANGE theme_primary_color theme_primary_color VARCHAR(7) DEFAULT \'#667eea\', CHANGE theme_secondary_color theme_secondary_color VARCHAR(7) DEFAULT \'#764ba2\', CHANGE theme_mode theme_mode VARCHAR(10) DEFAULT \'light\'');
        $this->addSql('CREATE INDEX idx_email ON users (email)');
        $this->addSql('CREATE INDEX idx_role ON users (role)');
        $this->addSql('CREATE INDEX idx_tenant_active ON users (tenant_id, is_active)');
        $this->addSql('CREATE UNIQUE INDEX unique_email_per_tenant ON users (tenant_id, email)');
        $this->addSql('CREATE UNIQUE INDEX unique_username_per_tenant ON users (tenant_id, username)');
        $this->addSql('ALTER TABLE users RENAME INDEX uniq_1483a5e9d17f50a6 TO uuid');
        $this->addSql('ALTER TABLE webauthn_credentials RENAME INDEX idx_dfea8490a76ed395 TO idx_webauthn_user');
    }
}
