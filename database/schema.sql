-- ============================================================
-- SISTEMA APU MULTI-TENANT
-- Base de datos MySQL 8.0+
-- Análisis de Precios Unitarios con Multi-Tenancy
-- ============================================================
-- Eliminar base de datos si existe (¡CUIDADO EN PRODUCCIÓN!)
-- DROP DATABASE IF EXISTS apu_system;
-- Crear base de datos
CREATE DATABASE IF NOT EXISTS apu_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE apu_system;
-- ============================================================
-- TABLAS DE TENANTS (MULTI-EMPRESA)
-- ============================================================
CREATE TABLE tenants (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE COMMENT 'UUID único del tenant',
    name VARCHAR(255) NOT NULL COMMENT 'Nombre de la empresa',
    slug VARCHAR(100) NOT NULL UNIQUE COMMENT 'Identificador URL-friendly',
    domain VARCHAR(255) NULL COMMENT 'Dominio personalizado (opcional)',
    logo_url VARCHAR(500) NULL,
    timezone VARCHAR(50) DEFAULT 'America/Bogota',
    currency VARCHAR(3) DEFAULT 'COP',
    is_active BOOLEAN DEFAULT TRUE,
    plan VARCHAR(50) DEFAULT 'basic' COMMENT 'basic, professional, enterprise',
    max_users INT DEFAULT 5,
    max_projects INT DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_is_active (is_active)
) ENGINE = InnoDB;
-- ============================================================
-- TABLAS DE USUARIOS Y AUTENTICACIÓN
-- ============================================================
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    uuid CHAR(36) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL COMMENT 'Hasheado con bcrypt',
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    role ENUM('super_admin', 'admin', 'manager', 'user') DEFAULT 'user',
    is_active BOOLEAN DEFAULT TRUE,
    email_verified_at TIMESTAMP NULL,
    last_login_at TIMESTAMP NULL,
    last_login_ip VARCHAR(45) NULL,
    failed_login_attempts INT DEFAULT 0,
    locked_until TIMESTAMP NULL,
    password_changed_at TIMESTAMP NULL,
    require_password_change BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    UNIQUE KEY unique_email_per_tenant (tenant_id, email),
    UNIQUE KEY unique_username_per_tenant (tenant_id, username),
    INDEX idx_email (email),
    INDEX idx_tenant_active (tenant_id, is_active),
    INDEX idx_role (role)
) ENGINE = InnoDB;
-- Configuración 2FA por usuario
CREATE TABLE user_2fa_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL UNIQUE,
    totp_secret VARCHAR(255) NULL COMMENT 'Secret de Google Authenticator encriptado',
    totp_enabled BOOLEAN DEFAULT FALSE,
    webauthn_enabled BOOLEAN DEFAULT FALSE,
    backup_codes_count INT DEFAULT 0,
    recovery_codes_last_generated TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE = InnoDB;
