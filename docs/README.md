# 📚 Documentación - Sistema APU

Bienvenido a la documentación técnica del Sistema de Análisis de Precios Unitarios (APU).

## 📖 Estructura de la Documentación

### 1. [📐 Arquitectura](01-ARQUITECTURA.md)

Arquitectura multi-tenant, jerarquía de roles y estructura del sistema.

- Sistema multi-tenant basado en sesión
- 3 niveles de roles: SUPER_ADMIN, ADMIN, USER
- Estructura de base de datos y stack tecnológico

### 2. [👤 Guía de Usuario](02-GUIA_USUARIO.md)

Guía completa para usuarios del sistema.

- Personalización (idioma, zona horaria, temas)
- Seguridad (2FA, recuperación de contraseña)
- **Credenciales de prueba** para testing
- Sistema de correo y notificaciones

### 3. [🔒 Seguridad OWASP](03-SEGURIDAD_OWASP.md)

Análisis y validación de seguridad según OWASP Top 10 2026.

- Análisis inicial de vulnerabilidades
- Correcciones implementadas
- Validación y cumplimiento (10/10)
- Código de implementación

### 4. [🔌 API Revit](04-API_REVIT.md)

Integración con Autodesk Revit mediante API REST.

- Endpoints de autenticación y carga
- Cliente Python completo
- Ejemplos de uso

### 5. [⚙️ Desarrollo](05-DESARROLLO.md)

Guía para desarrolladores.

- Estado actual del proyecto
- Sistema APU completo
- Módulo Super Admin
- Comandos útiles y configuración

---

## 🚀 Quick Start

### Usuarios de Prueba

| Rol             | Email            | Password    |
| --------------- | ---------------- | ----------- |
| **SUPER_ADMIN** | `admin@demo.com` | `Admin123!` |
| **ADMIN**       | `admin@abc.com`  | `Admin123!` |
| **USER**        | `user@abc.com`   | `Admin123!` |

Ver detalles completos en [Guía de Usuario](02-GUIA_USUARIO.md).

---

## 📦 Información del Sistema

- **Framework:** Symfony 7.2
- **PHP:** 8.2+
- **Base de Datos:** MySQL 8.0
- **Estado:** Production Ready ✅
- **Última Actualización:** 19 de marzo de 2026

---

## 📂 Estructura del Proyecto

```
proyecto/
├── config/              # Configuración Symfony
├── docs/                # Esta documentación
├── migrations/          # Migraciones de BD
├── public/              # Assets públicos
├── src/                 # Código fuente
├── templates/           # Plantillas Twig
└── translations/        # i18n (ES/EN)
```

---

## 🔗 Enlaces Útiles

- [README Principal](../README.md)
- [Reporte de Errores](https://github.com/tuusuario/apu-system/issues)
- [Changelog](../CHANGELOG.md)

---

**Documentación generada:** 19/03/2026
