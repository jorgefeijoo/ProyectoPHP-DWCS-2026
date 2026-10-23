FROM php:8.4-apache

# Extensiones PHP necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activar mod_rewrite de Apache
RUN a2enmod rewrite

# Configuración de Apache
WORKDIR /var/www/html

# Permitir .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' \
    /etc/apache2/apache2.conf

# Configuración opcional de PHP para desarrollo
RUN echo "display_errors=On" > /usr/local/etc/php/conf.d/development.ini \
    && echo "error_reporting=E_ALL" >> /usr/local/etc/php/conf.d/development.ini

