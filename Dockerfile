# SIAER: PHP 8.2 + Apache + CodeIgniter 4
FROM php:8.2-apache

RUN apt-get update \
 && apt-get install -y --no-install-recommends libicu-dev libzip-dev unzip \
 && docker-php-ext-install intl mysqli zip \
 && a2enmod rewrite headers \
 && rm -rf /var/lib/apt/lists/*

# Apache sirve solo la carpeta public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
COPY docker/apache-siaer.conf /etc/apache2/conf-enabled/siaer.conf

WORKDIR /var/www/html
COPY . .

# Carpetas de escritura de CodeIgniter
RUN mkdir -p writable/cache writable/logs writable/session writable/uploads writable/debugbar \
 && chown -R www-data:www-data writable \
 && chmod -R 775 writable

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

# Render define PORT (por defecto 10000); el entrypoint hace que Apache escuche en ese puerto
EXPOSE 10000
ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
