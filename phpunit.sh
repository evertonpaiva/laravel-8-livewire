#!/bin/bash

CONTAINER_WEB_NAME=laravel_dds_web
CONFIGURATION_FILE='phpunit.xml'
PHPUNIT_LOG_FILE=/tmp/phpunit-log.txt
MINIMUM_CODE_COVERAGE=80

# Guardando inicio da execucao dos testes
start_time=`date +%s`

echo -e "\nLimpando cache de configuracoes"
docker exec -it ${CONTAINER_WEB_NAME} php artisan config:clear

echo -e "\nRemovendo arquivo de log"
rm -rf ${PHPUNIT_LOG_FILE}

# Executando os testes, jogando saida dos testes em arquivo temporario
# Guardando o retorno do PHPUnit em variavel
echo -e "\nExecutando testes"
docker exec -it ${CONTAINER_WEB_NAME} php artisan test
RETORNO=${PIPESTATUS[0]}

echo -e "\nCopiando arquivo de log para maquina local"
docker cp ${CONTAINER_WEB_NAME}:/${PHPUNIT_LOG_FILE} ${PHPUNIT_LOG_FILE}

# Extraindo do arquivo o % de cobertura de código
#COVERAGE=$(egrep '^\s*Lines:\s*\d+.\d+\%' $PHPUNIT_LOG_FILE | egrep -o '[0-9\.]+%' | tr -d '%')
COVERAGE=$(grep -o -P '^\s*Lines:\s*\d+.\d+\%' /tmp/phpunit-log.txt | egrep -o '[0-9\.]+%' | tr -d '%')

end_time=`date +%s`
# Calculando e exibindo duração dos testes
echo -e "\n\nDuracao dos testes: `expr $end_time - $start_time`s."

if [ "$RETORNO" -ne 0 ]; then
    echo -e "Falha nos testes do PHP Unit!"
fi

echo -e "Cobertura de código: ${COVERAGE}%."

if (( ! $(echo "$COVERAGE > $MINIMUM_CODE_COVERAGE" | bc -l) )); then
    echo -e "Percentual minimo de cobertura de codigo nao atingida: ${MINIMUM_CODE_COVERAGE}%."
    echo -e "Falha no percentual minimo de cobertura de codigo!"
    exit 1
fi

echo -e "\nCorrigindo permissão na pasta do relatorio de cobertura de codigo"
sudo chown -R $USER:$USER ./coverage

echo -e "\nConfira a pasta 'coverage' para relatorio de cobertura de codigo, abrir index.html com o navegador"

exit $RETORNO
