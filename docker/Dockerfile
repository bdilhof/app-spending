# Stage 1: build
FROM php:8.4-fpm-alpine AS build

WORKDIR /var/www/html

# Systémové závislosti + PHP extensions potrebné na build
RUN apk add --no-cache \
    libzip-dev zip unzip git curl icu-dev bash \
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
FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

# Len runtime PHP extensions (bez git, curl, unzip)
RUN apk add --no-cache libzip-dev icu-dev bash \
    && docker-php-ext-install pdo_mysql zip intl

# Composer (ak ho potrebuješ aj v runtime, napr. pre artisan commands)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy aplikáciu z build stage
COPY --from=build /var/www/html /var/www/html

# Permissions pre celý projekt
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Permissions pre Laravel storage a bootstrap/cache (zápis pre www-data)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Entry point
CMD ["php-fpm"]
