FROM php:8.4-fpm-alpine

USER root

RUN apk update && \
    apk add --no-cache \
      git \
      zip \
      oniguruma-dev \
      linux-headers \
      zlib-dev \
      libzip-dev \
      postgresql-dev \
      postgresql-client \
      libpq \
      libstdc++ \
      bash \
      $PHPIZE_DEPS  \
    && pecl install \
      apcu \
      xdebug \
      redis  \
    && docker-php-ext-install \
      zip \
      pdo_pgsql \
      opcache  \
    && docker-php-ext-enable \
      apcu \
      xdebug \
      redis \
      opcache  \
    && rm -rf /var/cache/apk/*

COPY ./docker/php/conf.d/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini
COPY ./docker/php/conf.d/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini

ENV PHP_IDE_CONFIG="serverName=demo"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY ./backend /app
RUN if [ ! -f .env ]; then cp .env.dist .env; fi

RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    composer config --no-plugins allow-plugins.infection/extension-installer true

CMD ["php-fpm"]
