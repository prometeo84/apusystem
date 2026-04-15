# 👤 Guía de Usuario - Sistema APU

Guía completa para usuarios del Sistema de Análisis de Precios Unitarios.

---

## 🔐 Credenciales de Prueba

### Usuarios Predefinidos

El sistema incluye 3 usuarios de prueba con diferentes niveles de acceso:

| Rol             | Email            | Password    | Empresa      | Descripción                        |
| --------------- | ---------------- | ----------- | ------------ | ---------------------------------- |
| **SUPER_ADMIN** | `admin@demo.com` | `Admin123!` | Empresa Demo | Administrador del sistema completo |
| **ADMIN**       | `admin@abc.com`  | `Admin123!` | ABC          | Administrador de empresa ABC       |
| **USER**        | `user@abc.com`   | `Admin123!` | ABC          | Usuario regular de empresa ABC     |

⚠️ **IMPORTANTE:** Cambiar todas las contraseñas en producción.

### Empresas (Tenants) Disponibles

#### Empresa Demo

- **Slug:** `demo`
- **Plan:** Professional
- **Máx. Usuarios:** 20
- **Máx. Proyectos:** 50
- **Admin:** admin@demo.com (SUPER_ADMIN del sistema)

#### Empresa ABC

- **Slug:** `abc`
- **Plan:** Professional
- **Máx. Usuarios:** 50
- **Máx. Proyectos:** 100
- **Almacenamiento:** 10 GB
- **Usuarios:**
    - Admin: admin@abc.com
    - Usuario: user@abc.com

---

## 🧪 Escenarios de Prueba

### Prueba 1: Login como Super Administrador

```
URL: http://localhost/login
Email: admin@demo.com
Password: Admin123!
```

**Verifica:**

- ✅ Acceso a "System Panel"
- ✅ Ver todas las empresas
- ✅ Monitoreo global
- ✅ NO tiene sección "Quick Actions" en System Panel
- ✅ Badge "Administrador del Sistema" en sidebar

### Prueba 2: Login como Administrador de Empresa

```
URL: http://localhost/login
Email: admin@abc.com
Password: Admin123!
```

**Verifica:**

- ✅ Acceso a "Administration Panel"
- ✅ Sección "Quick Actions" visible
- ✅ Solo ve usuarios de empresa ABC
- ✅ Puede crear usuarios
- ✅ Ve logs de seguridad de su empresa únicamente

### Prueba 3: Login como Usuario Regular

```
URL: http://localhost/login
Email: user@abc.com
Password: Admin123!
```

**Verifica:**

- ✅ NO ve panel de administración
- ✅ Solo acceso a Dashboard
- ✅ Puede ver APUs
- ✅ NO puede crear usuarios
- ✅ NO ve configuraciones de empresa

---

## �️ Flujo Principal: Proyecto → Plantilla → Rubro → APU → Reporte

### Prueba 4: Crear un Proyecto

```
URL: http://localhost/projects/new
```

**Pasos:**

1. Click en "Proyectos" en el sidebar
2. Click en "Nuevo Proyecto"
3. Completar: Nombre, Código, Cliente, Ubicación, Estado
4. Guardar → redirige al detalle del proyecto

**Verifica:**

- ✅ El proyecto aparece en la lista con su código
- ✅ El botón "Reporte Completo" está disponible (aunque sin plantillas)
- ✅ El botón "Duplicar" genera una copia con sufijo `(copia)`

### Prueba 5: Crear Rubros Personalizados

```
URL: http://localhost/rubros
```

**Pasos:**

1. Click en "Rubros" en el sidebar
2. Click en "Nuevo Rubro"
3. Completar: Código, Nombre, Descripción, Unidad, Tipo
4. Guardar

**Verifica:**

- ✅ El rubro aparece en la lista con su tipo (badge)
- ✅ Se puede editar y eliminar (eliminar protegido si está en uso)

### Prueba 6: Crear Plantilla y Asignar Rubros

```
URL: http://localhost/projects/{id}/templates/create
```

**Pasos:**

1. Abrir un proyecto → click en "Ver Plantillas" o tab Plantillas
2. Click en "Nueva Plantilla"
3. Ingresar nombre y descripción → Guardar
4. En la vista de plantilla, seleccionar un rubro del dropdown → click "Agregar Rubro"
5. Repetir para varios rubros
6. Ingresar la cantidad de cada rubro en la tabla

**Verifica:**

- ✅ Los rubros aparecen en la tabla con su estado (⚠ Sin APU o ✓ APU completo)
- ✅ El total de la plantilla se actualiza en tiempo real
- ✅ No se puede agregar el mismo rubro dos veces a la misma plantilla

