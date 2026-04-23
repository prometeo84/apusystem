<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260423193303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apu_equipment CHANGE cost_per_hour cost_per_hour NUMERIC(14, 4) NOT NULL, CHANGE rendimiento_uh rendimiento_uh NUMERIC(10, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_apu_equip_tenant TO IDX_A0026F49033212A');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_apu_equip_project TO IDX_A0026F4166D1F9C');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_apu_equip_template TO IDX_A0026F45DA0FB8');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_apu_equip_template_item TO IDX_A0026F441D72967');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_apu_equip_equipment TO IDX_A0026F4517FE9FE');
        $this->addSql('ALTER TABLE apu_items CHANGE calculation_price calculation_price NUMERIC(15, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_labor CHANGE jor_hour_b jor_hour_b NUMERIC(14, 4) NOT NULL, CHANGE cost_per_hour cost_per_hour NUMERIC(14, 4) NOT NULL, CHANGE rendimiento_uh rendimiento_uh NUMERIC(14, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_apu_labor_tenant TO IDX_8AAC276B9033212A');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_apu_labor_project TO IDX_8AAC276B166D1F9C');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_apu_labor_template TO IDX_8AAC276B5DA0FB8');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_apu_labor_template_item TO IDX_8AAC276B41D72967');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_apu_labor_labor TO IDX_8AAC276BC9CF1734');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX idx_apu_materials_tenant TO IDX_422FE5C29033212A');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX idx_apu_materials_project TO IDX_422FE5C2166D1F9C');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX idx_apu_materials_template TO IDX_422FE5C25DA0FB8');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX idx_apu_materials_template_item TO IDX_422FE5C241D72967');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX fk_apu_materials_material TO IDX_422FE5C2E308AC6F');
        $this->addSql('ALTER TABLE apu_transport CHANGE cost_total cost_total NUMERIC(14, 4) DEFAULT NULL, CHANGE transport_id transport_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_apu_trans_transport TO IDX_BF93D2599909C13F');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_apu_trans_tenant TO IDX_BF93D2599033212A');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_apu_trans_project TO IDX_BF93D259166D1F9C');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_apu_trans_template TO IDX_BF93D2595DA0FB8');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_apu_trans_template_item TO IDX_BF93D25941D72967');
        $this->addSql('ALTER TABLE equipments ADD project_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE equipments ADD CONSTRAINT FK_6F6C2544166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6F6C2544166D1F9C ON equipments (project_id)');
        $this->addSql('ALTER TABLE labors ADD project_id BIGINT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE labors ADD CONSTRAINT FK_6C07B818166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6C07B818166D1F9C ON labors (project_id)');
        $this->addSql('ALTER TABLE materials RENAME INDEX fk_materials_project TO IDX_9B1716B5166D1F9C');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY `FK_5C93B3A49033212A`');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A49033212A FOREIGN KEY (tenant_id) REFERENCES tenants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transports RENAME INDEX fk_transports_project TO IDX_C7BE69E5166D1F9C');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apu_equipment CHANGE cost_per_hour cost_per_hour NUMERIC(10, 4) NOT NULL, CHANGE rendimiento_uh rendimiento_uh NUMERIC(10, 4) DEFAULT NULL COMMENT \'R — Rendimiento u/h del equipo\'');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_a0026f49033212a TO IDX_APU_EQUIP_TENANT');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_a0026f4166d1f9c TO IDX_APU_EQUIP_PROJECT');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_a0026f45da0fb8 TO IDX_APU_EQUIP_TEMPLATE');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_a0026f441d72967 TO IDX_APU_EQUIP_TEMPLATE_ITEM');
        $this->addSql('ALTER TABLE apu_equipment RENAME INDEX idx_a0026f4517fe9fe TO IDX_APU_EQUIP_EQUIPMENT');
        $this->addSql('ALTER TABLE apu_items CHANGE calculation_price calculation_price NUMERIC(15, 2) DEFAULT NULL COMMENT \'total_cost × (1 + profit_pct/100)\'');
        $this->addSql('ALTER TABLE apu_labor CHANGE jor_hour_b jor_hour_b NUMERIC(14, 4) NOT NULL COMMENT \'JOR/HORA — tarifa base del trabajador (B)\', CHANGE cost_per_hour cost_per_hour NUMERIC(10, 2) NOT NULL, CHANGE rendimiento_uh rendimiento_uh NUMERIC(14, 4) DEFAULT NULL COMMENT \'R — Rendimiento u/h (unidades por hora)\'');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_8aac276b9033212a TO IDX_APU_LABOR_TENANT');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_8aac276b166d1f9c TO IDX_APU_LABOR_PROJECT');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_8aac276b5da0fb8 TO IDX_APU_LABOR_TEMPLATE');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_8aac276b41d72967 TO IDX_APU_LABOR_TEMPLATE_ITEM');
        $this->addSql('ALTER TABLE apu_labor RENAME INDEX idx_8aac276bc9cf1734 TO IDX_APU_LABOR_LABOR');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX idx_422fe5c2e308ac6f TO FK_APU_MATERIALS_MATERIAL');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX idx_422fe5c29033212a TO IDX_APU_MATERIALS_TENANT');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX idx_422fe5c2166d1f9c TO IDX_APU_MATERIALS_PROJECT');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX idx_422fe5c25da0fb8 TO IDX_APU_MATERIALS_TEMPLATE');
        $this->addSql('ALTER TABLE apu_materials RENAME INDEX idx_422fe5c241d72967 TO IDX_APU_MATERIALS_TEMPLATE_ITEM');
        $this->addSql('ALTER TABLE apu_transport CHANGE cost_total cost_total NUMERIC(14, 4) DEFAULT NULL COMMENT \'Costo total = cantidad × dmt × tarifa_km\', CHANGE transport_id transport_id BIGINT UNSIGNED DEFAULT NULL COMMENT \'FK catálogo transports\'');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_bf93d2599909c13f TO IDX_APU_TRANS_TRANSPORT');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_bf93d2599033212a TO IDX_APU_TRANS_TENANT');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_bf93d259166d1f9c TO IDX_APU_TRANS_PROJECT');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_bf93d2595da0fb8 TO IDX_APU_TRANS_TEMPLATE');
        $this->addSql('ALTER TABLE apu_transport RENAME INDEX idx_bf93d25941d72967 TO IDX_APU_TRANS_TEMPLATE_ITEM');
        $this->addSql('ALTER TABLE equipments DROP FOREIGN KEY FK_6F6C2544166D1F9C');
        $this->addSql('DROP INDEX IDX_6F6C2544166D1F9C ON equipments');
        $this->addSql('ALTER TABLE equipments DROP project_id');
        $this->addSql('ALTER TABLE labors DROP FOREIGN KEY FK_6C07B818166D1F9C');
        $this->addSql('DROP INDEX IDX_6C07B818166D1F9C ON labors');
        $this->addSql('ALTER TABLE labors DROP project_id');
        $this->addSql('ALTER TABLE materials RENAME INDEX idx_9b1716b5166d1f9c TO fk_materials_project');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A49033212A');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT `FK_5C93B3A49033212A` FOREIGN KEY (tenant_id) REFERENCES tenants (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE transports RENAME INDEX idx_c7be69e5166d1f9c TO fk_transports_project');
    }
}
