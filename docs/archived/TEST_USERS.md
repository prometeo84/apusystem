# Usuarios de Prueba - APU System

Este documento contiene las credenciales de acceso para realizar pruebas en el sistema APU.

## 🔐 Credenciales de Acceso

### 1. Super Administrador del Sistema

**Gestiona todo el sistema, todas las empresas y configuraciones globales**

- **Email:** `admin@demo.com`
- **Usuario:** `admin`
- **Contraseña:** `Admin123!`
- **Rol:** `ROLE_SUPER_ADMIN`
- **Empresa:** Empresa Demo (slug: `demo`)
- **Permisos:**
    - Gestión de todas las empresas (tenants)
    - Configuración del sistema
    - Monitoreo global
    - Logs de seguridad de todo el sistema
    - Gestión de alertas globales
    - Configuración de errores del sistema

---

### 2. Administrador de Empresa ABC

**Administra solo la empresa ABC y sus usuarios**

- **Email:** `admin@abc.com`
- **Usuario:** `admin@abc.com`
- **Contraseña:** `Admin123!`
- **Rol:** `ROLE_ADMIN`
- **Empresa:** ABC (slug: `abc`)
- **Permisos:**
    - Gestión de usuarios de su empresa
    - Ver logs de seguridad de su empresa
    - Configurar datos de su empresa
    - Crear/editar APUs
    - Gestionar proyectos

---

### 3. Usuario Regular de Empresa ABC

**Usuario estándar con permisos limitados**

- **Email:** `user@abc.com`
- **Usuario:** `user@abc.com`
- **Contraseña:** `Admin123!`
- **Rol:** `ROLE_USER`
- **Empresa:** ABC (slug: `abc`)
- **Permisos:**
    - Ver APUs
    - Trabajar en proyectos asignados
    - Editar su perfil
    - Sin acceso a gestión de usuarios
    - Sin acceso a configuraciones de empresa

---

## 🧪 Escenarios de Prueba

### Prueba 1: Login como Super Admin

```bash
URL: http://localhost/login
Email: admin@demo.com
Password: Admin123!
```

Verifica:

- Acceso a "System Panel"
- Ver todas las empresas
- Monitoreo global
- Sin sección "Quick Actions" en System Panel

### Prueba 2: Login como Admin de Empresa

```bash
URL: http://localhost/login
Email: admin@abc.com
Password: Admin123!
```

Verifica:

- Acceso a "Administration Panel"
- Sección "Quick Actions" visible
- Solo ve usuarios de su empresa ABC
- Puede crear usuarios
- Ve logs de su empresa únicamente

### Prueba 3: Login como Usuario Regular

```bash
URL: http://localhost/login
Email: user@abc.com
Password: Admin123!
```

Verifica:

- NO ve panel de administración
- Solo acceso a Dashboard
- Puede ver APUs
- NO puede crear usuarios
- NO ve configuraciones

---

## 🔄 Cambio de Contraseña (Desarrollo)

Si necesitas resetear la contraseña del super admin:

```bash
cd database
./reset-admin-password.sh
```

Esto restablecerá la contraseña de `admin@demo.com` a `Admin123!`

---

## 📊 Hash de Contraseñas

Todas las contraseñas están hasheadas con bcrypt (coste 13):

```
Admin123! → $2y$13$8K1p/H9OujiUdXnEjI0K.OLm7.3VaQ8KqJnL0BVQZ7yfhg.YJfF0S
```

Para generar un nuevo hash en PHP:

```php
password_hash('Admin123!', PASSWORD_DEFAULT);
```

---

## 🗂️ Empresas (Tenants) Disponibles

### Empresa Demo

- **Nombre:** Empresa Demo
- **Slug:** `demo`
- **Plan:** Professional
- **Máx. Usuarios:** 20
- **Máx. Proyectos:** 50
- **Admin:** admin@demo.com (SUPER_ADMIN)

### Empresa ABC

- **Nombre:** ABC
- **Slug:** `abc`
- **Plan:** Professional
- **Máx. Usuarios:** 50
- **Máx. Proyectos:** 100
- **Almacenamiento:** 10GB
- **Admin:** admin@abc.com
- **Usuario:** user@abc.com

---

## 🔒 Autenticación 2FA (Opcional)

Los usuarios pueden habilitar autenticación de dos factores desde:

- **Perfil** → **Security** → **Enable 2FA**

Códigos de recuperación se generan automáticamente y se guardan hasheados en tabla `recovery_codes`.

---

## 📝 Notas de Seguridad

⚠️ **IMPORTANTE:** Estas credenciales son SOLO para desarrollo y testing.

En **producción**:

1. Cambiar TODAS las contraseñas
2. Eliminar usuarios de prueba
3. Usar contraseñas seguras (min. 12 caracteres)
4. Habilitar 2FA obligatorio para admins
5. Revisar logs de acceso regularmente

---

## 🛠️ Resetear Base de Datos

Para volver al estado inicial con estos usuarios:

```bash
cd database
./init.sh  # Recrea schema + datos iniciales
mysql -u root -proot apu_system < insert-abc-company.sql  # Añade empresa ABC
```

---

**Última actualización:** 19 de marzo de 2026
