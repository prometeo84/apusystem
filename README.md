# APU System — Análisis de Precios Unitarios

Sistema multi-tenant para gestión de APUs (Análisis de Precios Unitarios) en proyectos de construcción.

**Stack:** Symfony 7.2 · PHP 8.3 · MySQL 8.0 · Docker · Vite · Bootstrap 5

---

## Características

- **Multi-tenant** — aislamiento completo de datos por empresa, sin subdominios
- **Autenticación** — 2FA (TOTP), WebAuthn, remember-me con tokens persistentes
- **Roles** — SUPER_ADMIN · ADMIN · USER con jerarquía estricta
- **APUs y Proyectos** — flujo `Proyectos → Plantillas → Rubros → APU → Reporte (PDF/Excel)`
- **API REST** — integración con Autodesk Revit (JWT)
- **Internacionalización** — Español e Inglés, zona horaria configurable por usuario
- **Seguridad** — rate limiting, bloqueo de IPs, logs de auditoría, CSRF, OWASP A01–A10

---

## Requisitos

- PHP 8.3+ (ext-pdo_mysql, ext-mbstring, ext-intl, ext-gd, ext-ctype, ext-json)
- Composer 2.x
- MySQL 8.0+
- Node.js 18+ / npm
- Docker + Docker Compose (recomendado)

---

## Instalación rápida (Docker)

```bash
cp .env.dist .env.dev          # editar con valores reales
docker compose up -d
docker exec apache composer install
docker exec apache php bin/console doctrine:migrations:migrate --no-interaction
```

## Instalación sin Docker

```bash
composer install
# Configurar DATABASE_URL en .env
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php -S localhost:8000 -t public/
```

---

## Configuración

Copia `.env.dist` a `.env.dev` (desarrollo) y completa los valores. No commitear secretos.

Variables mínimas:

```bash
APP_ENV=prod
APP_SECRET=<aleatorio-fuerte>
DATABASE_URL="mysql://user:pass@host:3306/apu_system?serverVersion=8.0"
MAILER_DSN=smtp://user:pass@smtp.host:587
JWT_SECRET_KEY=%kernel.project_dir%/config/certs/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/certs/public.pem
DEFAULT_TIMEZONE=America/Guayaquil
```

---

## Usuarios de prueba

| Rol         | Email          | Password  |
| ----------- | -------------- | --------- |
| SUPER_ADMIN | admin@demo.com | Admin123! |
| ADMIN       | admin@abc.com  | Admin123! |
| USER        | user@abc.com   | Admin123! |

> Cambiar todas las contraseñas en producción.

---

## API Revit

```http
POST /api/revit/authenticate   — obtener JWT
POST /api/revit/upload         — subir archivo .rvt
GET  /api/revit/files/{id}     — estado de procesamiento
```

Ver [docs/04-API_REVIT.md](docs/04-API_REVIT.md) para ejemplos completos.

---

## Desarrollo

```bash
# Caché
php bin/console cache:clear

# Migraciones
php bin/console doctrine:migrations:migrate

# Rutas
php bin/console debug:router

# Análisis estático
docker exec apache php -d memory_limit=512M vendor/bin/phpstan analyse

# Tests PHPUnit (dentro del contenedor para acceso a MySQL)
docker exec apache php bin/phpunit --no-coverage

# Tests E2E (requiere app en localhost:8080)
npx playwright test --project=chromium
```

### Tests actuales

**202 tests · 382 assertions · 0 fallos**

| Grupo                           | Tests |
| ------------------------------- | ----- |
| Seguridad (RBAC + sanitización) | 21    |
| Timezone / L10n                 | 12    |
| CRUD + cascadas                 | 7     |
| WebAuthn / 2FA / Encryption     | 30    |
| APU, Plantilla, Entidades       | 35    |
| Traducciones, CSRF, Sesiones    | 15    |
| Otros (User, Tenant, Commands…) | 82    |

---

## CRON (cron-job.org)

Endpoint `POST /cron/run` con cabecera `X-Cron-Api-Key`. Ver [docs/CRON.md](docs/CRON.md).

---

## Documentación

| Documento                                                | Contenido                       |
| -------------------------------------------------------- | ------------------------------- |
| [docs/01-ARQUITECTURA.md](docs/01-ARQUITECTURA.md)       | Diseño técnico y multi-tenant   |
| [docs/02-GUIA_USUARIO.md](docs/02-GUIA_USUARIO.md)       | Uso, credenciales de prueba     |
| [docs/03-SEGURIDAD_OWASP.md](docs/03-SEGURIDAD_OWASP.md) | Checklist OWASP A01–A10         |
| [docs/04-API_REVIT.md](docs/04-API_REVIT.md)             | API REST para Revit             |
| [docs/05-DESARROLLO.md](docs/05-DESARROLLO.md)           | Comandos y arquitectura interna |
| [docs/QA_AUDIT_REPORT.md](docs/QA_AUDIT_REPORT.md)       | Auditoría QA                    |

---

## Licencia

Software propietario. Copyright © 2026 APU System.

Sistema multi-tenant para análisis y gestión de APUs (Análisis de Precios Unitarios) en proyectos de construcción.

[![Symfony](https://img.shields.io/badge/Symfony-7.2-000000?logo=symfony)](https://symfony.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)](https://mysql.com)
[![License](https://img.shields.io/badge/License-Proprietary-red)]()

[![CI - Tests](https://github.com/prometeo84/apusystem/actions/workflows/ci-tests.yml/badge.svg?branch=main)](https://github.com/prometeo84/apusystem/actions/workflows/ci-tests.yml)
[![Validators Suite](https://github.com/prometeo84/apusystem/actions/workflows/validators.yml/badge.svg?branch=main)](https://github.com/prometeo84/apusystem/actions/workflows/validators.yml)
[![CodeQL](https://github.com/prometeo84/apusystem/actions/workflows/codeql-analysis.yml/badge.svg?branch=main)](https://github.com/prometeo84/apusystem/actions/workflows/codeql-analysis.yml)
[![Snyk Security](https://github.com/prometeo84/apusystem/actions/workflows/snyk-scan.yml/badge.svg?branch=main)](https://github.com/prometeo84/apusystem/actions/workflows/snyk-scan.yml)
