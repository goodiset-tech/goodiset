#!/bin/sh
set -e

# Generate .env from Railway environment variables so Laravel can load config.
# We capture every variable whose prefix matches a known Laravel/app namespace.
printenv | grep -E '^(APP_|DB_|LOG_|CACHE_|SESSION_|QUEUE_|MAIL_|STRIPE_|PUSHER_|AWS_|REDIS_|MEMCACHED_|BROADCAST_|FILESYSTEM_|NGENIUS_|JEELLY_|RECAPTCHA_|PG)' > /var/www/html/.env || true

echo "Generated .env with $(wc -l < /var/www/html/.env) variable(s)."

# Start PHP-FPM in the background
php-fpm -D

# Start nginx in the foreground (exec replaces the shell, making nginx PID 1)
exec nginx -g "daemon off;"
