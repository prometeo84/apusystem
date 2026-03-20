# 📐 Arquitectura del Sistema APU

Documentación de la arquitectura técnica del Sistema APU.

---

## 🏗️ Arquitectura Multi-Tenant

### Diseño General

El sistema APU utiliza una arquitectura **multi-tenant basada en sesión**, sin necesidad de subdominios.

```
┌─────────────────────────────────────┐
│    Sistema APU (URL única)          │
│    https://apusystem.com            │
└─────────────────────────────────────┘
           │
    ┌──────┴──────┬───────────┐
    │             │           │
┌───▼────┐   ┌───▼────┐  ┌───▼────┐
│Empresa │   │Empresa │  │Empresa │
│   A    │   │   B    │  │   C    │
└───┬────┘   └───┬────┘  └───┬────┘
    │            │           │
 Usuarios     Usuarios    Usuarios
```

### Ventajas

✅ **No requiere subdominios** - Compatible con hosting compartido
✅ **Identificación por sesión** - Cada usuario pertenece a su tenant
✅ **Un solo certificado SSL**
✅ **Escalabilidad infinita** - Añadir empresas sin configuración DNS
✅ **Aislamiento de datos** - Queries filtrados automáticamente por `tenant_id`

### Identificación de Tenants

- **Identificador único:** `slug` (ej: `abc`, `demo`, `empresa-xyz`)
- **Asignación:** Usuario tiene `tenant_id` → Al autenticarse, sesión guarda el tenant
- **Sin subdominios:** Todos acceden por la misma URL

### Aislamiento de Datos

**A nivel de base de datos:**

```sql
-- Todas las tablas principales tienen tenant_id
users (id, tenant_id, email, ...)
proyectos (id, tenant_id, name, ...)
apu (id, tenant_id, ...)

-- Queries automáticamente filtrados
SELECT * FROM users WHERE tenant_id = :currentTenantId
```

**A nivel de aplicación:**

- Event Listener `TenantListener` intercepta todas las queries
- Añade filtro automático `WHERE tenant_id = ?`
- SUPER_ADMIN puede desactivar el filtro para ver todo

---

## 👥 Jerarquía de Roles

### 3 Niveles de Acceso

| Rol             | Responsabilidad           | Scope               |
| --------------- | ------------------------- | ------------------- |
| **SUPER_ADMIN** | Administrador del sistema | Todo el sistema     |
| **ADMIN**       | Administrador de empresa  | Su empresa          |
| **USER**        | Usuario normal            | Proyectos asignados |

### SUPER_ADMIN (Administrador del Sistema)

**Responsabilidades:**

- Gestionar TODAS las empresas (tenants)
- Ver logs de seguridad de todo el sistema
- Configurar alertas globales
- Monitoreo del sistema
- Gestión de errores del sistema

**Accesos:**

- System Panel (Dashboard exclusivo)
- Ver/editar todas las empresas
- Ver usuarios de cualquier empresa
- Monitoreo global

**Restricciones:**

- NO tiene "Quick Actions" en System Panel
- NO pertenece a una empresa específica (o empresa "Sistema")

### ADMIN (Administrador de Empresa)

**Responsabilidades:**

- Gestionar SU empresa
- Crear/editar usuarios de su empresa
- Ver logs de su empresa
- Configurar datos de su empresa

**Accesos:**

- Administration Panel
- Quick Actions (crear usuarios, ver logs, configurar empresa)
- APUs y proyectos de su empresa

**Restricciones:**

- NO ve otras empresas
- NO modifica configuración global
- Solo logs de su empresa

### USER (Usuario Normal)

**Responsabilidades:**

- Trabajar en proyectos asignados
- Ver APUs
- Editar su perfil

**Accesos:**

- Dashboard
- APUs (lectura/escritura según permisos)
- Proyectos asignados

**Restricciones:**

- NO crea usuarios
- NO modifica empresa
- NO ve configuraciones
- NO accede a Administration Panel

---

## 🗄️ Estructura de Base de Datos

### Tablas Principales (30+)

#### Core del Sistema

- **tenants** - Empresas en el sistema
- **users** - Usuarios (con `tenant_id`)
- **login_sessions** - Sesiones activas
- **password_reset_tokens** - Tokens de recuperación

#### Seguridad y Autenticación

- **recovery_codes** - Códigos 2FA de recuperación
- **user_2fa_settings** - Configuración 2FA
- **security_events** - Logs de seguridad
- **blocked_ips** - IPs bloqueadas

#### Sistema APU

- **apu** - APUs principales
- **apu_items** - Items de APU
- **apu_materials** - Materiales
- **apu_labor** - Mano de obra
- **apu_equipment** - Equipos
- **apu_transport** - Transporte
- **rubros_generales** - Rubros generales
- **proyectos** - Proyectos
- **revit_files** - Archivos Revit

#### Vistas

- **v_active_users_per_tenant** - Usuarios activos por empresa
- **v_active_projects_per_tenant** - Proyectos activos por empresa

### Diagrama ER Simplificado

```
tenants (1) ──< (N) users
tenants (1) ──< (N) proyectos
proyectos (1) ──< (N) apu
apu (1) ──< (N) apu_items
users (1) ──< (N) recovery_codes
users (1) ──── (1) user_2fa_settings
```

---

## 🔧 Stack Tecnológico

### Backend

