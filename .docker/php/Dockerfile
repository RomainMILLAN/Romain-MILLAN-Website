FROM php:8.4-apache

LABEL maintainer="Romain MILLAN <contact@romainmillan.fr>"
ARG SERVER_NAME

RUN echo "ServerName ${SERVER_NAME}" >> /etc/apache2/apache2.conf

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev openssl openssh-client sqlite3 libsqlite3-dev unzip 7zip \
    && rm -rf /var/lib/apt/lists/*

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen  \
    && echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
    && locale-gen 

RUN curl -sS https://getcomposer.org/installer | php -- \
    && mv composer.phar /usr/local/bin/composer \
    && curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN docker-php-ext-configure \
            intl \
    && docker-php-ext-install \
            pdo pdo_sqlite opcache 

RUN pecl install apcu && docker-php-ext-enable apcu

WORKDIR /var/www/app/
