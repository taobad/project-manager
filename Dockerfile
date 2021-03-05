# Set the base image for subsequent instructions
FROM php:7.4-fpm
# Update packages
RUN apt-get update

# Install PHP and composer dependencies
RUN apt-get install -qq git curl libzip-dev libjpeg-dev libpng-dev libfreetype6-dev libbz2-dev libc-client-dev libkrb5-dev

# Clear out the local repository of retrieved package files
RUN apt-get clean

# Install needed extensions
# Here you can install any other extension that you need during the test and deployment process
RUN docker-php-ext-install pdo_mysql mysqli mbstring gd zip && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# show that both Composer and PHP run as expected
RUN composer --version && php -v
#COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install --no-dev --no-scripts

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache