FROM php:8.2-apache

# Instalar dependencias necesarias incluyendo unzip y git para Composer
RUN apt-get update && apt-get install -y libpq-dev unzip git \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite de Apache por si acaso
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el código de tu proyecto al directorio de Apache
COPY . /var/www/html/

# Dar permisos a los archivos
RUN chown -R www-data:www-data /var/www/html/

# Ejecutar composer install para descargar el ORM
WORKDIR /var/www/html/
RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
