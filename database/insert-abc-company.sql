-- Script para insertar empresa de ejemplo "ABC"
USE apu_system;
-- Insertar tenant ABC
INSERT INTO tenants (
        name,
        subdomain,
        plan,
        is_active,
        max_users,
        max_projects,
        max_storage,
        created_at,
        updated_at
    )
VALUES (
        'ABC',
        'abc',
        'professional',
        1,
        50,
        100,
        10000,
        NOW(),
        NOW()
    );
SET @abc_tenant_id = LAST_INSERT_ID();
-- Crear usuario administrador de ABC
INSERT INTO users (
        tenant_id,
        email,
        username,
        password,
        first_name,
        last_name,
        roles,
        is_active,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        'admin@abc.com',
        'admin@abc.com',
        '$2y$13$8K1p/H9OujiUdXnEjI0K.OLm7.3VaQ8KqJnL0BVQZ7yfhg.YJfF0S',
        -- Admin123!
        'Administrador',
        'ABC',
        '["ROLE_ADMIN"]',
        1,
        NOW(),
        NOW()
    );
SET @abc_admin_id = LAST_INSERT_ID();
-- Crear usuario regular de ABC
INSERT INTO users (
        tenant_id,
        email,
        username,
        password,
        first_name,
        last_name,
        roles,
        is_active,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        'user@abc.com',
        'user@abc.com',
        '$2y$13$8K1p/H9OujiUdXnEjI0K.OLm7.3VaQ8KqJnL0BVQZ7yfhg.YJfF0S',
        -- Admin123!
        'Usuario',
        'ABC',
        '["ROLE_USER"]',
        1,
        NOW(),
        NOW()
    );
-- Proyecto de ejemplo 1
INSERT INTO proyectos (
        tenant_id,
        nombre,
        codigo,
        descripcion,
        cliente,
        ubicacion,
        fecha_inicio,
        estado,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        'Construcción Edificio Corporativo',
        'ABC-2025-001',
        'Edificio de oficinas de 10 pisos en zona comercial',
        'Empresa XYZ S.A.',
        'Bogotá, Colombia',
        '2025-01-15',
        'en_proceso',
        NOW(),
        NOW()
    );
SET @proyecto1_id = LAST_INSERT_ID();
-- Proyecto de ejemplo 2
INSERT INTO proyectos (
        tenant_id,
        nombre,
        codigo,
        descripcion,
        cliente,
        ubicacion,
        fecha_inicio,
        estado,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        'Remodelación Centro Comercial',
        'ABC-2025-002',
        'Renovación completa de áreas comunes y locales',
        'Mall Plaza S.A.',
        'Medellín, Colombia',
        '2025-02-01',
        'planificacion',
        NOW(),
        NOW()
    );
SET @proyecto2_id = LAST_INSERT_ID();
-- Proyecto de ejemplo 3
INSERT INTO proyectos (
        tenant_id,
        nombre,
        codigo,
        descripcion,
        cliente,
        ubicacion,
        fecha_inicio,
        estado,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        'Pavimentación Vía Nacional',
        'ABC-2024-015',
        'Pavimentación de 25 km de vía nacional',
        'Ministerio de Transporte',
        'Cundinamarca, Colombia',
        '2024-11-01',
        'finalizado',
        NOW(),
        NOW()
    );
-- Rubros personalizados de ejemplo
INSERT INTO rubros_personalizados (
        tenant_id,
        codigo,
        nombre,
        unidad,
        descripcion,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        'RPC-001',
        'Excavación en tierra',
        'M3',
        'Excavación manual en tierra común',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'RPC-002',
        'Concreto 3000 PSI',
        'M3',
        'Suministro y colocación de concreto 3000 PSI',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'RPC-003',
        'Acero de refuerzo',
        'KG',
        'Figurado, amarre e instalación de acero de refuerzo',
        NOW(),
        NOW()
    );
-- Materiales de ejemplo
INSERT INTO materiales (
        tenant_id,
        codigo,
        nombre,
        unidad,
        precio_unitario,
        proveedor,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        'MAT-001',
        'Cemento gris x 50kg',
        'Und',
        28500.00,
        'Cementos Argos',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'MAT-002',
        'Arena lavada',
        'M3',
        45000.00,
        'Agregados del Norte',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'MAT-003',
        'Grava triturada',
        'M3',
        52000.00,
        'Agregados del Norte',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'MAT-004',
        'Varilla corrugada 1/2"',
        'Und (6m)',
        32000.00,
        'Acerías Paz del Río',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'MAT-005',
        'Ladrillo tolete',
        'Und',
        850.00,
        'Ladrillera Santafé',
        NOW(),
        NOW()
    );
-- Mano de obra de ejemplo
INSERT INTO mano_obra (
        tenant_id,
        codigo,
        cargo,
        costo_hora,
        descripcion,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        'MO-001',
        'Oficial construcción',
        8500.00,
        'Oficial especializado en construcción',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'MO-002',
        'Ayudante',
        6000.00,
        'Ayudante de construcción',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'MO-003',
        'Maestro general',
        12000.00,
        'Maestro de obra certificado',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'MO-004',
        'Electricista',
        10000.00,
        'Electricista certificado',
        NOW(),
        NOW()
    );
-- Equipos de ejemplo
INSERT INTO equipos (
        tenant_id,
        codigo,
        nombre,
        costo_hora,
        descripcion,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        'EQ-001',
        'Mezcladora concreto 1 saco',
        4500.00,
        'Mezcladora eléctrica capacidad 1 saco',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'EQ-002',
        'Vibrador concreto',
        3000.00,
        'Vibrador eléctrico para concreto',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'EQ-003',
        'Andamio metálico',
        2500.00,
        'Andamio tubular metálico por día',
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        'EQ-004',
        'Retroexcavadora',
        85000.00,
        'Retroexcavadora CAT 416',
        NOW(),
        NOW()
    );
-- APU de ejemplo para proyecto 1
INSERT INTO apu (
        tenant_id,
        proyecto_id,
        codigo,
        descripcion,
        unidad,
        cantidad,
        rendimiento,
        created_at,
        updated_at
    )
VALUES (
        @abc_tenant_id,
        @proyecto1_id,
        'APU-001',
        'Excavación en tierra común',
        'M3',
        100.00,
        8.50,
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        @proyecto1_id,
        'APU-002',
        'Concreto para zapatas',
        'M3',
        45.00,
        5.00,
        NOW(),
        NOW()
    ),
    (
        @abc_tenant_id,
        @proyecto1_id,
        'APU-003',
        'Mampostería bloque estructural',
        'M2',
        350.00,
        12.00,
        NOW(),
        NOW()
    );
SELECT 'Empresa ABC creada exitosamente' AS resultado;
SELECT CONCAT('Tenant ID: ', @abc_tenant_id) AS info;
SELECT CONCAT('Admin: admin@abc.com / Admin123!') AS credenciales;
SELECT CONCAT('Usuario: user@abc.com / Admin123!') AS credenciales_user;
