FROM php:8.2-apache

# Install system dependencies (must come before any PHP extension compilation)
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libpq-dev \
        libxml2-dev \
        libicu-dev \
        libonig-dev \
        unzip \
        curl \
        git \
    && rm -rf /var/lib/apt/lists/*

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

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Replace the default VirtualHost with one that points to Laravel's public/
# directory and enables .htaccess overrides — no sed patching of core configs
# needed, which avoids the "More than one MPM loaded" conflict.
COPY docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

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

EXPOSE 80
