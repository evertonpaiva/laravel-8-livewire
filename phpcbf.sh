#!/bin/bash

CONTAINER_WEB_NAME=laravel_dds_web

echo -e "\nCorrigindo automaticamente Padrao de codificacao"
docker exec -it ${CONTAINER_WEB_NAME} ./vendor/bin/phpcbf
RETORNO=$?

exit $RETORNO
