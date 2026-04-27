<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Crea la tabla 'sessions' para el PdoSessionHandler de Symfony.
 * Necesaria en InfinityFree para almacenar sesiones en base de datos
 * (el filesystem compartido no persiste sesiones entre workers).
 */
final class Version20260427000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add sessions table for PdoSessionHandler';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS `sessions` (
            `sess_id` VARBINARY(128) NOT NULL,
            `sess_data` MEDIUMBLOB NOT NULL,
            `sess_lifetime` INTEGER UNSIGNED NOT NULL,
            `sess_time` INTEGER UNSIGNED NOT NULL,
            PRIMARY KEY (`sess_id`)
        ) COLLATE utf8mb4_bin ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `sessions`');
    }
}
