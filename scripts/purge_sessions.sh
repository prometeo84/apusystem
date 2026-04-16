#!/usr/bin/env bash
# Purge old login sessions via Symfony console command
# Place in cron: 0 3 * * * /var/www/html/proyecto/scripts/purge_sessions.sh >> /var/www/html/proyecto/var/log/purge_sessions.log 2>&1
PROJECT_DIR="/var/www/html/proyecto"
cd "$PROJECT_DIR" || exit 1
php ./bin/console app:session:purge-old --days=15 --no-interaction --env=prod
exit $?
