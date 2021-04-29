FROM php:8.0-fpm-alpine

RUN apk add supervisor
RUN addgroup app && adduser -D -G app app && echo "app ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers
RUN set -ex  && apk --no-cache add  postgresql-dev
RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY --chown=app:app ./docker/php/supervisord.conf /home/app/supervisord.conf

COPY --chown=app:app . /home/app/app

USER app

WORKDIR /home/app/app

CMD ["supervisord", "-c", "/home/app/supervisord.conf"]