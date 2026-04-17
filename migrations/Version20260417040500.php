<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417040500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename items table columns from Spanish to English (safe migration)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE items RENAME COLUMN nombre TO name");
        $this->addSql("ALTER TABLE items RENAME COLUMN tipo TO type");
        $this->addSql("ALTER TABLE items RENAME COLUMN activo TO active");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE items RENAME COLUMN name TO nombre");
        $this->addSql("ALTER TABLE items RENAME COLUMN type TO tipo");
        $this->addSql("ALTER TABLE items RENAME COLUMN active TO activo");
    }
}