### Prueba 7: Crear APU para un Rubro

**Pasos:**

1. En la tabla de la plantilla, click en "Crear APU" del rubro deseado
2. Completar la descripción (pre-llenada con el nombre del rubro) y unidad
3. Ingresar K(H/U) y Rendimiento
4. Agregar filas de **Equipo**, **Mano de Obra**, **Materiales** y **Transporte**
5. El panel de resumen calcula automáticamente los costos
6. Ingresar % de Utilidad → el Precio de Cálculo se actualiza
7. El Precio Ofertado se sugiere automáticamente (editable)
8. Click "Guardar" → regresa a la plantilla

**Verifica:**

- ✅ La columna "Precio Unit." y "Subtotal" se llenan en la plantilla
- ✅ El total de la plantilla se actualiza

### Prueba 8: Editar APU existente

**Pasos:**

1. En la tabla de la plantilla, click en el ícono de edición del rubro con APU
2. El formulario se pre-llena con todos los datos: equipo, labor, materiales, transporte
3. El panel de resumen muestra los costos actuales
4. El % de Utilidad y el Precio Ofertado se pre-llenan con los valores guardados
5. Modificar valores → Guardar → regresa a la plantilla

**Verifica:**

- ✅ Todos los campos tienen los valores previos al entrar
- ✅ Al guardar, los costos en la plantilla reflejan los cambios
- ✅ El breadcrumb muestra la ruta Proyecto → Plantilla → Editar APU

### Prueba 9: Generar Reporte

**Reporte por plantilla:**

1. En la vista de una plantilla, click en "Reporte" (ícono verde)
2. Vista previa HTML del presupuesto
3. Botones: "Descargar PDF" y "Descargar Excel"

**Reporte completo del proyecto:**

1. En la vista del proyecto, click en "Reporte Completo del Proyecto" (botón verde)
2. Vista previa agrupa todas las plantillas con sus rubros
3. Muestra subtotal por plantilla y **TOTAL GENERAL** del proyecto
4. Botones: "Descargar PDF" y "Descargar Excel"

**Verifica:**

- ✅ El PDF contiene tabla de rubros con precios correctos
- ✅ El Excel tiene hojas con estilos y formato moneda
- ✅ El reporte completo muestra el total sumado de todas las plantillas

### Prueba 10: Duplicar Proyecto

**Pasos:**

1. En el detalle de un proyecto, click en "Duplicar"
2. Se crea una copia con sufijo `(copia)` en el nombre
3. Las plantillas y rubros se copian **sin los APUs** (estructura vacía)

**Verifica:**

- ✅ El proyecto duplicado aparece en la lista
- ✅ Tiene las mismas plantillas con los mismos rubros
- ✅ Los rubros tienen estado "⚠ Sin APU" (cada APU debe crearse de nuevo)

### 1. Cambiar Idioma

**Ubicación:** Perfil → Preferencias → Idioma

**Idiomas disponibles:**

- 🇪🇸 Español
- 🇬🇧 English

**Proceso:**

1. Ir a "My Profile" (Mi Perfil)
2. Click en "Preferences" (Preferencias)
3. Seleccionar idioma en dropdown
4. Click "Save Preferences"
5. La interfaz cambia inmediatamente

### 2. Cambiar Zona Horaria

**Ubicación:** Perfil → Preferencias → Timezone

**Zonas disponibles (22):**

- America/Guayaquil (Ecuador)
- America/Bogota (Colombia)
- America/Lima (Perú)
- America/Buenos_Aires (Argentina)
- America/Mexico_City (México)
- America/Santiago (Chile)
- America/Caracas (Venezuela)
- America/New_York (USA Este)
- America/Los_Angeles (USA Oeste)
- Europe/Madrid (España)
- ... y 12 más

**Proceso:**

1. Ir a "Preferences"
2. Seleccionar timezone
3. Click "Guardar Preferencias"
4. Todas las fechas/horas se muestran en esa zona

⚠️ **Nota:** Las fechas se guardan en UTC en la base de datos y se convierten automáticamente.

### 3. Personalizar Tema

**Ubicación:** Perfil → Preferencias → Personalización de Tema

**Opciones:**

- **Color Primario:** Selector de color (hex)
- **Color Secundario:** Selector de color (hex)
- **Vista Previa:** Muestra cambios en tiempo real

**Proceso:**

