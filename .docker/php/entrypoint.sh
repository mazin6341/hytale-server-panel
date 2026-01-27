#!/bin/sh
set -e

chown -R www-data:www-data /var/www/database /var/www/.docker

if [ -S /var/run/docker.sock ]; then
    chown www-data:www-data /var/run/docker.sock
fi

echo "Installing dependencies..."
su-exec www-data npm install
su-exec www-data npm run build || true
su-exec www-data composer install

echo "Setting up database..."
su-exec www-data touch database/database.sqlite
su-exec www-data php artisan migrate --force
su-exec www-data php artisan db:seed --force || true

su-exec www-data php artisan optimize:clear
echo "Starting Hytale Web Panel..."
exec su-exec www-data php artisan serve --host=0.0.0.0 --port=8000
