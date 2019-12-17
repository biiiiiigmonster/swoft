# @description php image base on the debian 9.x
#
#                       Some Information
# ------------------------------------------------------------------------------------
# @link https://hub.docker.com/_/debian/      alpine image
# @link https://hub.docker.com/_/php/         php image
# @link https://github.com/docker-library/php php dockerfiles
# @see https://github.com/docker-library/php/tree/master/7.2/stretch/cli/Dockerfile
# ------------------------------------------------------------------------------------
# @build-example docker build . -f Dockerfile -t swoft/swoft
#
FROM php:7.4.0

LABEL maintainer="inhere <in.798@qq.com>" version="2.0"

# --build-arg timezone=Asia/Shanghai
ARG timezone
# app env: prod pre test dev
ARG app_env=prod
# default use www-data user
ARG work_user=www-data

ENV APP_ENV=${app_env:-"prod"} \
    TIMEZONE=${timezone:-"Asia/Shanghai"} \
    PHPREDIS_VERSION=5.1.1 \
    SWOOLE_VERSION=4.4.12 \
    COMPOSER_ALLOW_SUPERUSER=1

# Libs -y --no-install-recommends
RUN apt-get update \
    &&  apt-get install -y \
        curl openssl \
        libpng-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
# Install PHP extensions
    && docker-php-ext-install \
       bcmath gd pdo_mysql sockets sysvmsg sysvsem sysvshm
# Install composer
Run curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update --clean-backups
# Install redisi swoole extension
Run pecl install redis-${PHPREDIS_VERSION} \
    && pecl install swoole-${SWOOLE_VERSION} \
    && docker-php-ext-enable redis swoole \
# Clear dev deps
    && apt-get clean \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \
# Timezone
    && cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    && echo "[Date]\ndate.timezone=${TIMEZONE}" > /usr/local/etc/php/conf.d/timezone.ini

# Install composer deps
ADD . /var/www/swoft
RUN  cd /var/www/swoft \
    && composer install \
    && composer clearcache

WORKDIR /var/www/swoft
EXPOSE 18306 18307 18308

# ENTRYPOINT ["php", "/var/www/swoft/bin/swoft", "http:start"]
# CMD ["php", "/var/www/swoft/bin/swoft", "http:start"]

