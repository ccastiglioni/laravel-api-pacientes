FROM php:8.1 as php

RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev vim
RUN docker-php-ext-install pdo pdo_mysql bcmath

RUN docker-php-ext-install pcntl
RUN echo "extension=pcntl.so" >> /usr/local/etc/php/conf.d/docker-php-ext-pcntl.ini

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

WORKDIR /var/www
COPY . .

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

ENV PORT=8000
ENTRYPOINT [ "Docker/entrypoint.sh" ]

# ==============================================================================

WORKDIR /var/www
COPY . .

