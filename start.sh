#!/bin/sh
set -e

cd /var/www/html

# Ensures `sessions` table exists when SESSION_DRIVER=database (recommended on Railway).
# php artisan migrate --force --no-interaction

# Start PHP-FPM in the background
php-fpm -D

# Start nginx in the foreground (exec replaces the shell, making nginx PID 1)
exec nginx -g "daemon off;"
