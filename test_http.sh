#!/bin/bash
# Script para validar endpoint /system/tenants con autenticación

echo "=== Validación HTTP de /system/tenants ==="
echo ""

# Paso 1: Obtener página de login y extraer CSRF token
echo "1. Obteniendo token CSRF..."
CSRF_TOKEN=$(curl -s -c /tmp/test_session.txt http://localhost:8080/login | \
  grep -oP 'name="_csrf_token" value="\K[^"]+')

if [ -z "$CSRF_TOKEN" ]; then
  echo "⚠️  No se pudo extraer el token CSRF"
  CSRF_TOKEN="test"
fi

echo "   Token CSRF: ${CSRF_TOKEN:0:20}..."

# Paso 2: Hacer login con credenciales
echo ""
echo "2. Realizando login..."
LOGIN_RESPONSE=$(curl -s -b /tmp/test_session.txt -c /tmp/test_session.txt \
  -X POST http://localhost:8080/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "_username=admin@demo.com&_password=admin123&_csrf_token=$CSRF_TOKEN" \
  -w "\n%{http_code}" -L)

STATUS_CODE=$(echo "$LOGIN_RESPONSE" | tail -1)
echo "   Status Code: $STATUS_CODE"

# Paso 3: Acceder a /system/tenants
echo ""
echo "3. Accediendo a /system/tenants..."
TENANTS_STATUS=$(curl -s -b /tmp/test_session.txt \
  http://localhost:8080/system/tenants \
  -o /tmp/tenants_response.html \
  -w "%{http_code}")

echo "   Status Code: $TENANTS_STATUS"

# Verificar el resultado
echo ""
if [ "$TENANTS_STATUS" = "200" ]; then
  echo "✅ SUCCESS: El endpoint /system/tenants responde correctamente"
  echo ""
  echo "Verificando contenido..."
  if grep -q "tenant.slug" /tmp/tenants_response.html 2>/dev/null; then
    echo "✅ Template usa 'slug' correctamente"
  fi
  if grep -q "subdomain" /tmp/tenants_response.html 2>/dev/null; then
    echo "⚠️  ADVERTENCIA: Encontrada referencia a 'subdomain' en la respuesta"
  fi
else
  echo "⚠️  El endpoint devolvió código $TENANTS_STATUS"
  if [ "$TENANTS_STATUS" = "302" ]; then
    echo "   Esto indica que se requiere autenticación válida"
    echo "   Accede desde tu navegador con sesión iniciada: http://localhost:8080/system/tenants"
  fi
fi

# Limpiar
rm -f /tmp/test_session.txt /tmp/tenants_response.html

echo ""
echo "=== Validación completada ==="
