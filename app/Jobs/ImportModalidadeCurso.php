<?php

namespace App\Jobs;

use App\Models\Modalidade;
use GraphqlClient\GraphqlRequest\Ensino\ModalidadeGraphqlRequest;

class ImportModalidadeCurso extends ImportIntegracao
{
    protected function importaDados()
    {
        // Carrega a classe de modalidade
        $modalidadeGraphqlRequest = new ModalidadeGraphqlRequest();

        // Loop de requisicoes enquanto existir novas páginas de registros
        do {
            $this->setPagination();

            // Define a requisicao e seus relacionamentos
            $modalidades =
                $modalidadeGraphqlRequest
                    ->queryList($this->pagination)
                    ->getResults();

            $this->requisicoes++;

            // Loop de registros (edges) de cada requisicao
            foreach ($modalidades->edges as $modalidade) {
                $this->processados++;
                $registroExiste = Modalidade::where('idmodalidade', $modalidade->node->idmodalidade)->exists();

                // registro nao existe no banco
                if (!$registroExiste) {
                    Modalidade::create([
                        'idmodalidade' => $modalidade->node->idmodalidade,
                        'modalidade' => $modalidade->node->modalidade,
                    ]);
                    $this->importados++;
                } else {
                    $this->ignorados++;
                }
            }
            $this->showLog();
            $this->endCursor = $modalidades->pageInfo->endCursor;

            // Aguarda x segundos entre requisições, para não ultrapassar limite de requisicoes do servidor
            $this->updateProgress();
            sleep(ImportIntegracao::$DELAY_REQUEST);
        } while ($modalidades->pageInfo->hasNextPage);
    }
}
