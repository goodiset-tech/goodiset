# -----------------------------------------------------------------------------
# Frontend assets (Laravel Mix)
# -----------------------------------------------------------------------------
FROM node:20-bookworm-slim AS frontend

WORKDIR /build

COPY package.json package-lock.json* ./
RUN npm ci 2>/dev/null || npm install

COPY webpack.mix.js ./
COPY resources ./resources
COPY public ./public

RUN npm run prod

# -----------------------------------------------------------------------------
# Application
# -----------------------------------------------------------------------------
FROM php:8.2-fpm

# Install system dependencies and nginx
RUN apt-get update && apt-get install -y \
        nginx \
        postgresql-client \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libzip-dev \
        libonig-dev \
        libxml2-dev \
        libicu-dev \
        libcurl4-openssl-dev \
        zip \
        unzip \
        curl \
        libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Install and configure PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        zip \
        xml \
        bcmath \
        curl \
        intl \
        exif \
        opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy nginx, PHP-FPM pool, and startup configuration
COPY nginx.conf /etc/nginx/nginx.conf

COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY start.sh /start.sh
RUN chmod +x /start.sh

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

# Compiled Mix assets from frontend stage (overwrites public/js, public/css, mix-manifest, etc.)
COPY --from=frontend /build/public /var/www/html/public

# Generate optimised autoloader and run post-install scripts
RUN composer dump-autoload --optimize \
    && composer run-script post-autoload-dump || true

# Set correct ownership and permissions for Laravel writable directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["/start.sh"]
