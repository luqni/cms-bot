FROM php:8.2-fpm

# Install dependencies (tambahkan libpng dan gd)
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install zip pdo php-pgsql pdo_pgsql gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Pastikan folder penting ada
RUN mkdir -p storage bootstrap/cache

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Laravel permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Jalankan Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8000