FROM php:cli

MAINTAINER Olivier REVOLLAT <revollat@gmail.com>

RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

RUN docker-php-ext-install pdo pdo_mysql opcache
COPY config/php.ini /usr/local/etc/php/

WORKDIR /var/www/symfony
