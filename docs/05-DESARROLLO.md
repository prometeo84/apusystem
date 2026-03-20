# ⚙️ Guía de Desarrollo - Sistema APU

Guía completa para desarrolladores del Sistema de Análisis de Precios Unitarios.

---

## 📊 Estado Actual del Proyecto

### ✅ Funcionalidades Implementadas (100%)

#### Sistema Core

- ✅ Arquitectura multi-tenant basada en sesión
- ✅ 3 niveles de roles (SUPER_ADMIN, ADMIN, USER)
- ✅ Autenticación 2FA con TOTP
- ✅ Recovery codes (10 códigos por usuario)
- ✅ Sistema de sesiones múltiples
- ✅ Internacionalización (Español/English)
- ✅ Personalización de temas y zonas horarias

#### Seguridad

- ✅ Security headers (10/10)
- ✅ Rate limiting (login, API)
- ✅ Encriptación AES-256-GCM
- ✅ Password hashing bcrypt
- ✅ CSRF protection
- ✅ Logs de seguridad completos
- ✅ Bloqueo automático de IPs

#### Módulo APU

- ✅ 5 entidades (APU, Materials, Labor, Equipment, Transport)
- ✅ Formulario dinámico multi-sección
- ✅ Cálculo automático de precios
- ✅ Exportación a Excel

#### Módulo Super Admin

- ✅ CRUD de empresas (tenants)
- ✅ Gestión de planes y vigencias
- ✅ Sistema de alertas (6 categorías)
- ✅ Monitoreo global
- ✅ Logs de todas las empresas

#### API Revit

- ✅ Autenticación JWT
- ✅ Upload de archivos Revit
- ✅ Cliente Python completo
- ✅ Validación de archivos

**Estado:** **PRODUCTION READY** ✅
**Fecha:** 19 de marzo de 2026

---

## 🗂️ Sistema APU Completo

### Entidades

#### 1. APU (Análisis de Precio Unitario)

```php
class APU
{
    private int $id;
    private Tenant $tenant;
    private Proyecto $proyecto;
    private string $codigo;           // Ej: "A-001"
    private string $descripcion;      // Ej: "Excavación manual"
    private string $unidad;           // Ej: "m³"
    private float $precioTotal;       // Calculado automáticamente
    private DateTime $createdAt;
    private Collection $items;        // APUItem[]
}
```

#### 2. APUItem (Partida)

```php
class APUItem
{
    private int $id;
    private APU $apu;
    private string $tipo;             // material, labor, equipment, transport
    private string $descripcion;
    private float $cantidad;
    private float $precioUnitario;
    private float $precioTotal;       // cantidad × precioUnitario
}
```

#### 3. APUMaterial

```php
class APUMaterial
{
    private int $id;
    private APU $apu;
    private string $nombre;
    private string $unidad;           // kg, m³, unidad, etc.
    private float $cantidad;
    private float $precioUnitario;
    private float $desperdicio;       // % (ej: 5% → 0.05)
}
```

#### 4. APULabor (Mano de Obra)

```php
class APULabor
{
    private int $id;
    private APU $apu;
    private string $categoria;        // oficial, peón, maestro, etc.
    private float $horas;
    private float $precioPorHora;
    private float $rendimiento;       // opcional
}
```

#### 5. APUEquipment

```php
class APUEquipment
{
    private int $id;
    private APU $apu;
    private string $nombre;
    private string $tipo;             // maquinaria, herramienta
    private float $cantidad;
    private float $precioHora;
    private float $horasUso;
}
```

### Servicio de Reportes (Excel)

```php
class APUReportService
{
    public function generateExcelReport(APU $apu): string
    {
        $spreadsheet = new Spreadsheet();

        // Hoja 1: Resumen
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Resumen');
        $sheet1->setCellValue('A1', 'Código APU');
        $sheet1->setCellValue('B1', $apu->getCodigo());
        // ...

        // Hoja 2: Materiales
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Materiales');
        // ...

        // Exportar
        $writer = new Xlsx($spreadsheet);
        $fileName = "APU_{$apu->getCodigo()}_" . date('YmdHis') . ".xlsx";
        $writer->save($fileName);

        return $fileName;
    }
}
```

### Formulario Dinámico

**Ubicación:** `templates/apu/edit.html.twig`

**Secciones:**

1. **Información General**
    - Código, Descripción, Unidad

2. **Materiales** (dinámico)
    - Botón "Add Material" añade fila
    - Inputs: Nombre, Unidad, Cantidad, Precio
    - Cálculo automático de subtotal

3. **Mano de Obra** (dinámico)
    - Categoría, Horas, Precio/Hora
    - Rendimiento opcional

