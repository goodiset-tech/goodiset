FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libpq-dev \
        libicu-dev \
        unzip \
        git \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        pdo_pgsql \
        zip \
        intl \
        opcache

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Point DocumentRoot at Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/apache2.conf

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

CMD ["apache2-foreground"]
