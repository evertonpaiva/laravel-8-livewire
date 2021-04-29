<?php

namespace App\Jobs;

use App\Models\TipoCurso;
use GraphqlClient\GraphqlRequest\Ensino\TipoCursoGraphqlRequest;

class ImportTipoCurso extends ImportIntegracao
{
    protected function importaDados()
    {
        // Carrega a classe de tipo de curso
        $tipoCursoGraphqlRequest = new TipoCursoGraphqlRequest();

        // Loop de requisicoes enquanto existir novas páginas de registros
        do {
            $this->setPagination();

            // Define a requisicao e seus relacionamentos
            $tiposCurso =
                $tipoCursoGraphqlRequest
                    ->queryList($this->pagination)
                    ->getResults();

            $this->requisicoes++;

            // Loop de registros (edges) de cada requisicao
            foreach ($tiposCurso->edges as $tipocurso) {
                $this->processados++;
                $registroExiste = TipoCurso::where('idtipocurso', $tipocurso->node->idtipocurso)->exists();

                // registro nao existe no banco
                if (!$registroExiste) {
                    TipoCurso::create([
                        'idtipocurso' => $tipocurso->node->idtipocurso,
                        'tipocurso' => $tipocurso->node->tipocurso,
                    ]);
                    $this->importados++;
                } else {
                    $this->ignorados++;
                }
            }
            $this->showLog();
            $this->endCursor = $tiposCurso->pageInfo->endCursor;

            // Aguarda x segundos entre requisições, para não ultrapassar limite de requisicoes do servidor
            $this->updateProgress();
            sleep(ImportIntegracao::$DELAY_REQUEST);
        } while ($tiposCurso->pageInfo->hasNextPage);
    }
}
