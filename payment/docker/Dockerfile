FROM php:8.3-fpm-alpine AS base

# System dependencies
RUN apk add --no-cache \
    autoconf \
    g++ \
    make \
    linux-headers \
    bash \
    git \
    unzip \
    curl \
    icu-dev \
    libpq-dev \
    libzip-dev \
    oniguruma-dev \
    supervisor \
    && docker-php-ext-install \
        intl \
        pdo \
        pdo_pgsql \
        zip \
        opcache \
        mbstring \
    && pecl install apcu \
    && docker-php-ext-enable apcu

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ─── Development stage ───────────────────────────────────────────────────────
FROM base AS dev

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY docker/php/conf.d/app.ini    /usr/local/etc/php/conf.d/app.ini

USER www-data

# ─── Production stage ─────────────────────────────────────────────────────────
FROM base AS prod

COPY docker/php/conf.d/app.ini            /usr/local/etc/php/conf.d/app.ini
COPY docker/php/conf.d/app.prod.ini       /usr/local/etc/php/conf.d/app.prod.ini
COPY docker/php/php-fpm.d/zz-docker.conf  /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/supervisor/supervisord.conf   /etc/supervisor/conf.d/supervisord.conf

COPY --chown=www-data:www-data . .

RUN composer install --no-dev --optimize-autoloader --no-scripts \
    && php bin/console cache:warmup --env=prod

# Supervisor запускает и php-fpm, и воркеры очередей одновременно
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
