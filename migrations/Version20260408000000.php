<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260408000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table webauthn_credentials';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('webauthn_credentials');
        $table->addColumn('id', 'bigint', ['unsigned' => true, 'autoincrement' => true]);
        $table->addColumn('user_id', 'bigint', ['unsigned' => true]);
        $table->addColumn('credential_id', 'string', ['length' => 255]);
        $table->addColumn('public_key', 'text');
        $table->addColumn('fmt', 'string', ['length' => 50, 'notnull' => false]);
        $table->addColumn('aaguid', 'string', ['length' => 64, 'notnull' => false]);
        $table->addColumn('transports', 'text', ['notnull' => false]);
        $table->addColumn('attestation', 'text', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime');
        $table->setPrimaryKey(['id']);
        $table->addIndex(['user_id'], 'idx_webauthn_user');
        $table->addForeignKeyConstraint('users', ['user_id'], ['id'], ['onDelete' => 'CASCADE']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('webauthn_credentials');
    }
}
