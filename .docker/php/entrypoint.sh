#!/bin/sh
set -e

# Fix permissions for mounted volumes
chown -R www-data:www-data /var/www/database /var/www/.docker

su-exec www-data php artisan optimize:clear
echo "Starting Hytale Web Panel..."
exec su-exec www-data php artisan serve --host=0.0.0.0 --port=8000
