#!/usr/bin/env bash
set -euo pipefail

# Script para validar CSS localmente usando vnu.jar (Nu Validator)
# - descarga vnu.jar en .tools/vnu.jar si no existe
# - ejecuta la validación contra los CSS en public/build

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
TOOLS_DIR="$ROOT_DIR/.tools"
VNU_JAR="$TOOLS_DIR/vnu.jar"

mkdir -p "$TOOLS_DIR"

if [ ! -f "$VNU_JAR" ]; then
  echo "vnu.jar no encontrado. Descargando..."
  curl -L -o "$VNU_JAR" "https://github.com/validator/validator/releases/latest/download/vnu.jar"
  echo "Descargado $VNU_JAR"
fi

if ! command -v java >/dev/null 2>&1; then
  echo "Java no está instalado o no está en PATH. Instala Java (JRE) para usar vnu.jar." >&2
  exit 2
fi

mapfile -t CSS_FILES < <(find "$ROOT_DIR/public/build" -maxdepth 1 -type f -name "*.css" 2>/dev/null || true)

# Prioridad: si existe public/index.html úsalo; si no, generamos un HTML temporal que incluya el primer CSS construido.
PUBLIC_INDEX="$ROOT_DIR/public/index.html"
TEMP_HTML="$TOOLS_DIR/vnu-temp.html"
RESULT_JSON="$TOOLS_DIR/vnu-result.json"

if [ ${#CSS_FILES[@]} -eq 0 ]; then
  echo "No se encontraron archivos CSS en public/build. Ejecuta 'npm run build' antes de validar." >&2
  exit 1
fi

CSS_FILE="${CSS_FILES[0]}"

if [ -f "$PUBLIC_INDEX" ]; then
  echo "Usando archivo HTML existente: $PUBLIC_INDEX"
  TARGET_HTML="$PUBLIC_INDEX"
else
  echo "No existe public/index.html — creando HTML temporal que carga: $CSS_FILE"
  cat > "$TEMP_HTML" <<EOF
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Validación CSS</title>
  <link rel="stylesheet" href="file://$CSS_FILE">
</head>
<body>
</body>
</html>
EOF
  TARGET_HTML="$TEMP_HTML"
fi

echo "Ejecutando vnu.jar sobre: $TARGET_HTML"
java -jar "$VNU_JAR" --format json "$TARGET_HTML" > "$RESULT_JSON" 2>/dev/null || true

if command -v jq >/dev/null 2>&1; then
  ERRORS_COUNT=$(jq '(.messages // []) | map(select(.type=="error")) | length' "$RESULT_JSON" 2>/dev/null || echo 0)
  WARNINGS_COUNT=$(jq '(.messages // []) | map(select(.type=="warning" or (.type=="info" and .subType=="warning"))) | length' "$RESULT_JSON" 2>/dev/null || echo 0)
else
  ERRORS_COUNT=$(grep -c '"type"[[:space:]]*:[[:space:]]*"error"' "$RESULT_JSON" 2>/dev/null || echo 0)
  WARNINGS_COUNT=$(grep -c '"subType"[[:space:]]*:[[:space:]]*"warning"' "$RESULT_JSON" 2>/dev/null || echo 0)
fi

echo "Resultados: ${ERRORS_COUNT:-0} errores, ${WARNINGS_COUNT:-0} advertencias."

if [ "${ERRORS_COUNT}" -gt 0 ] 2>/dev/null; then
  echo "Se encontraron errores de validación. Revisa: $RESULT_JSON" >&2
  exit 3
fi

echo "Validación completada sin errores."
exit 0
