#!/bin/sh
set -e

# Run Laravel bootstrap tasks
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP's built-in server on all interfaces at port 80
exec php artisan serve --host=0.0.0.0 --port=80
