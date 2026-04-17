<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417041000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename templates table columns from Spanish to English';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE templates RENAME COLUMN nombre TO name");
        $this->addSql("ALTER TABLE templates RENAME COLUMN activa TO active");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE templates RENAME COLUMN name TO nombre");
        $this->addSql("ALTER TABLE templates RENAME COLUMN active TO activa");
    }
}
