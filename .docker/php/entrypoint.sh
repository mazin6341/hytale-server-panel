#!/bin/sh
set -e

chown -R www-data:www-data /var/www/database /var/www/.docker

if [ -S /var/run/docker.sock ]; then
    chown www-data:www-data /var/run/docker.sock
fi

su-exec www-data php artisan optimize:clear
echo "Starting Hytale Web Panel..."
exec su-exec www-data php artisan serve --host=0.0.0.0 --port=8000