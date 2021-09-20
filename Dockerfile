FROM php:7.4-fpm-alpine

WORKDIR /app
COPY . /app/

RUN curl -sS https://getcomposer.org/installer | php -- \
            --install-dir=/usr/bin --filename=composer;

RUN composer install  --ignore-platform-reqs --no-ansi --no-scripts --no-progress -o -n -d /app/