FROM hub.dds.ufvjm.edu.br/desenvolvimento/laravel-alpine-php8:latest

RUN adduser -S sail -G apache -u 1000

# instalando node e npm
RUN apk add --update \
    nodejs \
    npm

COPY php.ini /etc/php8/conf.d/99-sail.ini
