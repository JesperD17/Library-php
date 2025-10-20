# Dockerfile
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git libpng-dev libjpeg62-turbo-dev libfreetype6-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli zip opcache
RUN a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]