4. **Equipos** (dinámico)
    - Nombre, Tipo, Horas, Precio

5. **Transporte** (dinámico)
    - Distancia, Precio/km

**JavaScript:**

```javascript
// Añadir nueva línea de material
document.getElementById('add-material').addEventListener('click', function () {
    const container = document.getElementById('materials-container');
    const newRow = materialTemplate.cloneNode(true);
    newRow.querySelector('.material-subtotal').textContent = '0.00';
    container.appendChild(newRow);
    updateTotal();
});

// Calcular total automáticamente
function updateTotal() {
    let total = 0;
    document.querySelectorAll('.item-subtotal').forEach((el) => {
        total += parseFloat(el.textContent);
    });
    document.getElementById('apu-total').textContent = total.toFixed(2);
}
```

---

## 🏢 Módulo Super Admin

### CRUD de Empresas (Tenants)

#### Crear Empresa

**Controller:** `SystemController::createTenantAction()`

```php
#[Route('/system/tenants/create', name: 'app_system_tenant_create')]
public function createTenant(Request $request): Response
{
    $tenant = new Tenant();
    $form = $this->createForm(TenantType::class, $tenant);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // Generar slug único
        $tenant->setSlug($this->slugger->slug($tenant->getName()));

        // Asignar plan por defecto
        $tenant->setPlan('professional');
        $tenant->setMaxUsers(50);
        $tenant->setMaxProjects(100);

        $this->em->persist($tenant);
        $this->em->flush();

        $this->addFlash('success', 'Empresa creada exitosamente');
        return $this->redirectToRoute('app_system_tenants');
    }

    return $this->render('system/tenant_create.html.twig', [
        'form' => $form,
    ]);
}
```

#### Gestión de Vigencia

**Campos:**

- `plan_start_date` - Inicio del plan
- `plan_end_date` - Fin del plan
- `is_active` - Estado activo/inactivo

**Alertas automáticas:**

- 30 días antes: "Plan por vencer"
- 7 días antes: "Plan próximo a vencer"
- Fecha pasada: "Plan vencido" → Bloquear empresa

```php
public function checkPlanExpiration(Tenant $tenant): ?Alert
{
    $today = new DateTime();
    $endDate = $tenant->getPlanEndDate();

    if (!$endDate) {
        return null;
    }

    $diff = $today->diff($endDate)->days;

    if ($endDate < $today) {
        return new Alert('critical', 'Plan vencido', $tenant);
    } elseif ($diff <= 7) {
        return new Alert('warning', 'Plan próximo a vencer', $tenant);
    } elseif ($diff <= 30) {
        return new Alert('info', 'Plan por vencer en 30 días', $tenant);
    }

    return null;
}
```

### Sistema de Alertas

**6 Categorías:**

1. **security** - Alertas de seguridad (intentos fallidos, IPs bloqueadas)
2. **system** - Errores del sistema (BD caída, logs llenos)
3. **tenant** - Problemas de empresas (límites alcanzados, planes vencidos)
4. **user** - Alertas de usuarios (usuarios inactivos, 2FA deshabilitado)
5. **storage** - Almacenamiento (95% usado, límite alcanzado)
6. **api** - Errores de API (rate limit, autenticación fallida)

**Tabla:**

```sql
CREATE TABLE alerts (
    id BIGINT PRIMARY KEY,
    category VARCHAR(20),       -- security, system, tenant, etc.
    severity VARCHAR(20),       -- info, warning, critical
    title VARCHAR(255),
    message TEXT,
    tenant_id BIGINT NULL,      -- NULL para alertas globales
    is_read BOOLEAN DEFAULT FALSE,
    created_at DATETIME
) ENGINE=InnoDB;
```

**Controller:**

```php
#[Route('/system/alerts', name: 'app_system_alerts')]
public function alerts(Request $request): Response
{
    $category = $request->query->get('category', 'all');

    $qb = $this->em->createQueryBuilder();
    $qb->select('a')
       ->from(Alert::class, 'a')
       ->orderBy('a.createdAt', 'DESC');

    if ($category !== 'all') {
        $qb->andWhere('a.category = :category')
           ->setParameter('category', $category);
    }

    $alerts = $qb->getQuery()->getResult();

    return $this->render('system/alerts.html.twig', [
        'alerts' => $alerts,
        'category' => $category,
    ]);
}
```

---

## 🛠️ Configuración del Entorno

### Docker Setup

#### docker-compose.yml

