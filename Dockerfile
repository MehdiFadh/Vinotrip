FROM php:8.2-apache

# Installer extensions nécessaires pour Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Activer mod_rewrite (IMPORTANT pour Laravel)
RUN a2enmod rewrite

# Configurer Apache pour pointer vers /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

WORKDIR /var/www/html