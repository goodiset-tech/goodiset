#!/bin/sh
set -e

mkdir -p /run
mkdir -p /run/php
mkdir -p /var/log/nginx

envsubst '$PORT' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

php-fpm -D
nginx -g 'daemon off;'
