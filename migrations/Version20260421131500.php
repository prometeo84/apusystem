<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260421131500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique indexes on users.email and users.username to avoid duplicates';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_users_email ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_users_username ON users (username)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_users_email ON users');
        $this->addSql('DROP INDEX UNIQ_users_username ON users');
    }
}
