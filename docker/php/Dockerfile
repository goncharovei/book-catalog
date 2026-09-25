FROM php:8.2-fpm-alpine

# Системные зависимости
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    libzip-dev \
    mysql-client \
    nodejs \
    npm \
    bash

# PHP расширения
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Redis через PECL (с обновлением каналов)
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl channel-update pecl.php.net \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Entrypoint
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www

# Копируем исходники (для первого билда, чтобы был composer.json)
COPY src/ .

# Убираем composer install из сборки — он теперь в entrypoint
# RUN composer install ...

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]