1. Ir a "Preferences"
2. Scroll hasta "Theme Customization"
3. Click en selector de color primario
4. Elegir color (ej: #3498db)
5. Repetir con color secundario
6. Click "Apply Theme"
7. El tema cambia inmediatamente

**Restablecer tema:**

- Click en "Reset to Default Theme"

---

## 🔒 Seguridad

### Activar Autenticación de Dos Factores (2FA)

#### ¿Por qué usar 2FA?

- ✅ Protección adicional contra accesos no autorizados
- ✅ Obligatorio para administradores en producción
- ✅ Usa Google Authenticator, Authy, o similar

#### Habilitar 2FA

**Proceso:**

1. **Ir a Seguridad**
    - Perfil → Security → Two-Factor Authentication

2. **Habilitar 2FA**
    - Click en "Enable 2FA"
    - Sistema genera secreto TOTP y código QR

3. **Escanear Código QR**
    - Abrir Google Authenticator o Authy en tu móvil
    - Escanear el código QR mostrado
    - O ingresar manualmente el secreto

4. **Verificar**
    - Ingresar el código de 6 dígitos de la app
    - Click "Verify and Enable"

5. **Guardar Códigos de Recuperación**
    - Sistema genera 10 códigos de recuperación
    - **IMPRESCINDIBLE:** Guardarlos en lugar seguro
    - Cada código es de un solo uso
    - Úsalos si pierdes el dispositivo

**Ejemplo de códigos de recuperación:**

```
a1b2c3d4e5f6g7h8
i9j0k1l2m3n4o5p6
q7r8s9t0u1v2w3x4
...
```

#### Usar 2FA en Login

1. Ingresar email y password
2. Sistema solicita código TOTP
3. Abrir Google Authenticator
4. Ingresar código de 6 dígitos (válido 30 segundos)
5. Click "Verify"

#### Usar Código de Recuperación

Si perdiste tu dispositivo:

1. En login, click "Use Recovery Code"
2. Ingresar uno de los códigos guardados
3. El código se marca como usado
4. **Regenera códigos** inmediatamente después

#### Deshabilitar 2FA

1. Perfil → Security
2. Click "Disable 2FA"
3. Confirmar con código TOTP o recovery code

---

### Cambiar Contraseña

**Ubicación:** Perfil → Seguridad → Cambiar Contraseña

**Requisitos:**

- Mínimo 8 caracteres
- Al menos 1 mayúscula
- Al menos 1 minúscula
- Al menos 1 número
- Al menos 1 carácter especial (@, #, $, etc.)

**Proceso:**

1. Ingresar contraseña actual
2. Ingresar nueva contraseña
3. Confirmar nueva contraseña
4. Click "Change Password"
5. Sistema valida requisitos
6. Contraseña actualizada (hash bcrypt)

### Recuperar Contraseña Olvidada

**Proceso:**

1. **Solicitar Recuperación**
    - En login, click "¿Olvidaste tu contraseña?"
    - Ingresar email registrado
    - Click "Send Reset Link"

2. **Revisar Correo**
    - Sistema envía email con token
    - Token válido por 1 hora
    - Click en el link del email

3. **Restablecer**
    - Ingresar nueva contraseña
    - Confirmar nueva contraseña
    - Click "Reset Password"
    - Redirige a login

**Entorno de desarrollo:**

- Mailpit captura emails: `http://localhost:8025`
- Revisar inbox para ver el correo

---

## 📧 Sistema de Correo (Desarrollo)

### Mailpit

El sistema usa **Mailpit** para desarrollo (SMTP mock).

**Acceso:** `http://localhost:8025`

**Funcionalidades:**

- Ver todos los emails enviados
- Preview HTML y texto plano
- Ver headers completos
- Eliminar emails

**Emails enviados por el sistema:**

- Recuperación de contraseña
- Bienvenida a nuevos usuarios (futuro)
- Alertas críticas (futuro)

### Configuración (.env)

```bash
MAILER_DSN=smtp://mailpit:1025
```

**Producción:** Cambiar a SMTP real (Gmail, SendGrid, etc.)

---

## 📊 Visualizar APUs

### Dashboard Principal

**Ubicación:** Inicio → Dashboard

**Contenido:**

- Resumen de proyectos activos
- APUs recientes
- Estadísticas de uso

### Ver APU Individual

1. Ir a "Projects" (Proyectos)
2. Click en un proyecto
3. Ir a pestaña "APUs"
4. Click en APU para ver detalle

**Información mostrada:**

- Código de APU
- Descripción
- Unidad
- Partidas:
    - Materiales (cantidad, precio unitario, precio total)
    - Mano de obra (cantidad, precio/hora, precio total)
    - Equipos (cantidad, precio, precio total)
    - Transporte (distancia, precio, precio total)
- **Precio Total del APU**

---

## 🛠️ Crear y Editar APUs (Admin/User)

### Crear Nuevo APU

**Permisos:** ADMIN o USER con permisos

**Proceso:**

1. **Crear Proyecto**
    - Dashboard → Projects → Create Project
    - Nombre, descripción, fecha inicio

2. **Crear APU**
    - Dentro del proyecto → APUs → Create APU
    - Código (ej: A-001)
    - Descripción (ej: "Excavación manual")
    - Unidad (m³, m², kg, etc.)

3. **Agregar Partidas**

    **Materiales:**
    - Click "Add Material"
    - Nombre, cantidad, precio unitario
    - Precio total = cantidad × precio unitario

    **Mano de Obra:**
    - Click "Add Labor"
    - Tipo (oficial, peón, maestro)
    - Horas, precio/hora

    **Equipos:**
    - Click "Add Equipment"
    - Tipo, cantidad, precio/hora

    **Transporte:**
    - Click "Add Transport"
    - Distancia, precio/km

4. **Guardar APU**
    - Click "Save APU"
    - Sistema calcula precio total automáticamente

### Exportar a Excel

1. Ir a APU
2. Click "Export to Excel"
3. Descarga archivo .xlsx con:
    - Hoja 1: Resumen general
    - Hoja 2: Materiales
    - Hoja 3: Mano de obra
    - Hoja 4: Equipos
    - Hoja 5: Transporte

---

## 📝 Logs de Seguridad

### Ver Logs (ADMIN)

**Ubicación:** Administration → Security Logs

**Información mostrada:**

- Fecha/hora del evento
- Usuario que realizó la acción
- Tipo de evento (login, logout, cambio crítico)
- IP de origen
- Resultado (success/failed)

**Filtros:**

- Por usuario
- Por fecha
- Por tipo de evento

**Eventos registrados:**

- ✅ Login exitoso
- ❌ Login fallido (password incorrecto)
- 🔒 2FA habilitado/deshabilitado
- 🔑 Cambio de contraseña
- 👤 Creación de usuario
- 🏢 Modificación de empresa
- 🚫 Bloqueo de IP

### Ver Logs (SUPER_ADMIN)

**Ubicación:** System → Security Logs

**Diferencia:**

- Ve logs de **todas las empresas**
- Puede filtrar por empresa
- Más información (tenant_id, sistema global)

---

## 🔄 Resetear Contraseña (Desarrollo)

Si olvidaste la contraseña del super admin durante desarrollo:

```bash
cd database
./reset-admin-password.sh
```

Esto restablece:

- Email: `admin@demo.com`
- Password: `Admin123!`

---

## ⚙️ Comandos Útiles

### Limpiar Caché

```bash
docker exec apache php bin/console cache:clear
```

### Ver Rutas

```bash
docker exec apache php bin/console debug:router
```

### Ver Configuración

```bash
docker exec apache php bin/console debug:config
```

---

## ❓ Troubleshooting

### No puedo hacer login

**Posibles causas:**

1. Password incorrecto → Usar recuperación de contraseña
2. IP bloqueada → Esperar 15 minutos o contactar admin
3. 2FA habilitado pero no tengo código → Usar recovery code
4. Usuario inactivo → Contactar administrador

### No recibo email de recuperación

**Desarrollo:**

1. Verificar Mailpit: `http://localhost:8025`
2. Revisar logs: `docker logs apache`

**Producción:**

1. Verificar configuración SMTP en `.env`
2. Revisar logs de Symfony

### Timezone incorrecto

1. Ir a Perfil → Preferencias
2. Verificar zona horaria seleccionada
3. Guardar cambios
4. Refrescar página

### 2FA no funciona

**Código no válido:**

- Verificar hora del dispositivo (debe estar sincronizada)
- Código expira cada 30 segundos
- Usar recovery code si persiste

**Perdí dispositivo:**

1. Usar recovery code guardado
2. Deshabilitar 2FA
3. Configurar nuevo dispositivo
4. Regenerar códigos de recuperación

---

## 📱 Apps Recomendadas para 2FA

- **Google Authenticator** (iOS/Android) - Gratis
- **Authy** (iOS/Android/Desktop) - Gratis, sincronización multi-dispositivo
- **Microsoft Authenticator** (iOS/Android) - Gratis
- **1Password** (Pago) - Gestor de contraseñas + TOTP

---

## **Última actualización:** 19/03/2026
