<?php

namespace App\Jobs;

use App\Models\Disciplina;
use GraphqlClient\GraphqlRequest\Ensino\DisciplinaGraphqlRequest;

class ImportDisciplina extends ImportIntegracao
{
    protected function importaDados()
    {
        // Carrega a classe de disciplina
        $disciplinaGraphqlRequest = new DisciplinaGraphqlRequest();

        // Loop de requisicoes enquanto existir novas páginas de registros
        do {
            $this->setPagination();

            // Define a requisicao e seus relacionamentos
            $disciplinas =
                $disciplinaGraphqlRequest
                    ->queryList($this->pagination)
                    ->getResults();

            $this->requisicoes++;

            // Loop de registros (edges) de cada requisicao
            foreach ($disciplinas->edges as $disciplina) {
                $this->processados++;
                $registroExiste = Disciplina::where('disciplina', $disciplina->node->disciplina)->exists();

                // registro nao existe no banco
                if (!$registroExiste) {
                    Disciplina::create([
                        'disciplina' => $disciplina->node->disciplina,
                        'nome' => $disciplina->node->nome,
                    ]);
                    $this->importados++;
                } else {
                    $this->ignorados++;
                }
            }
            $this->showLog();
            $this->endCursor = $disciplinas->pageInfo->endCursor;

            // Aguarda x segundos entre requisições, para não ultrapassar limite de requisicoes do servidor
            $this->updateProgress();
            sleep(ImportIntegracao::$DELAY_REQUEST);
        } while ($disciplinas->pageInfo->hasNextPage);
    }
}
