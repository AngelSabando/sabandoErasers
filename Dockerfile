FROM php:8.2-apache

# Habilitar extensión pdo_pgsql para conectar con Supabase (PostgreSQL)
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite de Apache por si acaso
RUN a2enmod rewrite

# Copiar el código de tu proyecto al directorio de Apache
COPY . /var/www/html/

# Dar permisos a los archivos
RUN chown -R www-data:www-data /var/www/html/

# Exponer el puerto 80
EXPOSE 80
