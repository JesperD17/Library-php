FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    pkg-config libsqlite3-dev libzip-dev zip unzip git libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_sqlite

RUN a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

CMD ["sh", "-lc", "su -s /bin/sh -c 'php console/migrate.php' www-data && exec apache2-foreground"]