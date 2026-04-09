# 🏗️ APU System - Sistema de Análisis de Precios Unitarios

Sistema multi-tenant para análisis y gestión de APUs (Análisis de Precios Unitarios) en proyectos de construcción.

[![Symfony](https://img.shields.io/badge/Symfony-7.2-000000?logo=symfony)](https://symfony.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)](https://mysql.com)
[![License](https://img.shields.io/badge/License-Proprietary-red)]()

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

- Creación y gestión de APUs
- Proyectos multi-empresa
- Catálogo de materiales, mano de obra y equipos
- Plantillas reutilizables
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

- **PHP** 8.2 o superior
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

```bash
php bin/console lexik:jwt:generate-keypair
```

---

## 💻 Uso

### Acceso Web

```
http://localhost:8000
```

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
```

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

- [Arquitectura de Roles](docs/ROLES_ARCHITECTURE.md) - Explicación detallada de SUPER_ADMIN, ADMIN y USER
- [Sistema Multi-Tenant](docs/MULTI_TENANT.md) - Por qué NO usamos subdominios
- [API REST](docs/API.md) - Documentación de endpoints

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
# Ejecutar todos los tests
php bin/phpunit

# Tests específicos
php bin/phpunit tests/Controller/SecurityControllerTest.php

# Con cobertura
php bin/phpunit --coverage-html coverage/
```

---

## 🐛 Troubleshooting

### Error: "Table recovery_codes doesn't exist"

Este es un problema conocido. La funcionalidad de recovery codes está temporalmente deshabilitada. Los códigos de recuperación 2FA se implementarán en una futura versión.

### Timezone no se guarda

Asegúrate de que el formulario de preferencias NO envíe valores duplicados. El bug fue corregido en la versión actual.

### Subdominios no funcionan

El sistema NO usa subdominios. Todos los usuarios acceden a la misma URL (`apusystem.com`). La identificación de empresa se hace por sesión.

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
