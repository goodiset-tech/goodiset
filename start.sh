#!/bin/sh
set -e

# Start PHP-FPM in the background
php-fpm -D

# Start nginx in the foreground (exec replaces the shell, making nginx PID 1)
exec nginx -g "daemon off;"
