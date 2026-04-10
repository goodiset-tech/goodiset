#!/bin/sh
set -xe

# Start PHP-FPM in the background
php-fpm -D || { echo "ERROR: php-fpm failed to start" >&2; exit 1; }

# Give PHP-FPM a moment to fully initialise before nginx starts accepting
# requests and forwarding them via FastCGI.
sleep 1

# Start nginx in the foreground — this keeps the container alive.
exec nginx -g 'daemon off;'