- **Framework:** Symfony 7.2
- **Lenguaje:** PHP 8.2+
- **ORM:** Doctrine
- **Seguridad:** Symfony Security Bundle
- **2FA:** PragmaRX/Google2FA
- **JWT:** LexikJWTAuthenticationBundle (API Revit)

### Frontend

- **Motor de Templates:** Twig
- **Assets:** Vite (build) + Webpack Encore
- **CSS:** Bootstrap 5
- **Icons:** Bootstrap Icons

### Base de Datos

- **Motor:** MySQL 8.0
- **Charset:** utf8mb4_unicode_ci
- **Timezone:** UTC (convertido por usuario)

### DevOps

- **Contenedores:** Docker + Docker Compose
- **Servicios:**
    - `apache` - PHP 8.2 + Apache
    - `mysql` - MySQL 8.0
    - `mailpit` - SMTP de desarrollo

### Linters y Calidad

- **PHPStan:** Level 5 (0 errores)
- **Composer Audit:** 0 vulnerabilidades
- **Twig Lint:** 0 errores de sintaxis

---

## 📁 Estructura del Código

```
src/
├── Command/              # Comandos de consola
│   └── CreateSuperAdminCommand.php
├── Controller/           # Controladores (MVC)
│   ├── Admin/            # Panel de administración
│   ├── Dashboard/        # Dashboard principal
│   ├── Profile/          # Perfil de usuario
│   ├── Security/         # Login, 2FA
│   └── System/           # Panel de super admin
├── Entity/               # Entidades Doctrine (ORM)
│   ├── User.php
│   ├── Tenant.php
│   ├── RecoveryCode.php
│   └── ...
├── EventListener/        # Event Subscribers
│   ├── TenantListener.php
│   ├── SecurityHeadersSubscriber.php
│   └── RateLimitSubscriber.php
├── Repository/           # Repositorios Doctrine
├── Security/             # Autenticación
│   ├── TwoFactorAuthenticator.php
│   └── ...
├── Service/              # Servicios de negocio
│   ├── TwoFactorAuthService.php
│   ├── SecurityLogger.php
│   └── EncryptionService.php
└── Twig/                 # Extensiones Twig
    └── AppExtension.php
```

---

## 🔄 Flujo de Autenticación

### 1. Login Normal

```
Usuario → LoginController → Security Component
         ↓
     Verificar credenciales (bcrypt)
         ↓
     Guardar tenant_id en sesión
         ↓
     Redirigir a Dashboard
```

### 2. Login con 2FA

```
Usuario → LoginController → Credenciales OK
         ↓
     ¿Tiene 2FA habilitado?
         ↓ Sí
     Solicitar código TOTP
         ↓
     Verificar código (Google2FA)
         ↓
     Sesión autenticada
```

### 3. Recuperación con Recovery Code

```
Usuario perdió dispositivo 2FA
         ↓
     Usa recovery code guardado
         ↓
     Verificar hash (bcrypt)
         ↓
     Marcar código como usado
         ↓
     Autenticar sesión
```

---

## 🌍 Internacionalización

### Idiomas Soportados

- 🇪🇸 **Español** (es)
- 🇬🇧 **Inglés** (en)

### Archivos de Traducción

```
translations/
├── messages.es.yaml      # 360+ claves en español
└── messages.en.yaml      # 360+ claves en inglés
```

### Zona Horaria

- **Selección por usuario:** 22 zonas disponibles
- **Default:** America/Guayaquil
- **Formato:** UTC → Zona usuario (conversión automática)

---

## 🎨 Sistema de Temas

### Personalización

- **Color Primario:** Configurable (hex)
- **Color Secundario:** Configurable (hex)
- **Vista Previa:** Tiempo real
- **Persistencia:** Guardado en `user.preferences`

### Temas Predefinidos

1. Default (Azul)
2. Verde
3. Rojo
4. Morado
5. Naranja

---

## 📊 Planes y Límites

### Planes Disponibles

| Plan             | Usuarios  | Proyectos | Almacenamiento |
| ---------------- | --------- | --------- | -------------- |
| **Basic**        | 10        | 20        | 5 GB           |
| **Professional** | 50        | 100       | 10 GB          |
| **Enterprise**   | Ilimitado | Ilimitado | Ilimitado      |

### Control de Límites

- Validación al crear usuario: `if (userCount >= tenant.maxUsers) → Error`
- Validación al crear proyecto: Similar
- Dashboard muestra uso actual vs límite

---

## 🔐 Seguridad Implementada

### Headers de Seguridad (10/10)

```
Content-Security-Policy: default-src 'self'...
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
Strict-Transport-Security: max-age=31536000
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: geolocation=(), microphone=()
```

### Rate Limiting

- **Login:** 5 intentos / 15 min
- **API:** 100 requests / hora
- **Bloqueo de IP:** Automático tras intentos fallidos

### Encriptación

- **Contraseñas:** bcrypt (coste 13)
- **Secretos TOTP:** AES-256-GCM
- **Recovery Codes:** bcrypt hash
- **Tokens JWT:** RS256

---

## 📈 Escalabilidad

### Horizontal

- Múltiples instancias de Apache/PHP
- Load Balancer (nginx/HAProxy)
- Sesiones en Redis/Memcached

### Vertical

- Incrementar recursos de contenedores
- Optimización de queries (índices)
- Caché de queries repetitivas

---

**Última actualización:** 19/03/2026
