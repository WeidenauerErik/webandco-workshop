FROM nginx:alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
    php84 \
    php84-fpm \
    php84-mysqli \
    php84-pdo \
    php84-pdo_mysql \
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
    php84-xml \
    php84-dom \
    php84-xmlwriter \
    php84-simplexml \
    php84-fileinfo \
    supervisor \
    curl \
    bash \
    shadow

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN adduser -D -g '' php \
    && mkdir -p /var/www/html \
    && chown -R php:php /var/www/html

# Copy Nginx config and Supervisor config
COPY ./default.conf /etc/nginx/conf.d/default.conf
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./php-fpm.conf /etc/php84/php-fpm.d/www.conf

RUN mkdir -p /var/log && touch /var/log/php-fpm.log && chown -R php:php /var/log

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
