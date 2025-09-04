FROM php:7.4-fpm

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    libzip-dev \
    libssl-dev \
    git \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl sockets
    RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www
