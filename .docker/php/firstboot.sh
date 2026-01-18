#!/bin/sh
set -e

# Clean up existing dependencies
rm -rf vendor composer.lock

# Define paths
DOCKER_ENV="/var/www/.docker/.env"
APP_ENV="/var/www/html/.env"

# Setup .env file in .docker location if it doesn't exist or is empty
if [ ! -s "$DOCKER_ENV" ]; then
    echo "Creating .env file from example at $DOCKER_ENV..."
    cp /var/www/html/.env.example "$DOCKER_ENV"
    chown www-data:www-data "$DOCKER_ENV" || true
fi

# Update values based on docker-compose environment variables
sed -i "s|^#\? \?APP_NAME=.*|APP_NAME=\"${APP_NAME}\"|" "$DOCKER_ENV"
sed -i "s|^#\? \?DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION}|" "$DOCKER_ENV"
sed -i "s|^#\? \?DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" "$DOCKER_ENV"

# Link .env file to application root
if [ ! -L "$APP_ENV" ] && [ ! -f "$APP_ENV" ]; then
    echo "Linking .env file..."
    ln -s "$DOCKER_ENV" "$APP_ENV"
fi

# Create SQLite database if it doesn't exist
if [ ! -f "/var/www/database/database.sqlite" ]; then
    echo "Creating database.sqlite..."
    touch /var/www/database/database.sqlite
    chown www-data:www-data /var/www/database/database.sqlite || true
fi

# Install PHP dependencies
echo "Installing Composer dependencies..."
composer install

# Generate Application Key
echo "Generating APP_KEY..."
php artisan key:generate

# Running migrations
echo "Running migrations..."
php artisan migrate:fresh

# Build assets if package.json exists
if [ -f "package.json" ]; then
    echo "Building frontend assets..."
    npm install
    npm run build
fi