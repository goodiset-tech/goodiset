FROM php:8.2-fpm-alpine

# Install system dependencies (must come before any PHP extension compilation)
RUN apk add --no-cache \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
        postgresql-dev \
        libxml2-dev \
        icu-dev \
        oniguruma-dev \
        unzip \
        curl \
        git

# Configure GD with freetype + jpeg support, then install all required extensions
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        pdo_pgsql \
        zip \
        dom \
        mbstring \
        xml \
        fileinfo \
        exif \
        bcmath \
        intl \
        opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy only composer.json — composer.lock is not committed (listed in .gitignore)
COPY composer.json ./

# Install PHP dependencies, deferring scripts and autoloader
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-autoloader \
        --prefer-dist

# Copy the rest of the application source
COPY . .

# Generate optimised autoloader and run post-install scripts
RUN composer dump-autoload --optimize \
    && composer run-script post-autoload-dump || true

# Set correct ownership and permissions for Laravel writable directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

EXPOSE 9000
