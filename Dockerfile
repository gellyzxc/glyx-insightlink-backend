FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpq-dev libonig-dev \
    libssl-dev libcurl4-openssl-dev pkg-config inotify-tools \
    libbrotli-dev \
    && docker-php-ext-install pdo pdo_pgsql zip opcache sockets


RUN pecl install swoole && docker-php-ext-enable swoole

RUN docker-php-ext-install pcntl

RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN groupadd -g 1000 laravel \
    && useradd -u 1000 -g laravel -m laravel

RUN chown -R laravel:laravel /var/www

WORKDIR /var/www

USER laravel
