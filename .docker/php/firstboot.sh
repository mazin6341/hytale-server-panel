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

# Create Admin User
# echo "------------------------------------------"
# echo "   Setup Administrative User Account"
# echo "------------------------------------------"
# read -p "Enter Full Name: " USER_NAME
# read -p "Enter Email Address: " USER_EMAIL
# read -sp "Enter Password: " USER_PASS
# echo ""
# echo "Creating account for $USER_EMAIL..."

# php artisan tinker <<EOF
# \$user = \App\Models\User::updateOrCreate(
#     ['email' => '$USER_EMAIL'],
#     [
#         'name' => '$USER_NAME',
#         'password' => \Illuminate\Support\Facades\Hash::make('$USER_PASS'),
#     ]
# );
# echo "User $USER_NAME created successfully.\n";
# EOF

# Creating Super Admin Role and Assigning to The New User
echo "Creating 'Super Admin' Role and assigning to $USER_EMAIL..."
php artisan db:seed

# Build assets if package.json exists
if [ -f "package.json" ]; then
    echo "Building frontend assets..."
    npm install
    npm run build
fi