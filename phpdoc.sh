#!/bin/bash

echo -e "\nGerando documentação"
docker run --rm -v "${PWD}":/data phpdoc/phpdoc:3 run -d ./app -t ./docs

echo -e "\nCorrigindo permissão na pasta docs"
sudo chown -R $USER:$USER ./docs

echo -e "\nConfira a pasta 'docs' para visualizar documentação gerada, abrir index.html com o navegador"
