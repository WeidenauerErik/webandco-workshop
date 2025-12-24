# =========================
# 1. Composer stage
# =========================
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader \
    --no-scripts

# =========================
# 2. Runtime stage
# =========================
FROM nginx:alpine

WORKDIR /var/www/html

# Instal PHP and extenstions
RUN apk add --no-cache \
    php84 \
    php84-fpm \
    php84-pgsql \
    php84-pdo_pgsql \
    php84-intl \
    php84-zip \
    php84-opcache \
    php84-session \
    php84-json \
    php84-ctype \
    php84-tokenizer \
    php84-xml \
    php84-curl \
    php84-mbstring \
    php84-phar \
    php84-openssl \
    php84-iconv \
    php84-dom \
    php84-xmlwriter \
    php84-simplexml \
    php84-fileinfo \
    supervisor \
    curl

# Copy Nginx config and Supervisor config
COPY ./docker/production/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/production/nginx/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./docker/production/nginx/php-fpm.conf /etc/php84/php-fpm.d/www.conf

# Copy app
COPY  . .
COPY --from=vendor /app/vendor ./vendor

# Make sure files/folders needed by the processes are accessable when they run under the nginx user
RUN mkdir -p var/log var/cache var/share && chown -R nginx:nginx var
RUN mkdir -p public/uploads && chown -R nginx:nginx public/uploads

# Make sure socket directory exists
RUN mkdir -p /run && touch /run/php-fpm.sock && chown nginx:nginx /run/php-fpm.sock

EXPOSE 80
VOLUME ["/var/www/html/public/uploads"]

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1/fpm-ping || exit 1
