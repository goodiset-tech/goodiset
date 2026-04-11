#!/bin/sh
set -e

# Generate .env from Railway environment variables so Laravel can load config.
# We capture every variable whose prefix matches a known Laravel/app namespace.
printenv | grep -E '^(APP_|DB_|LOG_|CACHE_|SESSION_|QUEUE_|MAIL_|STRIPE_|PUSHER_|AWS_|REDIS_|MEMCACHED_|BROADCAST_|FILESYSTEM_|NGENIUS_|JEELLY_|RECAPTCHA_|PG)' > /var/www/html/.env || true

echo "Generated .env with $(wc -l < /var/www/html/.env) variable(s)."

# Configure PHP-FPM to listen on a Unix socket instead of TCP.
# Writing an explicit pool file overrides the default www.conf (port 9000).
cat > /usr/local/etc/php-fpm.d/www-socket.conf <<'EOF'
[www]
user = www-data
group = www-data
listen = /run/php-fpm.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660
pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3
EOF

# Start PHP-FPM in the background
php-fpm -D

# Wait until the socket is ready before starting nginx, so the first request
# never hits a 502 caused by nginx connecting before PHP-FPM is listening.
echo "Waiting for PHP-FPM socket..."
for i in $(seq 1 30); do
    [ -S /run/php-fpm.sock ] && break
    sleep 0.5
done
[ -S /run/php-fpm.sock ] || { echo "ERROR: PHP-FPM socket did not appear"; exit 1; }
echo "PHP-FPM socket ready."

# Start nginx in the foreground (exec replaces the shell, making nginx PID 1)
exec nginx -g "daemon off;"
