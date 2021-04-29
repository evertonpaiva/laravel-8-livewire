<?php

namespace App\Jobs;

use App\Models\Departamento;
use GraphqlClient\GraphqlRequest\Ensino\DepartamentoGraphqlRequest;

class ImportDepartamento extends ImportIntegracao
{
    protected function importaDados()
    {
        // Carrega a classe de departamento
        $departamentoGraphqlRequest = new DepartamentoGraphqlRequest();

        // Loop de requisicoes enquanto existir novas páginas de registros
        do {
            $this->setPagination();

            // Define a requisicao e seus relacionamentos
            $departamentos =
                $departamentoGraphqlRequest
                    ->queryList($this->pagination)
                    ->getResults();

            $this->requisicoes++;

            // Loop de registros (edges) de cada requisicao
            foreach ($departamentos->edges as $departamento) {
                $this->processados++;
                $registroExiste = Departamento::where('iddepto', $departamento->node->iddepto)->exists();

                // registro nao existe no banco
                if (!$registroExiste) {
                    Departamento::create([
                        'iddepto' => $departamento->node->iddepto,
                        'depto' => $departamento->node->depto,
                        'nome' => $departamento->node->nome,
                    ]);
                    $this->importados++;
                } else {
                    $this->ignorados++;
                }
            }
            $this->showLog();
            $this->endCursor = $departamentos->pageInfo->endCursor;

            // Aguarda x segundos entre requisições, para não ultrapassar limite de requisicoes do servidor
            $this->updateProgress();
            sleep(ImportIntegracao::$DELAY_REQUEST);
        } while ($departamentos->pageInfo->hasNextPage);
    }
}
