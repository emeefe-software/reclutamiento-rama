FROM php:7.4-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    zip unzip libzip-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo_mysql zip

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

# Copia tu app (esto se ignora si ya montas volumen)
COPY . /var/www/html

# Establece permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html