```yaml
version: '3.8'

services:
    apache:
        build: ./docker/apache
        container_name: apu_apache
        ports:
            - '80:80'
        volumes:
            - .:/var/www/html/proyecto
        depends_on:
            - mysql
        environment:
            DATABASE_URL: mysql://root:root@mysql:3306/apu_system

    mysql:
        image: mysql:8.0
        container_name: apu_mysql
        environment:
            MYSQL_ROOT_PASSWORD: root
            MYSQL_DATABASE: apu_system
        ports:
            - '3306:3306'
        volumes:
            - mysql_data:/var/lib/mysql
            - ./database:/docker-entrypoint-initdb.d

    mailpit:
        image: axllent/mailpit
        container_name: apu_mailpit
        ports:
            - '8025:8025' # Web UI
            - '1025:1025' # SMTP

volumes:
    mysql_data:
```

#### Dockerfile (Apache + PHP 8.2)

```dockerfile
FROM php:8.2-apache

# Instalar extensiones
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    zip \
    unzip \
    git

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    gd \
    intl

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/proyecto/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/proyecto

# Permisos
RUN chown -R www-data:www-data /var/www/html
```

### Variables de Entorno (.env)

```bash
# Ambiente
APP_ENV=dev
APP_SECRET=cambiar_por_clave_secreta_de_32_caracteres

# Base de Datos
DATABASE_URL="mysql://root:root@mysql:3306/apu_system?serverVersion=8.0&charset=utf8mb4"

# Mailer (Mailpit en desarrollo)
MAILER_DSN=smtp://mailpit:1025

# JWT (para API Revit)
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=tu_passphrase_segura

# Timezone
DEFAULT_TIMEZONE=America/Guayaquil

# Encriptación
ENCRYPTION_KEY=clave_de_32_caracteres_minimo

# Rate Limiting
RATE_LIMIT_ENABLED=true
LOGIN_MAX_ATTEMPTS=5
LOGIN_WINDOW=900
```

### Base de Datos

#### Inicializar

```bash
# Opción 1: Migraciones (recomendado)
docker exec apache php bin/console doctrine:database:create
docker exec apache php bin/console doctrine:migrations:migrate --no-interaction

# Opción 2: Script SQL directo
docker exec -i mysql mysql -uroot -proot apu_system < database/schema.sql
docker exec -i mysql mysql -uroot -proot apu_system < database/insert-abc-company.sql
```

#### Resetear

```bash
# Eliminar y recrear
docker exec apache php bin/console doctrine:database:drop --force
docker exec apache php bin/console doctrine:database:create
docker exec apache php bin/console doctrine:migrations:migrate --no-interaction
```

---

## 🎯 Comandos Útiles

### Symfony Console

```bash
# Ver todas las rutas
docker exec apache php bin/console debug:router

# Ver servicios
docker exec apache php bin/console debug:container

# Limpiar caché
docker exec apache php bin/console cache:clear

# Ver configuración
docker exec apache php bin/console debug:config

# Crear super admin
docker exec apache php bin/console app:create-super-admin admin@example.com MyPassword123!
```

### Doctrine

```bash
# Crear migración
docker exec apache php bin/console make:migration

# Ejecutar migraciones
docker exec apache php bin/console doctrine:migrations:migrate

# Ver estado de migraciones
docker exec apache php bin/console doctrine:migrations:status

# Ejecutar SQL directo
docker exec apache php bin/console doctrine:query:sql "SELECT * FROM users LIMIT 5"

# Validar schema
docker exec apache php bin/console doctrine:schema:validate
```

### Testing

```bash
# PHPUnit (cuando esté configurado)
docker exec apache php bin/phpunit

# PHPStan (análisis estático)
docker exec apache vendor/bin/phpstan analyse src --level=5

# Composer audit
docker exec apache composer audit
```

### Docker

```bash
# Iniciar contenedores
docker-compose up -d

# Detener contenedores
docker-compose down

# Ver logs
docker logs apache -f
docker logs mysql -f

# Acceder a bash
docker exec -it apache bash
docker exec -it mysql bash

# Reiniciar un servicio
docker-compose restart apache
```

---

## 🧪 Testing

### Crear Usuario de Prueba

```bash
docker exec apache php bin/console app:create-user \
    --email=test@example.com \
    --password=Test123! \
    --role=ROLE_USER \
    --tenant-slug=abc
```

### Probar API Revit

```bash
# Autenticación
curl -X POST http://localhost/api/revit/authenticate \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@abc.com",
    "password": "Admin123!"
  }'

# Upload (con token)
curl -X POST http://localhost/api/revit/upload \
  -H "Authorization: Bearer <TOKEN>" \
  -F "file=@proyecto.rvt" \
  -F "project_id=1"
```

### Probar 2FA

