FROM php:8.2-fpm
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql pcntl
RUN docker-php-ext-enable mysqli pcntl
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
