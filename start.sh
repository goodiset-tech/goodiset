#!/bin/sh
set -e

# Run Laravel bootstrap tasks
php /var/www/html/artisan config:cache
php /var/www/html/artisan view:cache

# Start PHP-FPM in the background
php-fpm --daemonize

# Start Caddy in the foreground (PID 1)
exec caddy run --config /etc/caddy/Caddyfile --adapter caddyfile