-- Códigos de recuperación (backup codes)
CREATE TABLE recovery_codes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    code_hash VARCHAR(255) NOT NULL COMMENT 'Hash del código de recuperación',
    used_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_unused (user_id, used_at)
) ENGINE = InnoDB;
-- Credenciales WebAuthn (FIDO2 - YubiKey, Touch ID, etc)
CREATE TABLE webauthn_credentials (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    credential_id VARCHAR(500) NOT NULL UNIQUE,
    public_key TEXT NOT NULL,
    attestation_type VARCHAR(50) NOT NULL,
    device_name VARCHAR(255) NULL COMMENT 'Nombre amigable del dispositivo',
    device_type VARCHAR(50) NULL COMMENT 'fingerprint, face, usb_key',
    counter BIGINT UNSIGNED DEFAULT 0,
    last_used_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
) ENGINE = InnoDB;
-- Dispositivos confiables
CREATE TABLE trusted_devices (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    device_fingerprint VARCHAR(64) NOT NULL COMMENT 'Hash único del dispositivo',
    device_name VARCHAR(255) NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT NOT NULL,
    cookie_token VARCHAR(64) NOT NULL UNIQUE,
    expires_at TIMESTAMP NOT NULL,
    last_used_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_device (user_id, device_fingerprint),
    INDEX idx_token (cookie_token),
    INDEX idx_expires (expires_at)
) ENGINE = InnoDB;
-- ============================================================
-- TABLAS DE SESIONES Y SEGURIDAD
-- ============================================================
CREATE TABLE login_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    session_id VARCHAR(128) NOT NULL UNIQUE,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT NOT NULL,
    fingerprint VARCHAR(64) NOT NULL,
    last_activity_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_active (user_id, is_active),
    INDEX idx_session_id (session_id),
    INDEX idx_expires (expires_at)
) ENGINE = InnoDB;
CREATE TABLE session_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    session_id VARCHAR(128) NOT NULL,
    action VARCHAR(50) NOT NULL COMMENT 'created, updated, destroyed, expired',
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
) ENGINE = InnoDB;
-- Logs de eventos de seguridad
CREATE TABLE security_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NULL,
    user_id BIGINT UNSIGNED NULL,
    event_type VARCHAR(100) NOT NULL,
    severity ENUM('INFO', 'WARNING', 'CRITICAL') DEFAULT 'INFO',
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT NULL,
    event_data JSON NULL COMMENT 'Datos adicionales del evento',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE
    SET NULL,
        INDEX idx_event_type (event_type),
        INDEX idx_severity (severity),
        INDEX idx_user_id (user_id),
        INDEX idx_tenant_id (tenant_id),
        INDEX idx_created_at (created_at)
) ENGINE = InnoDB;
-- Rate limiting
CREATE TABLE rate_limit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    identifier VARCHAR(255) NOT NULL COMMENT 'IP, user_id, o combinación',
    endpoint VARCHAR(255) NOT NULL,
    attempts INT DEFAULT 1,
    window_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    window_end TIMESTAMP NOT NULL,
    exceeded_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_identifier_endpoint (identifier, endpoint, window_end),
    INDEX idx_window_end (window_end)
) ENGINE = InnoDB;
-- IPs bloqueadas / Threat Intelligence
CREATE TABLE blocked_ips (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL UNIQUE,
    risk_score INT DEFAULT 0 COMMENT '0-100',
    reason VARCHAR(500) NOT NULL,
    blocked_until TIMESTAMP NULL COMMENT 'NULL = bloqueo permanente',
    blocked_by VARCHAR(50) NOT NULL COMMENT 'manual, automatic, threat_intel',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_ip (ip_address),
    INDEX idx_blocked_until (blocked_until)
) ENGINE = InnoDB;
-- ============================================================
-- TABLAS DEL SISTEMA APU
-- ============================================================
-- Rubros Generales (compartidos por todos los tenants)
CREATE TABLE rubros_generales (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    parent_id BIGINT UNSIGNED NULL COMMENT 'Para jerarquía de rubros',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES rubros_generales(id) ON DELETE
    SET NULL,
        INDEX idx_code (code),
        INDEX idx_parent (parent_id)
) ENGINE = InnoDB;
-- Rubros Personalizados (específicos por tenant)
CREATE TABLE rubros_personalizados (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    parent_id BIGINT UNSIGNED NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES rubros_personalizados(id) ON DELETE
    SET NULL,
        FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
        UNIQUE KEY unique_code_per_tenant (tenant_id, code),
        INDEX idx_tenant (tenant_id)
) ENGINE = InnoDB;
-- Proyectos
CREATE TABLE proyectos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    client_name VARCHAR(255) NULL,
    client_contact VARCHAR(255) NULL,
    location VARCHAR(500) NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    status ENUM('draft', 'active', 'completed', 'cancelled') DEFAULT 'draft',
    total_budget DECIMAL(20, 2) DEFAULT 0.00,
    currency VARCHAR(3) DEFAULT 'COP',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_code_per_tenant (tenant_id, code),
    INDEX idx_tenant_status (tenant_id, status),
    INDEX idx_created_by (created_by)
) ENGINE = InnoDB;
-- Plantillas de Proyectos (para duplicar)
CREATE TABLE plantillas (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    is_public BOOLEAN DEFAULT FALSE COMMENT 'Compartida con otros tenants',
    template_data JSON NOT NULL COMMENT 'Estructura completa del proyecto',
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_tenant (tenant_id),
    INDEX idx_public (is_public)
) ENGINE = InnoDB;
-- APU (Análisis de Precios Unitarios)
CREATE TABLE apu (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    proyecto_id BIGINT UNSIGNED NOT NULL,
    rubro_id BIGINT UNSIGNED NULL COMMENT 'Puede ser general o personalizado',
    rubro_type ENUM('general', 'personalizado') NOT NULL,
    code VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    unit VARCHAR(50) NOT NULL COMMENT 'm2, m3, ml, und, etc',
    quantity DECIMAL(15, 4) DEFAULT 1.0000,
    unit_price DECIMAL(20, 2) DEFAULT 0.00,
    total_price DECIMAL(20, 2) DEFAULT 0.00,
    yield_factor DECIMAL(10, 4) DEFAULT 1.0000 COMMENT 'Rendimiento',
    notes TEXT NULL,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_code_per_project (proyecto_id, code),
    INDEX idx_proyecto (proyecto_id),
    INDEX idx_tenant (tenant_id)
) ENGINE = InnoDB;
-- Materiales
CREATE TABLE materiales (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    unit VARCHAR(50) NOT NULL,
    unit_price DECIMAL(20, 2) NOT NULL,
    supplier VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_code_per_tenant (tenant_id, code),
    INDEX idx_tenant (tenant_id),
    INDEX idx_is_active (is_active)
) ENGINE = InnoDB;
-- Mano de Obra
CREATE TABLE mano_obra (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL COMMENT 'Oficial, Ayudante, Especialista, etc',
    description TEXT NULL,
    hourly_rate DECIMAL(20, 2) NOT NULL,
    daily_rate DECIMAL(20, 2) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_code_per_tenant (tenant_id, code),
    INDEX idx_tenant (tenant_id)
) ENGINE = InnoDB;
-- Equipos
CREATE TABLE equipos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    code VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    hourly_rate DECIMAL(20, 2) NOT NULL,
    daily_rate DECIMAL(20, 2) NULL,
    depreciation_rate DECIMAL(10, 4) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_code_per_tenant (tenant_id, code),
    INDEX idx_tenant (tenant_id)
) ENGINE = InnoDB;
-- Relación APU - Materiales
CREATE TABLE apu_materiales (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apu_id BIGINT UNSIGNED NOT NULL,
    material_id BIGINT UNSIGNED NOT NULL,
    quantity DECIMAL(15, 4) NOT NULL,
    unit_price DECIMAL(20, 2) NOT NULL,
    waste_percent DECIMAL(5, 2) DEFAULT 0.00,
    total_price DECIMAL(20, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (apu_id) REFERENCES apu(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materiales(id) ON DELETE RESTRICT,
    INDEX idx_apu (apu_id)
) ENGINE = InnoDB;
-- Relación APU - Mano de Obra
CREATE TABLE apu_mano_obra (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apu_id BIGINT UNSIGNED NOT NULL,
    mano_obra_id BIGINT UNSIGNED NOT NULL,
    hours DECIMAL(10, 4) NOT NULL,
    hourly_rate DECIMAL(20, 2) NOT NULL,
    total_price DECIMAL(20, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (apu_id) REFERENCES apu(id) ON DELETE CASCADE,
    FOREIGN KEY (mano_obra_id) REFERENCES mano_obra(id) ON DELETE RESTRICT,
    INDEX idx_apu (apu_id)
) ENGINE = InnoDB;
-- Relación APU - Equipos
CREATE TABLE apu_equipos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apu_id BIGINT UNSIGNED NOT NULL,
    equipo_id BIGINT UNSIGNED NOT NULL,
    hours DECIMAL(10, 4) NOT NULL,
    hourly_rate DECIMAL(20, 2) NOT NULL,
    total_price DECIMAL(20, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (apu_id) REFERENCES apu(id) ON DELETE CASCADE,
    FOREIGN KEY (equipo_id) REFERENCES equipos(id) ON DELETE RESTRICT,
    INDEX idx_apu (apu_id)
) ENGINE = InnoDB;
-- ============================================================
-- TABLAS DE REPORTES Y EXPORTACIONES
-- ============================================================
CREATE TABLE export_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    proyecto_id BIGINT UNSIGNED NULL,
    export_type ENUM('pdf', 'excel', 'csv') NOT NULL,
    file_path VARCHAR(500) NULL,
    file_size BIGINT NULL,
    status ENUM('pending', 'processing', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE
    SET NULL,
        INDEX idx_tenant_user (tenant_id, user_id),
        INDEX idx_status (status)
) ENGINE = InnoDB;
-- ============================================================
-- VISTAS ÚTILES
-- ============================================================
-- Vista de usuarios activos por tenant
CREATE OR REPLACE VIEW v_active_users_per_tenant AS
SELECT t.id AS tenant_id,
    t.name AS tenant_name,
    COUNT(u.id) AS active_users,
    t.max_users,
    (COUNT(u.id) / t.max_users * 100) AS usage_percent
FROM tenants t
    LEFT JOIN users u ON t.id = u.tenant_id
    AND u.is_active = TRUE
WHERE t.is_active = TRUE
GROUP BY t.id,
    t.name,
    t.max_users;
-- Vista de proyectos activos por tenant
CREATE OR REPLACE VIEW v_active_projects_per_tenant AS
SELECT t.id AS tenant_id,
    t.name AS tenant_name,
    COUNT(p.id) AS active_projects,
    t.max_projects,
    (COUNT(p.id) / t.max_projects * 100) AS usage_percent
FROM tenants t
    LEFT JOIN proyectos p ON t.id = p.tenant_id
    AND p.status = 'active'
WHERE t.is_active = TRUE
GROUP BY t.id,
    t.name,
    t.max_projects;
-- ============================================================
-- FUNCIÓN: Generar UUID v4
-- ============================================================
DELIMITER $$ CREATE FUNCTION generate_uuid_v4() RETURNS CHAR(36) DETERMINISTIC BEGIN RETURN LOWER(
    CONCAT(
        LPAD(HEX(FLOOR(RAND() * 0xFFFFFFFF)), 8, '0'),
        '-',
        LPAD(HEX(FLOOR(RAND() * 0xFFFF)), 4, '0'),
        '-',
        '4',
        LPAD(HEX(FLOOR(RAND() * 0x0FFF)), 3, '0'),
        '-',
        HEX(FLOOR(RAND() * 4 + 8)),
        LPAD(HEX(FLOOR(RAND() * 0x0FFF)), 3, '0'),
        '-',
        LPAD(HEX(FLOOR(RAND() * 0xFFFFFFFF)), 8, '0'),
        LPAD(HEX(FLOOR(RAND() * 0xFFFF)), 4, '0')
    )
);
END $$ DELIMITER;
-- ============================================================
-- DATOS INICIALES
-- ============================================================
-- Tenant de ejemplo
INSERT INTO tenants (
        uuid,
        name,
        slug,
        timezone,
        currency,
        plan,
        max_users,
        max_projects
    )
VALUES (
        UUID(),
        'Empresa Demo',
        'demo',
        'America/Bogota',
        'COP',
        'professional',
        20,
        50
    );
-- Usuario super admin inicial (password: Admin123!)
-- Hash generado con: password_hash('Admin123!', PASSWORD_DEFAULT)
INSERT INTO users (
        tenant_id,
        uuid,
        email,
        username,
        password,
        first_name,
        last_name,
        role,
        is_active,
        email_verified_at
    )
VALUES (
        1,
        UUID(),
        'admin@demo.com',
        'admin',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Super',
        'Admin',
        'super_admin',
        TRUE,
        NOW()
    );
-- Rubros generales de ejemplo
INSERT INTO rubros_generales (code, name, description)
VALUES (
        '01',
        'PRELIMINARES',
        'Trabajos preliminares de la obra'
    ),
    (
        '02',
        'CIMENTACIÓN',
        'Trabajos de cimentación y estructura'
    ),
    ('03', 'MAMPOSTERÍA', 'Muros y divisiones'),
    ('04', 'ACABADOS', 'Acabados finales'),
    (
        '05',
        'INSTALACIONES',
        'Instalaciones eléctricas, hidráulicas y sanitarias'
    );
-- ============================================================
-- FIN DEL SCRIPT
-- ============================================================
