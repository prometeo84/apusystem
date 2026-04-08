<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260408120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add estado column to projects table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('projects');
        if (! $table->hasColumn('estado')) {
            $table->addColumn('estado', 'string', ['length' => 50, 'notnull' => true, 'default' => 'planificacion']);
        }
    }

    public function down(Schema $schema): void
    {
        if ($schema->hasTable('projects')) {
            $table = $schema->getTable('projects');
            if ($table->hasColumn('estado')) {
                $table->dropColumn('estado');
            }
        }
    }
}
