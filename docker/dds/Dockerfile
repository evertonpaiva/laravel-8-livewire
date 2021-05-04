FROM hub.dds.ufvjm.edu.br/desenvolvimento/laravel-alpine-php8:latest

ARG WWWUSER=1000

RUN adduser -S sail -G apache -u ${WWWUSER}

# instalando node e npm
RUN apk add --update \
    nodejs \
    npm

COPY php.ini /etc/php8/conf.d/99-sail.ini
