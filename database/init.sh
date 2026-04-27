#!/bin/bash

# Script para inicializar la base de datos APU System
# Ejecutar desde el directorio raíz del proyecto

echo "🗄️  Inicializando base de datos APU System..."

# Configuración
DB_HOST="mysql"
DB_PORT="3306"
DB_ROOT_PASSWORD="root"
DB_NAME="apu_system"
SCHEMA_FILE="database/schema.sql"

# Verificar que el archivo schema existe
if [ ! -f "$SCHEMA_FILE" ]; then
    echo "❌ Error: No se encuentra el archivo $SCHEMA_FILE"
    exit 1
fi

# Ejecutar el schema dentro del contenedor MySQL
echo "📝 Ejecutando schema SQL..."
docker exec -i mysql mysql -uroot -p${DB_ROOT_PASSWORD} < "$SCHEMA_FILE"

if [ $? -eq 0 ]; then
    echo "✅ Base de datos creada exitosamente"
    echo ""
    echo "📊 Información de acceso:"
    echo "   Database: $DB_NAME"
    echo "   Host: $DB_HOST"
    echo "   Port: $DB_PORT"
    echo ""
    echo "👤 Usuario inicial:"
    echo "   Email: admin@demo.com"
    echo "   Password: Admin123!"
    echo "   Rol: super_admin"
    echo ""
else
    echo "❌ Error al crear la base de datos"
    exit 1
fi
