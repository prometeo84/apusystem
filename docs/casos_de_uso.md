# Casos de Uso — APU System

**Versión:** 2026-04-10  
**Stack:** Symfony 7 / PHP 8.3 / Playwright / PHPUnit 11.5  
**Cobertura:** 113 tests unitarios + 39 tests E2E  

---

## 1. Tabla de Casos de Uso

| ID | Módulo | Caso de Uso | Actor | Estado |
|----|--------|-------------|-------|--------|
| UC-01 | Seguridad | Política de contraseñas (12+, mayús, mín, dígito, símbolo) | Sistema | ✅ |
| UC-02 | Seguridad | Encriptación AES-256-GCM para TOTP secrets | Sistema | ✅ |
| UC-03 | Seguridad | WebAuthn FIDO2: registro e inicio biométrico | Usuario | ✅ |
| UC-04 | Usuarios | Bloqueo por 5 intentos, roles jerárquicos, UUID v4 | Usuario/Admin | ✅ |
| UC-05 | Multi-tenant | Gestión de Tenant: UUID, plan, límites, activación | Super Admin | ✅ |
| UC-06 | Seguridad | Protección CSRF automática en todos los POST | Sistema | ✅ |
| UC-07 | Acceso | Rutas protegidas redirigen a `/login` sin sesión | Visitante | ✅ |
| UC-08 | Acceso | Login exitoso redirige al dashboard | Usuario | ✅ |
| UC-09 | Acceso | Rutas públicas accesibles sin autenticación | Visitante | ✅ |
| UC-10 | Seguridad | CSRF token en todos los formularios POST | Usuario | ✅ |
| UC-11 | Admin | Paginación: máx 20 ítems por página | Admin | ✅ |
| UC-12 | WebAuthn | API WebAuthn: challenge/error JSON estructurado | Usuario FIDO2 | ✅ |
| UC-13 | i18n | Cambio de idioma en `/set-locale/{locale}` | Usuario | ✅ |
| UC-14 | API | API REST Revit: JWT, retorna JSON para errores | Plugin Revit | ✅ |
| UC-P1 | Proyectos | CRUD proyectos con código, cliente, ubicación, estado | Usuario | ✅ |
| UC-P2 | Proyectos | Duplicar proyecto (estructura sin APUs) | Usuario | ✅ |
| UC-R1 | Rubros | CRUD rubros personalizados (código, nombre, unidad, tipo) | Usuario | ✅ |
| UC-R2 | Rubros | Catálogo de rubros por tenant: generale y personalizados | Sistema | ✅ |
| UC-PL1 | Plantillas | CRUD plantillas dentro de un proyecto | Usuario | ✅ |
| UC-PL2 | Plantillas | Agregar/quitar rubros a plantilla; sin duplicados | Usuario | ✅ |
| UC-PL3 | Plantillas | Duplicar plantilla (mismos rubros, sin APUs) | Usuario | ✅ |
| UC-A1 | APU | Crear APU (Equipo, Labor, Materiales, Transporte) con cálculo automático | Usuario | ✅ |
| UC-A2 | APU | Editar APU con todos los ítems pre-cargados | Usuario | ✅ |
| UC-A3 | APU | Guardar utilidadPct y precioOfertado en APU | Usuario | ✅ |
| UC-A4 | APU | Crear APU desde Plantilla/Rubro con campo pre-llenado | Usuario | ✅ |
| UC-T1 | Tema | Guardar color primario y secundario por usuario | Usuario | ✅ |
| UC-T2 | Tema | CSS variables `--primary-color` aplicadas en base y front | Sistema | ✅ |
| UC-T3 | Tema | Modo oscuro/claro/auto por usuario | Usuario | ✅ |
| UC-T4 | Tema | Restablecer tema a valores por defecto | Usuario | ✅ |
| UC-REP1 | Reportes | Reporte PDF por plantilla | Usuario | ✅ |
| UC-REP2 | Reportes | Reporte Excel por plantilla | Usuario | ✅ |
| UC-REP3 | Reportes | Reporte PDF completo del proyecto (todas plantillas) | Usuario | ✅ |
| UC-REP4 | Reportes | Reporte Excel completo del proyecto | Usuario | ✅ |

---

## 2. Suite de Tests

### 2.1 Tests Unitarios PHPUnit — 113 tests / 147 assertions

| Archivo | Clase | Tests |
|---------|-------|-------|
| `tests/Unit/Service/PasswordPolicyServiceTest.php` | PasswordPolicyServiceTest | 12 |
| `tests/Unit/Service/EncryptionServiceTest.php` | EncryptionServiceTest | 9 |
| `tests/Unit/Service/WebAuthnServiceTest.php` | WebAuthnServiceTest | 16 |
| `tests/Unit/Entity/UserTest.php` | UserTest | 21 |
| `tests/Unit/Entity/TenantTest.php` | TenantTest | 8 |
| `tests/Unit/EventListener/CsrfProtectionSubscriberTest.php` | CsrfProtectionSubscriberTest | 14 |
| `tests/Unit/Entity/RubroTest.php` | RubroTest | 9 |
| `tests/Unit/Entity/APUItemTest.php` | APUItemTest | 16 |
| `tests/Unit/Entity/PlantillaTest.php` | PlantillaTest | 8 |
| **Total** | | **113** |

### 2.2 Tests E2E Playwright — 39 tests

| Archivo | Suite | Descripción | Tests |
|---------|-------|-------------|-------|
| `tests/E2E/app.spec.js` | UC-07 a UC-14 | Autenticación, roles, CSRF, idioma, API | 21 |
| `tests/E2E/apu-hierarchy.spec.js` | UC-H01 a UC-H09 | Flujo jerárquico APU, reportes, IDOR | 18 |
| `tests/E2E/theme-colors.spec.js` | UC-T1 a UC-T4 | Colores primario/secundario por tipo de usuario | — |

---

## 3. Datos de Prueba

| Rol | Email | Password | Empresa |
|-----|-------|----------|---------|
| SUPER_ADMIN | admin@demo.com | Admin123! | Demo |
| ADMIN | admin@abc.com | Admin123! | ABC |
| USER | user@abc.com | Admin123! | ABC |

---

## 4. Bug Corregido — Colores Tema

**Fecha:** 2026-04-10  
**Severidad:** Alta — los colores personalizados no se aplicaban al UI

**Causa:** `assets/styles/app.css` definía `--primary-color` y `--secondary-color` en `:root` con valores hardcodeados. Dado que el CSS de Vite se carga DESPUÉS del `<style>` inline dinámico en `base.html.twig`, sobreescribía los colores del usuario.

**Fix aplicado:**
1. Se eliminaron `--primary-color` y `--secondary-color` de `app.css`
2. Se movió `{{ vite_entry_link_tags('app') }}` ANTES del `<style>` dinámico en `base.html.twig`

**Flujo correcto:**
```
[1] Bootstrap CDN
[2] Vite app.css (sin vars de color)
[3] <style> dinámico con --primary-color del usuario  ← gana
```

---

## 5. Arquitectura del Tema

```
Usuario guarda color → DB (users.theme_primary_color)
       ↓
ThemeSubscriber (priority=0) lee token → getThemePrimaryColor()
       ↓
twig->addGlobal('user_theme', ['primary_color' => '#rrggbb'])
       ↓
base.html.twig: :root { --primary-color: #rrggbb; }
       ↓
CSS elementos usan var(--primary-color)
```

**Fallback:** usuario → tenant → sistema (#667eea)