1. Habilitar 2FA para usuario de prueba
2. Escanear QR con Google Authenticator
3. Hacer logout
4. Intentar login → Debe pedir código TOTP
5. Ingresar código → Debe autenticar

### Probar Rate Limiting

```bash
# Script para testing
for i in {1..10}; do
  curl -X POST http://localhost/login \
    -d "email=admin@demo.com&password=wrong" \
    -c cookies.txt -b cookies.txt
  echo "Intento $i"
done

# Después del intento 5, debe bloquear (HTTP 429)
```

---

## 📂 Estructura de Archivos

```
proyecto/
├── bin/
│   └── console                  # CLI de Symfony
├── config/
│   ├── packages/                # Configuración de bundles
│   ├── routes/                  # Rutas de la app
│   └── services.yaml            # Servicios
├── database/
│   ├── schema.sql               # Schema completo
│   ├── insert-abc-company.sql   # Datos de prueba
│   └── reset-admin-password.sh  # Resetear password
├── docs/                        # Esta documentación
├── migrations/                  # Migraciones Doctrine
├── public/
│   ├── index.php                # Front controller
│   ├── css/                     # Estilos
│   └── js/                      # JavaScript
├── src/
│   ├── Command/                 # Comandos CLI
│   ├── Controller/              # Controladores
│   ├── Entity/                  # Entidades ORM
│   ├── EventListener/           # Event subscribers
│   ├── Form/                    # Tipos de formulario
│   ├── Repository/              # Repositorios Doctrine
│   ├── Security/                # Auth y seguridad
│   ├── Service/                 # Servicios de negocio
│   └── Twig/                    # Extensiones Twig
├── templates/                   # Plantillas Twig
│   ├── base.html.twig           # Plantilla base
│   ├── admin/                   # Panel admin
│   ├── dashboard/               # Dashboard
│   ├── profile/                 # Perfil de usuario
│   ├── security/                # Login, 2FA
│   └── system/                  # Panel super admin
├── tests/                       # Tests (PHPUnit)
├── translations/                # Archivos i18n
│   ├── messages.es.yaml         # Español
│   └── messages.en.yaml         # Inglés
├── var/
│   ├── cache/                   # Caché de Symfony
│   ├── log/                     # Logs
│   └── sessions/                # Sesiones en dev
├── vendor/                      # Dependencias Composer
├── .env                         # Variables de entorno
├── composer.json                # Dependencias PHP
├── docker-compose.yml           # Configuración Docker
└── README.md                    # README principal
```

---

## 📝 Historia de Cambios

### 17/03/2026 - Sistema Completo

- ✅ Sistema multi-tenant basado en sesión
- ✅ 3 roles implementados (SUPER_ADMIN, ADMIN, USER)
- ✅ 2FA con TOTP y recovery codes
- ✅ Internacionalización ES/EN
- ✅ Personalización de temas
- ✅ Sistema APU con 5 entidades
- ✅ API Revit con JWT
- ✅ Seguridad OWASP 10/10

### 18/03/2026 - Correcciones

- 🐛 Resolución de problema src/src/ (estructura de carpetas)
- 🐛 Corrección de routes duplicadas
- 🔧 Sistema 100% funcional

### 19/03/2026 - Mejoras Finales

- ✅ Recovery codes reimplementados
- ✅ Tabla `recovery_codes` creada
- ✅ Tabla `user_2fa_settings` creada
- ✅ Quick Actions eliminada de System Panel para SUPER_ADMIN
- ✅ Documentación consolidada (18 → 6 archivos)
- ✅ README.md actualizado con usuarios de prueba
- ✅ TEST_USERS.md creado

---

## 🚀 Roadmap Futuro

### Corto Plazo (1-3 meses)

- [ ] Tests automatizados (PHPUnit)
- [ ] API GraphQL alternativa
- [ ] App móvil (React Native)
- [ ] Notificaciones push
- [ ] Importación masiva de APUs (CSV/Excel)

### Mediano Plazo (3-6 meses)

- [ ] Integración con ERP (SAP, Odoo)
- [ ] Dashboard analytics avanzado
- [ ] Reportes personalizables
- [ ] Sistema de aprobaciones workflow
- [ ] Firma digital de documentos

### Largo Plazo (6-12 meses)

- [ ] Machine Learning para predicción de precios
- [ ] Blockchain para trazabilidad
- [ ] Integración con drones (fotogrametría)
- [ ] BIM 5D (cronograma + costos)
- [ ] Marketplace de APUs

---

**Última actualización:** 19/03/2026
**Mantenido por:** Equipo de Desarrollo
**Próxima revisión:** Abril 2026
