FROM php:8.1-apache
RUN apt-get update -y && apt-get install -y libmariadb-dev && docker-php-ext-install mysqli && docker-php-ext-install pdo_mysql && a2enmod rewrite
WORKDIR /var/www/html