<?php

namespace App\Http\Livewire;

use GraphqlClient\GraphqlRequest\Common\PessoaGraphqlRequest;
use App\Http\Traits\CursorRelayPagination;

/**
 * Class Users
 *
 * Componente para manipulação de dados de pessoa
 *
 * @package App\Http\Livewire
 */
class Pessoas extends ComponentCrud
{
    use CursorRelayPagination;

    public $searchTerm;
    public $idpessoa;
    public $nome;
    public $cpf;
    public $containstitucional;

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

            // Define a paginacao
            $this->setPaginationDirection();

            // Define a requisicao e seus relacionamentos
            $pessoas =
                $pessoaGraphqlRequest
                    ->addRelationServidores()
                    ->addRelationAlunos()
                    ->queryList($this->pagination, $query)
                    ->getResults();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('error', $message);
            return [];
        }

        // Atualiza as informacao de navegacao de paginas
        $this->setPageInfo($pessoas->pageInfo);

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
}
