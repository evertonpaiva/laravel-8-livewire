<?php

namespace App\Http\Livewire;

use GraphqlClient\GraphqlRequest\Common\PessoaGraphqlRequest;
use GraphqlClient\GraphqlQuery\BackwardPaginationQuery;
use GraphqlClient\GraphqlQuery\ForwardPaginationQuery;

/**
 * Class Users
 *
 * Componente para manipulação de dados de pessoa
 *
 * @package App\Http\Livewire
 */
class Pessoas extends ComponentCrud
{
    public $searchTerm;
    public $idpessoa;
    public $nome;
    public $email;
    public $cpf;
    public $containstitucional;

    public $navStartCursor;
    public $navEndCursor;
    public $navAction;
    public $navHasNextPage;
    public $navHasPreviousPage;

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = User::find($this->modelId);
        $this->nome = $data->nome;
        $this->email = $data->email;
        $this->cpf = $data->cpf;
        $this->idpessoa = $data->idpessoa;
        $this->containstitucional = $data->containstitucional;
        $this->password = $data->password;
        $this->roles = $data->getRoleNames();
        $this->remainingRoles= $this->getRemainingRoles();
    }

    /**
     * The data for the model mapped
     * in this component.
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'idpessoa' => $this->idpessoa,
            'containstitucional' => $this->containstitucional,
            'password' => $this->password,
            'roles' => $this->roles,
            'remainingRoles' => $this->remainingRoles
        ];
    }

    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
    }

    /**
     * The read function.
     *
     * @return mixed
     */
    public function read()
    {
        $query = '%' . trim($this->searchTerm) . '%';

        try {
            // Carrega a classe de pessoa
            $pessoaGraphqlRequest = new PessoaGraphqlRequest();

            // Paginacao para frente, partindo de um determinado registro
            if (($this->navAction == 'next')) {
                $pagination = new ForwardPaginationQuery(self::TAMANHOPAGINA, $this->navEndCursor);
                // Paginacao para tras, partindo de um determinado registro
            } elseif ($this->navAction == 'previous') {
                $pagination = new BackwardPaginationQuery(self::TAMANHOPAGINA, $this->navStartCursor);
                // Sem paginacao, primeiros registros
            } else {
                $pagination = new ForwardPaginationQuery(self::TAMANHOPAGINA);
            }

            $pessoas =
                $pessoaGraphqlRequest
                    ->addRelationServidores()
                    ->addRelationAlunos()
                    ->queryList($pagination, $query)
                    ->getResults();
        } catch (\Exception $e) {
            dd($e->getMessage());
            // TO-DO Implementar o tratamento aqui
            //return checkGraphqlRequestException($e);
        }

        $this->navHasNextPage = $pessoas->pageInfo->hasNextPage;
        $this->navHasPreviousPage = $pessoas->pageInfo->hasPreviousPage;
        $this->navStartCursor = $pessoas->pageInfo->startCursor;
        $this->navEndCursor = $pessoas->pageInfo->endCursor;

        $this->navAction = null;

        /*if(count($pessoas->edges[0]->node->alunos->edges) > 0){
            dd($pessoas->edges[0]->node->alunos->edges[0]->node);
        }*/

        return $pessoas->edges;
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
    }

    /**
     * Retorna o nome da view padrão
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'livewire.pessoas';
    }

    public function nextPage()
    {
        $this->navAction = 'next';
    }

    public function previousPage()
    {
        $this->navAction = 'previous';
    }
}
