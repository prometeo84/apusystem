# 🏗️ APU System - Sistema de Análisis de Precios Unitarios

Sistema multi-tenant para análisis y gestión de APUs (Análisis de Precios Unitarios) en proyectos de construcción.

[![Symfony](https://img.shields.io/badge/Symfony-7.2-000000?logo=symfony)](https://symfony.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)](https://mysql.com)
[![License](https://img.shields.io/badge/License-Proprietary-red)]()

[![CI - Tests](https://github.com/prometeo84/apusystem/actions/workflows/ci-tests.yml/badge.svg?branch=main)](https://github.com/prometeo84/apusystem/actions/workflows/ci-tests.yml)
[![Validators Suite](https://github.com/prometeo84/apusystem/actions/workflows/validators.yml/badge.svg?branch=main)](https://github.com/prometeo84/apusystem/actions/workflows/validators.yml)
[![CodeQL](https://github.com/prometeo84/apusystem/actions/workflows/codeql-analysis.yml/badge.svg?branch=main)](https://github.com/prometeo84/apusystem/actions/workflows/codeql-analysis.yml)
[![Snyk Security](https://github.com/prometeo84/apusystem/actions/workflows/snyk-scan.yml/badge.svg?branch=main)](https://github.com/prometeo84/apusystem/actions/workflows/snyk-scan.yml)

---

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Arquitectura](#-arquitectura)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso](#-uso)
- [Seguridad](#-seguridad)
- [API](#-api)
- [Desarrollo](#-desarrollo)
- [Documentación](#-documentación)
- [Licencia](#-licencia)

---

## ✨ Características

### 🏢 Multi-Tenant

- **Identificación por sesión** (no requiere subdominios)
- Aislamiento completo de datos entre empresas
- Gestión de planes (Basic, Professional, Enterprise)
- Límites configurables por empresa

### 🔐 Seguridad

- **Autenticación 2FA** (TOTP con Google Authenticator)
- Sistema de sesiones seguras
- Rate limiting y protección contra brute force
- Logs de auditoría completos
- Bloqueo de IPs maliciosas

### 👥 Gestión de Usuarios

- **3 niveles de acceso:**
    - `SUPER_ADMIN`: Administrador del sistema
    - `ADMIN`: Administrador de empresa
    - `USER`: Usuario normal
- Perfiles personalizables
- Preferencias de idioma y zona horaria
- Temas personalizables

### 📊 APUs y Proyectos

Flujo completo de análisis de precios unitarios organizado jerárquicamente:

```
LOGIN → PROYECTOS → PLANTILLAS → RUBROS → APU → REPORTE (PDF / Excel)
```

- **Proyectos**: creación, edición y duplicación de proyectos de obra
- **Rubros Personalizados**: catálogo de rubros CRUD con código, unidad y tipo
- **Plantillas de Presupuesto**: agrupan rubros asignados a cada proyecto
- **APU por Rubro**: Equipo, Mano de Obra, Materiales y Transporte con cálculo automático
- **Utilidad y Precio Ofertado**: porcentaje configurable y precio final por APU
- **Reportes PDF y Excel**: por plantilla individual o por proyecto completo
- **Duplicar Proyectos y Plantillas**: copia estructura sin APUs
- Importación desde Revit (BIM)

### 🌐 Internacionalización

- Soporte para **Español** e **Inglés**
- Sistema de traducciones completo
- Zona horaria por usuario/empresa/sistema

### 🎨 Personalización

- Temas personalizables (colores primarios/secundarios)
- Modo claro/oscuro
- Vista previa en tiempo real

---

## 🏗️ Arquitectura

### Multi-Tenant Design

```
┌─────────────────────────────────────────┐
│         Sistema (APU System)             │
│  🌐 Una sola URL: apusystem.com         │
└─────────────────────────────────────────┘
              │
    ┌─────────┴─────────┬──────────┐
    │                   │          │
┌───▼────┐         ┌───▼────┐   ┌───▼────┐
│Empresa │         │Empresa │   │Empresa │
│   A    │         │   B    │   │   C    │
└───┬────┘         └───┬────┘   └───┬────┘
    │                  │            │
 Usuarios          Usuarios     Usuarios
```

**Ventajas:**

- ✅ No requiere subdominios (compatible con hosting compartido)
- ✅ Aislamiento de datos por sesión de usuario
- ✅ Escalable infinitamente
- ✅ Un solo certificado SSL

### Jerarquía de Roles

| Rol             | Responsabilidad           | Acceso                  |
| --------------- | ------------------------- | ----------------------- |
| **SUPER_ADMIN** | Administrador del sistema | Todas las empresas      |
| **ADMIN**       | Administrador de empresa  | Su empresa              |
| **USER**        | Usuario normal            | Proyectos de su empresa |

Ver [docs/ROLES_ARCHITECTURE.md](docs/ROLES_ARCHITECTURE.md) para más detalles.

---

## 📦 Requisitos

- **PHP** 8.3 o superior
- **Composer** 2.x
- **MySQL** 8.0 o superior
- **Node.js** 18+ y npm (para assets)
- **Docker** y **Docker Compose** (opcional, recomendado)

### Extensiones PHP Requeridas

```
ext-ctype
ext-iconv
ext-json
ext-pdo
ext-pdo_mysql
ext-mbstring
ext-intl
ext-gd
```

---

## 🚀 Instalación

### 1️⃣ Clonar el Repositorio

```bash
git clone https://github.com/tuusuario/apu-system.git
cd apu-system
```

### 2️⃣ Con Docker (Recomendado)

```bash
# Copiar plantilla de variables de entorno para desarrollo
# Edita .env.dev con valores reales (no comitear)
cp .env.dist .env.dev

# Iniciar contenedores
docker-compose up -d

# Instalar dependencias
docker exec apache composer install

# Ejecutar migraciones
docker exec apache php bin/console doctrine:migrations:migrate --no-interaction

# Crear super admin
docker exec apache php bin/console app:create-super-admin admin@demo.com password123
```

### 3️⃣ Sin Docker

```bash
# Instalar dependencias PHP
composer install

# Configurar base de datos en .env
# DATABASE_URL="mysql://usuario:password@localhost:3306/apu_system"

# Crear base de datos
php bin/console doctrine:database:create

# Ejecutar migraciones
php bin/console doctrine:migrations:migrate

# Crear super admin
php bin/console app:create-super-admin admin@demo.com password123

# Iniciar servidor
symfony server:start
# o
php -S localhost:8000 -t public/
```

---

## ⚙️ Configuración

### Variables de Entorno (usar `.env.dev` en desarrollo y `.env.prod` en producción)

```bash
# Nota: copia `.env.dist` a `.env.dev` para desarrollo y a `.env.prod` en el servidor,
# o exporta variables de entorno en el host/servicio de despliegue.

# Ambiente
APP_ENV=prod
APP_SECRET=cambiar_por_clave_secreta_aleatoria

# Base de Datos
DATABASE_URL="mysql://usuario:password@localhost:3306/apu_system?serverVersion=8.0"

# Mailer (para recuperación de contraseñas)
MAILER_DSN=smtp://user:pass@smtp.example.com:587

# JWT (para API Revit)
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=tu_passphrase_segura

# Timezone por defecto
DEFAULT_TIMEZONE=America/Guayaquil
```

### Generar Claves JWT (para API)

````bash
php bin/console lexik:jwt:generate-keypair

## 🛫 Despliegue en Producción — Ejeción centralizada de CRON (cron-job.org)

En entornos donde no es posible crear crons del sistema, podemos centralizar la ejecución usando cron-job.org. La idea es:

- Configurar cron-job.org para llamar cada hora al endpoint `POST /cron/run` del servicio.
- El `CronController` actúa como gateway/dispatcher y ejecuta sólo los jobs que estén programados para la hora actual (p. ej. ejecutar `purge_sessions` a las 03:00).

Ventajas:

- No necesita crontab en el host de producción.
- Permite centralizar horarios y forzar ejecuciones puntuales mediante el parámetro `job`.

Cómo configurarlo:

1) Asegúrate de definir una API key en `.env` (`CRON_JOB_API_KEY`) y mantenerla secreta.

2) Definir los horarios por job usando la variable `CRON_JOB_SCHEDULES` (JSON). Ejemplo en `.env`:

```env
# Ejecutado por cron-job.org cada hora; el dispatcher decide qué jobs ejecutar según la hora
CRON_JOB_API_KEY=changeme_replace_with_secure_key
CRON_JOB_SCHEDULES='{"purge_sessions":{"hours":[3],"days":15},"scan_anomalies":{"hours":[0,6,12,18]}}'
# Opcional: zona horaria usada por el dispatcher (por defecto UTC)
CRON_TIMEZONE=UTC
```

Explicación: en el ejemplo `purge_sessions` sólo se ejecutará cuando la hora sea `03` (UTC). `scan_anomalies` se ejecutará a las 00:00, 06:00, 12:00 y 18:00.

3) Programa cron-job.org para llamar cada hora (por ejemplo, todos los días cada hora). En la configuración de cron-job.org pon un `POST` a `https://tu-dominio/cron/run` e incluye el campo `api_key` con el valor de `CRON_JOB_API_KEY`, o añade cabecera `X-Cron-Api-Key`.

4) Forzar ejecución puntual: puedes llamar `POST /cron/run` con `job=purge_sessions` y `force=1` para forzar la ejecución fuera de horario.

5) Logs y supervisión: el endpoint devuelve JSON con el resultado de cada job. Recomendamos guardar registros de ejecución (proxy/nginx o logs de la app) y configurar alertas si un job falla.

Notas de seguridad:

- Mantén `CRON_JOB_API_KEY` fuera del repositorio (usa secret manager o variables de entorno del hosting).
- Opcionalmente añade verificación de IPs permitidas o HMAC si necesitas mayor protección.

Alternativa local (si puedes usar crontab): el repo incluye `scripts/purge_sessions.sh` y la entrada recomendada para `crontab` era:

```cron
# Ejecuta script de purga todos los días a las 03:00
0 3 * * * /var/www/html/proyecto/scripts/purge_sessions.sh >> /var/www/html/proyecto/var/log/purge_sessions.log 2>&1
```


---

## 💻 Uso

### Acceso Web

```

http://localhost:8000

````

**Usuarios de Prueba:**

Para realizar pruebas, el sistema incluye usuarios predefinidos con diferentes roles:

| Rol             | Email            | Password    | Descripción                    |
| --------------- | ---------------- | ----------- | ------------------------------ |
| **SUPER_ADMIN** | `admin@demo.com` | `Admin123!` | Administrador del sistema      |
| **ADMIN**       | `admin@abc.com`  | `Admin123!` | Administrador de empresa ABC   |
| **USER**        | `user@abc.com`   | `Admin123!` | Usuario regular de empresa ABC |

📄 **Ver documentación completa:** [docs/TEST_USERS.md](docs/TEST_USERS.md)

⚠️ **IMPORTANTE:** Cambiar todas las contraseñas en producción.

### Crear Empresa

1. Acceder como SUPER_ADMIN
2. Ir a **Empresas** → **Crear Nueva Empresa**
3. Configurar:
    - Nombre de la empresa
    - Código de empresa (identificador único)
    - Plan (Basic/Professional/Enterprise)
    - Límites de usuarios y proyectos

### Crear Usuarios de Empresa

1. Acceder como ADMIN de la empresa
2. Ir a **Administración** → **Crear Usuario**
3. Asignar rol (ADMIN o USER)

### Trabajar con APUs

1. Acceder como USER o ADMIN
2. Ir a **Proyectos** → **Crear Proyecto**
3. Dentro del proyecto: **APUs** → **Crear APU**
4. Agregar partidas, materiales, mano de obra y equipos

---

## 🔒 Seguridad

### Autenticación 2FA

1. Ir a **Perfil** → **Seguridad**
2. Habilitar 2FA
3. Escanear código QR con Google Authenticator/Authy
4. Guardar códigos de recuperación

### Logs de Seguridad

- **SUPER_ADMIN**: puede ver logs de todas las empresas
- **ADMIN**: puede ver logs de su empresa
- Eventos registrados: login, logout, cambios críticos, intentos fallidos

### Sesiones

- Expiración configurable
- Múltiples sesiones permitidas
- Cierre de sesión remoto

---

## 🔌 API

### Plugin Revit

El sistema incluye API REST para integración con Autodesk Revit:

```http
POST /api/revit/authenticate
POST /api/revit/upload
GET /api/revit/files/{id}
````

**Autenticación:**

```bash
curl -X POST http://localhost:8000/api/revit/authenticate \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@empresa.com",
    "password": "password"
  }'
```

Respuesta:

```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {...},
  "tenant": "empresa-codigo"
}
```

Ver [docs/API.md](docs/API.md) para documentación completa.

---

## 🛠️ Desarrollo

### Estructura del Proyecto

```
proyecto/
├── config/              # Configuración Symfony
├── docs/                # Documentación
│   ├── ROLES_ARCHITECTURE.md
│   └── MULTI_TENANT.md
├── migrations/          # Migraciones de BD
├── public/              # Archivos públicos
├── src/
│   ├── Command/         # Comandos de consola
│   ├── Controller/      # Controladores
│   ├── Entity/          # Entidades Doctrine
│   ├── EventListener/   # Event subscribers
│   ├── Repository/      # Repositorios
│   ├── Security/        # Autenticación y autorización
│   ├── Service/         # Servicios de negocio
│   └── Twig/            # Extensiones Twig
├── templates/           # Plantillas Twig
├── translations/        # Archivos de traducción
└── tests/               # Tests
```

### Comandos Útiles

```bash
# Limpiar caché
php bin/console cache:clear

# Ver rutas
php bin/console debug:router

# Crear migración
php bin/console make:migration

# Ejecutar tests
php bin/phpunit

# Verificar código
vendor/bin/phpstan analyse src

# Ver logs en tiempo real (Docker)
docker logs -f apache
```

### Coding Standards

```bash
# PHP CS Fixer
vendor/bin/php-cs-fixer fix src

# PHPStan
vendor/bin/phpstan analyse
```

---

## 📚 Documentación

- [Auditoría QA](docs/QA_AUDIT_REPORT.md) - Resumen ejecutivo de la validación integral
- [Arquitectura](docs/01-ARQUITECTURA.md) - Diseño técnico y multi-tenant
- [Guía de Usuario](docs/02-GUIA_USUARIO.md) - Uso y credenciales de prueba
- [Seguridad (OWASP)](docs/03-SEGURIDAD_OWASP.md) - Prácticas y checklist
- [API Revit](docs/04-API_REVIT.md) - Endpoints y ejemplos
- [Desarrollo](docs/05-DESARROLLO.md) - Comandos y arquitectura para desarrolladores

## 🧾 Environment variables (ejemplo `.env.dist`)

Copia `.env.dist` a `.env.dev` para desarrollo y completa los valores reales. No comitees secretos (usar `.env.prod` o variables de entorno en producción).

Ejemplo mínimo (ver `.env.dist` en la raíz del proyecto):

```bash
APP_ENV=dev
APP_DEBUG=1
APP_SECRET=change_me_replace_with_strong_random
DATABASE_URL=mysql://db_user:db_pass@127.0.0.1:3306/db_name
MAILER_DSN=smtp://localhost:1025
MAILER_FROM_ADDRESS=noreply@example.com
MAILER_FROM_NAME="APU System"
DEFAULT_URI=http://localhost
SESSION_LIFETIME=3600
```

Para producción, provee valores desde el entorno del host o el gestor de secretos de tu plataforma (no subir `.env.prod` al repositorio).

- [Seguridad](docs/SECURITY.md) - Guía de seguridad

---

## 🧪 Testing

```bash
# Ejecutar todos los tests (dentro del contenedor)
docker exec apache php vendor/bin/phpunit --configuration phpunit.dist.xml

# Tests específicos
docker exec apache php vendor/bin/phpunit tests/Unit/Security/RBACTest.php

# Con cobertura
docker exec apache php vendor/bin/phpunit --coverage-html coverage/
```

**Suite actual:** 174 tests · 270 assertions · 0 fallos

| Grupo                           | Tests |
| ------------------------------- | ----- |
| Seguridad (RBAC + sanitización) | 21    |
| Timezone / L10n                 | 12    |
| CRUD + lógica APU               | 18    |
| WebAuthn / 2FA / Encryption     | 30    |
| APU, Plantilla, Rubro           | 15    |
| Otros (UserTest, TenantTest…)   | 78    |

```bash
# E2E Playwright (requiere app corriendo en localhost:8080)
npm run test:e2e
```

---

---

## 🤝 Contribución

Este es un proyecto privado/propietario. Para contribuir:

1. Fork el repositorio
2. Crear rama feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crear Pull Request

---

## 📄 Licencia

Copyright © 2026 APU System. Todos los derechos reservados.

Este es un software propietario. No se permite su distribución, modificación o uso comercial sin autorización explícita.

---

## 👨‍💻 Autor

Desarrollado con ❤️ usando Symfony 7.2

Para soporte: [soporte@apusystem.com](mailto:soporte@apusystem.com)

---

## 🗺️ Roadmap

- [ ] Implementación completa de recovery codes 2FA
- [ ] Dashboard con gráficos y estadísticas
- [ ] Exportación de APUs a Excel/PDF
- [ ] Integración con APIs de proveedores de materiales
- [ ] App móvil (React Native)
- [ ] Notificaciones en tiempo real
- [ ] Reportes personalizados
- [ ] Integración con sistemas de facturación

---

## 📊 Estado del Proyecto

![Status](https://img.shields.io/badge/Status-En%20Desarrollo-yellow)
![Version](https://img.shields.io/badge/Version-1.0.0--beta-blue)
![Last Commit](https://img.shields.io/badge/Last%20Commit-marzo%202026-green)

**Última actualización:** Marzo 2026
