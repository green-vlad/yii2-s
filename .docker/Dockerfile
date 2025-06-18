FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip mbstring

ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} app && \
    useradd -m -u ${UID} -g app -s /bin/bash app

WORKDIR /var/www/html
USER app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

EXPOSE 9000
CMD ["php-fpm"]