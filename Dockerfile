FROM php:8.3-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpq-dev \
    libzip-dev

# PHP Extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip

# Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install

RUN npm install

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php-fpm"]