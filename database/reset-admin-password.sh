#!/bin/bash

# Script para resetear la contraseña del usuario admin

echo "🔐 Reseteando contraseña del usuario admin..."

# Generar nuevo hash para Admin123!
NEW_HASH='$2y$10$O1CmQSWBwu3t/qTjE0fxf.rZvSaMaeA4qTp8bQKFJCciAjwNrYpVG'

# Actualizar contraseña y resetear intentos fallidos
docker exec mysql mysql -uroot -proot apu_system -e "
UPDATE users
SET password = '${NEW_HASH}',
    failed_login_attempts = 0,
    locked_until = NULL
WHERE email = 'admin@demo.com';
"

# Limpiar rate limiting
docker exec mysql mysql -uroot -proot apu_system -e "TRUNCATE TABLE rate_limit_logs;"

echo "✅ Contraseña reseteada exitosamente"
echo ""
echo "📧 Email: admin@demo.com"
echo "🔑 Password: Admin123!"
echo ""
echo "Puedes iniciar sesión en: http://localhost:8080/login"
