FROM php:cli

MAINTAINER Olivier REVOLLAT <revollat@gmail.com>

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev
    
# RUN curl -sS -o /tmp/icu.tar.gz -L http://download.icu-project.org/files/icu4c/59.1/icu4c-59_1-src.tgz && \
#     tar -zxf /tmp/icu.tar.gz -C /tmp && \
#     cd /tmp/icu/source && \
#     ./configure --prefix=/usr/local && \
#     make && \
#     make install

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

COPY config/php.ini /usr/local/etc/php/

# RUN docker-php-ext-configure intl --with-icu-dir=/usr/local && \
#     docker-php-ext-install -j$(nproc) intl
    
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install -j$(nproc) pdo pdo_mysql opcache gd

WORKDIR /var/www/symfony
