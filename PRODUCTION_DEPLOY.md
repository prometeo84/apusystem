Deploy a producción

Este documento describe qué archivos y carpetas copiar al servidor de producción y qué scripts ejecutar para crear la base de datos y dejar la aplicación lista.

IMPORTANTE: Nunca subir archivos con secretos (.env con credenciales) al repositorio. En producción usar variables de entorno o archivos `.env.prod` fuera del control de versiones.

Archivos / carpetas a trasladar

- public/ — archivos públicos (entrypoint). Copiar tal cual.
- config/ — configuración de Symfony (routes, services, packages).
- templates/ — vistas Twig.
- migrations/ — migraciones Doctrine (si se usa migraciones en lugar de schema.sql).
- database/schema.sql — esquema SQL inicial (opcional si se usan migraciones).
- bin/ — scripts auxiliares (console, init.sh, seed_demo.php).
- vendor/ — dependencias PHP (recomiendo ejecutar composer install en el servidor en vez de copiarla).
- assets/ y/o build/ — recursos estáticos compilados (ejecutar npm run build o copiar build/).
- translations/ — archivos de traducción.
- config/certs/ — certificados si se usan (asegurar permisos y rutas).

No copie: .env con secretos, node_modules/ (ejecutar npm ci), var/ (logs y caché), test-results/.

Requisitos en servidor

- PHP 8.3 con extensiones: pdo_mysql, mbstring, intl, gd, ctype, json
- Composer 2.x
- MySQL 8.0+ (o el motor que uses en producción)
- Node.js 18+ y npm para compilar assets
- Certificados TLS si usa HTTPS (o configurar proxy)

Pasos de despliegue (resumen)

1. Subir código al servidor (rsync/scp/git clone) en /srv/www/apu.
2. Establecer variables de entorno en el sistema (por ejemplo con systemd or env files): APP*ENV=prod, APP_SECRET, DATABASE_URL, JWT*\*, MAILER_DSN.
3. Instalar dependencias PHP:

    cd /srv/www/apu
    composer install --no-dev --optimize-autoloader

4. Instalar dependencias JS y compilar assets:

    npm ci
    npm run build

5. Crear base de datos y cargar esquema. Opciones:

- Usando script incluido (database/init.sh) que ejecuta database/schema.sql en contenedor MySQL:

    ./database/init.sh

- O usando Doctrine migrations (si prefiere migraciones):

    php bin/console doctrine:database:create --if-not-exists
    php bin/console doctrine:migrations:migrate --no-interaction

6. Ejecutar comandos de preparación:

    php bin/console cache:clear --env=prod
    php bin/console cache:warmup --env=prod
    php bin/console doctrine:fixtures:load --no-interaction # opcional

7. Ajustar permisos (ejemplo):

    chown -R www-data:www-data var public build
    find var -type d -exec chmod 775 {} +
    find var -type f -exec chmod 664 {} +

8. Crear usuario admin (opcional):

    php bin/seed_demo.php

9. Reiniciar servicios (PHP-FPM, webserver):

    systemctl restart php8.3-fpm
    systemctl restart nginx

Script para crear la base desde el repositorio

Usar database/init.sh (incluido) que ejecuta database/schema.sql dentro del contenedor mysql:

./database/init.sh

Si no usa Docker, importar database/schema.sql manualmente:

MySQL: mysql -u root -p < database/schema.sql
PostgreSQL: psql -U postgres -f database/schema.sql

Notas finales

- Asegúrate de crear backups regulares. En este repositorio se guardan backups en database/backups/.
- No olvides rotar secretos y cambiar contraseñas por defecto en producción.

Fin
