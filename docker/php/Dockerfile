FROM php:8.1-fpm
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql
RUN docker-php-ext-enable mysqli
