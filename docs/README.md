# 📚 Documentación - Sistema APU

Bienvenido a la documentación técnica del Sistema de Análisis de Precios Unitarios (APU).

## 📖 Estructura de la Documentación

### 1. [📐 Arquitectura](01-ARQUITECTURA.md)

Arquitectura multi-tenant, jerarquía de roles y estructura del sistema.

### 2. [👤 Guía de Usuario](02-GUIA_USUARIO.md)

Guía completa: credenciales de prueba, flujo APU jerárquico, personalización, seguridad 2FA.

### 3. [🔒 Seguridad OWASP](03-SEGURIDAD_OWASP.md)

Análisis y validación OWASP Top 10 — 10/10 cumplidos.

### 4. [🔌 API Revit](04-API_REVIT.md)

Integración BIM con Autodesk Revit via API REST.

### 5. [⚙️ Desarrollo](05-DESARROLLO.md)

Guía para desarrolladores, comandos útiles y configuración.

### 6. [🧪 Casos de Uso & QA](casos_de_uso.md) ← **NUEVO**

Tabla completa de casos de uso UC-01..UC-H09, resultados de pruebas PHPUnit/Playwright.

---

## 🏗️ Flujo Principal del Sistema

```
LOGIN → PROYECTOS → PLANTILLAS → RUBROS → APU → REPORTE (PDF/Excel)
```

## 🚀 Inicio Rápido

```bash
docker compose up -d
# App disponible en http://localhost
# Admin: admin@demo.com / Admin123!
```

## 🗓️ Versión

**Stack:** Symfony 7 / PHP 8.3 / MySQL 8 / Bootstrap 5
**Tests:** 113 PHPUnit + 39 Playwright E2E

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
