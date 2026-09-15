# ==========================================
# Stage 1: Build Frontend Assets
# ==========================================
FROM node:20-alpine AS node_builder

WORKDIR /app

COPY package*.json ./
RUN npm ci || npm install

COPY . .
RUN npm run build

# ==========================================
# Stage 2: Production PHP-FPM Application
# ==========================================
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www

# Install system dependencies and build tools
RUN apk add --no-cache \
    curl \
    git \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    icu-dev \
    oniguruma-dev \
    sqlite-dev \
    bash

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_sqlite \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Copy custom PHP configuration
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy application source
COPY . /var/www

# Copy built frontend assets from node_builder
COPY --from=node_builder /app/public/build /var/www/public/build

# Install PHP dependencies without dev packages
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Set permissions for www-data
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
