# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all project files
COPY . .

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Laravel cache (skip migrate at build)
RUN php artisan config:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Fix Apache root
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# ✅ FIX: Create missing Laravel directories and set permissions
RUN mkdir -p storage/framework/{sessions,cache,views} \
    && mkdir -p bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Expose port
EXPOSE 80

# Run migrate on container start (after env is loaded)
CMD php artisan migrate --force && apache2-foreground
