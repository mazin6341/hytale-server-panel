FROM php:8.2-alpine

# Installing and Updating Packages
RUN apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    libzip \
    icu-libs \
    libpng \
    oniguruma \
    libxml2 \
    sqlite \
    shadow \
    su-exec \
    nodejs \
    npm \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        libzip-dev \
        icu-dev \
        libpng-dev \
        oniguruma-dev \
        libxml2-dev \
        linux-headers \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        zip \
        intl \
        sockets \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
    && apk del .build-deps \
    && cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setting Working Directory
WORKDIR /var/www/html

# User Permission
ARG DOCKER_UID=1000
ARG DOCKER_GID=1000
RUN usermod -u ${DOCKER_UID} www-data
RUN groupmod -g ${DOCKER_GID} www-data

RUN mkdir -p /var/www/.npm

# # Copy existing application directory permissions
RUN chown -R www-data:www-data /var/www

# Change current user to www
# USER www-data
    
# Expose port 8000 and start php server
EXPOSE 8000
CMD ["/bin/sh", "-c", "(npm build || true) && composer install && php artisan serve --host=0.0.0.0 --port=8000"]
