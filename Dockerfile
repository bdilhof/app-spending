# Stage 1: build
FROM php:8.4-fpm AS build

WORKDIR /var/www/html

# Systémové závislosti + PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libicu-dev \
    && docker-php-ext-install pdo_mysql zip intl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Git safe directory (odstráni dubious ownership warning)
RUN git config --global --add safe.directory /var/www/html

# Copy projekt
COPY . .

# Composer deps pre produkciu
RUN composer install --no-dev --optimize-autoloader

# Stage 2: runtime
FROM php:8.4-fpm

WORKDIR /var/www/html

# PHP extensions (rovnaké ako v build stage)
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libicu-dev \
    && docker-php-ext-install pdo_mysql zip intl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy aplikáciu z build stage
COPY --from=build /var/www/html /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Entry point
CMD ["php-fpm"]
