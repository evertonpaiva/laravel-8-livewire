#!/bin/bash

CONTAINER_WEB_NAME=laravel_dds_web

echo -e "\nValidando Padrao de codificacao"
docker exec -it ${CONTAINER_WEB_NAME} ./vendor/bin/phpcs
RETORNO=$?

exit $RETORNO
