FROM php:8.4-fpm-alpine

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
      supervisor \
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

COPY ./docker/php/entrypoint.sh /entrypoint
COPY ./docker/php/supervisord.conf /etc/supervisord.conf
COPY ./docker/php/conf.d/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini
COPY ./docker/php/conf.d/opcache.ini $PHP_INI_DIR/conf.d/opcache.ini

ENV PHP_IDE_CONFIG="serverName=boilerplate"

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY ./backend /app
RUN if [ ! -f .env ]; then cp .env.dist .env; fi

RUN composer install --no-interaction --prefer-dist --optimize-autoloader && \
    composer config --no-plugins allow-plugins.infection/extension-installer true

ENTRYPOINT ["/entrypoint"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
