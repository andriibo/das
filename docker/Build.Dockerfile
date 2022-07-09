FROM php:8.1-fpm

COPY php.ini $PHP_INI_DIR

RUN apt-get update && apt-get install -y \
    cron \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable pdo_mysql

RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
    intl \
    gettext

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY start.sh /etc/cron.d/crontab

RUN usermod --non-unique --uid 1000 www-data \
 && groupmod --non-unique --gid 1000 www-data

RUN chmod 0644 /etc/cron.d/crontab
RUN crontab /etc/cron.d/crontab
RUN touch /var/log/cron.log

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]