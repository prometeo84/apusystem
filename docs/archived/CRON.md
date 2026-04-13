# Integración con cron-job.org

Este documento describe cómo crear un job en `cron-job.org` para invocar el endpoint de la aplicación y ejecutar tareas programadas (por ejemplo, la limpieza de sesiones expiradas).

## Preparación en la aplicación

- Configure la clave API en el archivo `.env` (ya existe la variable):

```
CRON_JOB_API_KEY=changeme_replace_with_secure_key
```

Cambie `changeme_replace_with_secure_key` por un valor aleatorio seguro (ej.: 32 bytes hex).

## Endpoint disponible

- URL: `https://<tu-dominio>/cron/run`
- Método: `POST`
- Autenticación: enviar la clave en el header `X-Cron-Api-Key: <tu_clave>` o en el body/form field `api_key`.

Ejemplo con `curl`:

```bash
curl -X POST \
  -H "X-Cron-Api-Key: $CRON_JOB_API_KEY" \
  https://your-domain.example/cron/run
```

Respuesta exitosa (HTTP 200, JSON):

```json
{ "status": "ok", "updated": 11 }
```

`updated` indica la cantidad de sesiones que se marcaron como inactivas.

Respuesta de error de autenticación (HTTP 403):

```json
{ "status": "error", "message": "invalid api key" }
```

## Configuración en cron-job.org

1. Crear una nueva tarea (New cronjob).
2. Establecer la URL a `https://your-domain.example/cron/run`.
3. Método: `POST`.
4. En la sección Headers añadir: `X-Cron-Api-Key: <tu_clave>`.
5. Guardar y programar la frecuencia deseada (ej.: cada hora, cada 6 horas, etc.).

Prueba manual: use el botón "Run now" en cron-job.org o ejecute el `curl` arriba.

## Seguridad y recomendaciones

- Use siempre HTTPS.
- Mantenga la clave en `.env` y no la comparta en repositorios.
- Para mayor seguridad, configure reglas en su firewall o en el reverse proxy para limitar llamadas al endpoint a los IPs de `cron-job.org`.
- Considere añadir un `User-Agent` comprobable o firma HMAC si necesita mayor seguridad.

## Pruebas locales

- Para probar localmente (si la aplicación está accesible desde el host):

```bash
export CRON_KEY="<la_clave_que_puso_en_.env>"
curl -X POST -H "X-Cron-Api-Key: $CRON_KEY" http://localhost/cron/run
```

Respuesta esperada: JSON con `status: ok` y campo `updated` con el número de filas afectadas.
