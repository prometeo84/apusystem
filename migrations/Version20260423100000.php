<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260423100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'APU structural fixes: apu_labor work_hours->jor_hour_b + rendimiento_uh; apu_equipment work_hours->rendimiento_uh; apu_transport add cost_total+transport_id+context FKs; apu_items add calculation_price';
    }

    public function up(Schema $schema): void
    {
        // --- apu_labor ---
        // Rename work_hours -> jor_hour_b (semantic: it was storing the hourly wage, not worked hours)
        $this->addSql('ALTER TABLE apu_labor CHANGE work_hours jor_hour_b DECIMAL(14,4) NOT NULL COMMENT "JOR/HORA — tarifa base del trabajador (B)"');
        // Add rendimiento_uh (R) — how many units per hour this worker produces
        $this->addSql('ALTER TABLE apu_labor ADD rendimiento_uh DECIMAL(14,4) NULL COMMENT "R — Rendimiento u/h (unidades por hora)" AFTER cost_per_hour');
        // cost_per_hour will now store C = number * jor_hour_b
        // cost_total already exists (D = C * rendimiento_uh)

        // --- apu_equipment ---
        // Rename work_hours -> rendimiento_uh (semantic: it stores how many units/hour the equipment produces)
        $this->addSql('ALTER TABLE apu_equipment CHANGE work_hours rendimiento_uh DECIMAL(10,4) NULL COMMENT "R — Rendimiento u/h del equipo"');
        // cost_per_hour already stores C = number * rate
        // cost_total already exists (D = C * rendimiento_uh)

        // --- apu_transport ---
        $this->addSql('ALTER TABLE apu_transport ADD cost_total DECIMAL(14,4) NULL COMMENT "Costo total = cantidad × dmt × tarifa_km"');
        $this->addSql('ALTER TABLE apu_transport ADD transport_id BIGINT UNSIGNED NULL COMMENT "FK catálogo transports"');
        $this->addSql('ALTER TABLE apu_transport ADD tenant_id BIGINT UNSIGNED NULL');
        $this->addSql('ALTER TABLE apu_transport ADD project_id BIGINT UNSIGNED NULL');
        $this->addSql('ALTER TABLE apu_transport ADD template_id BIGINT UNSIGNED NULL');
        $this->addSql('ALTER TABLE apu_transport ADD template_item_id BIGINT UNSIGNED NULL');
        $this->addSql('ALTER TABLE apu_transport ADD CONSTRAINT FK_APU_TRANS_TRANSPORT FOREIGN KEY (transport_id) REFERENCES transports (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE apu_transport ADD CONSTRAINT FK_APU_TRANS_TENANT FOREIGN KEY (tenant_id) REFERENCES tenants (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE apu_transport ADD CONSTRAINT FK_APU_TRANS_PROJECT FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE apu_transport ADD CONSTRAINT FK_APU_TRANS_TEMPLATE FOREIGN KEY (template_id) REFERENCES templates (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE apu_transport ADD CONSTRAINT FK_APU_TRANS_TEMPLATE_ITEM FOREIGN KEY (template_item_id) REFERENCES template_items (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_APU_TRANS_TRANSPORT ON apu_transport (transport_id)');
        $this->addSql('CREATE INDEX IDX_APU_TRANS_TENANT ON apu_transport (tenant_id)');
        $this->addSql('CREATE INDEX IDX_APU_TRANS_PROJECT ON apu_transport (project_id)');
        $this->addSql('CREATE INDEX IDX_APU_TRANS_TEMPLATE ON apu_transport (template_id)');
        $this->addSql('CREATE INDEX IDX_APU_TRANS_TEMPLATE_ITEM ON apu_transport (template_item_id)');

        // --- apu_items ---
        $this->addSql('ALTER TABLE apu_items ADD calculation_price DECIMAL(15,2) NULL COMMENT "total_cost × (1 + profit_pct/100)" AFTER total_cost');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE apu_items DROP COLUMN calculation_price');

        $this->addSql('ALTER TABLE apu_transport DROP FOREIGN KEY FK_APU_TRANS_TRANSPORT');
        $this->addSql('ALTER TABLE apu_transport DROP FOREIGN KEY FK_APU_TRANS_TENANT');
        $this->addSql('ALTER TABLE apu_transport DROP FOREIGN KEY FK_APU_TRANS_PROJECT');
        $this->addSql('ALTER TABLE apu_transport DROP FOREIGN KEY FK_APU_TRANS_TEMPLATE');
        $this->addSql('ALTER TABLE apu_transport DROP FOREIGN KEY FK_APU_TRANS_TEMPLATE_ITEM');
        $this->addSql('DROP INDEX IDX_APU_TRANS_TRANSPORT ON apu_transport');
        $this->addSql('DROP INDEX IDX_APU_TRANS_TENANT ON apu_transport');
        $this->addSql('DROP INDEX IDX_APU_TRANS_PROJECT ON apu_transport');
        $this->addSql('DROP INDEX IDX_APU_TRANS_TEMPLATE ON apu_transport');
        $this->addSql('DROP INDEX IDX_APU_TRANS_TEMPLATE_ITEM ON apu_transport');
        $this->addSql('ALTER TABLE apu_transport DROP COLUMN cost_total, DROP COLUMN transport_id, DROP COLUMN tenant_id, DROP COLUMN project_id, DROP COLUMN template_id, DROP COLUMN template_item_id');

        $this->addSql('ALTER TABLE apu_equipment CHANGE rendimiento_uh work_hours DECIMAL(10,4) NULL');
        $this->addSql('ALTER TABLE apu_labor DROP COLUMN rendimiento_uh');
        $this->addSql('ALTER TABLE apu_labor CHANGE jor_hour_b work_hours DECIMAL(14,4) NOT NULL');
    }
}
