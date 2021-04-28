<?php

namespace App\Http\Livewire;

use GraphqlClient\GraphqlRequest\Ensino\CursoGraphqlRequest;
use App\Http\Traits\CursorRelayPagination;

/**
 * Class Users
 *
 * Componente para manipulação de dados de pessoa
 *
 * @package App\Http\Livewire
 */
class Cursos extends ComponentCrud
{
    use CursorRelayPagination;

    public $searchTerm;
    public $curso;
    public $nome;

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        try {
            // Carrega a classe de alunos, para adicionar os relacionamentos
            $alunoGraphqlRequest = new AlunoGraphqlRequest();
            $alunoGraphqlRequest->addRelationPrograma();
            $alunoGraphqlRequest->addRelationSituacao();

            // Carrega a classe de pessoa
            $pessoaGraphqlRequest = new PessoaGraphqlRequest();

            $pessoa =
                $pessoaGraphqlRequest
                    ->addRelationServidores()
                    ->addRelationAlunos($alunoGraphqlRequest)
                    ->queryGetById((int) $this->modelId)->getResults();

            $cursos = array();
            foreach ($pessoa->alunos->edges as $aluno) {
                // Se ainda nao buscou os dados desse curso
                if (!array_key_exists($aluno->node->objPrograma->curso, $cursos)) {
                    $curso = $aluno->node->objPrograma->curso;

                    // Carrega a classe de cursos
                    $cursoGraphqlRequest = new CursoGraphqlRequest();
                    $dadosCurso = $cursoGraphqlRequest->queryGetById($curso)->getResults();
                    $cursos[$dadosCurso->curso] = $dadosCurso->nome;
                    $aluno->node->objPrograma->nomecurso = $dadosCurso->nome;
                } else {
                    // Ja pesquisou o nome, preenchendo o nome
                    $aluno->node->objPrograma->nomecurso = $cursos[$aluno->node->objPrograma->curso];
                }

                // Define a cor do aluno pela sua situacao
                $aluno->node->objSituacao->cor = $this->getCorPorSituacaoAluno($aluno->node->objSituacao->idsituacao);
            }

            foreach ($pessoa->servidores->edges as $servidor) {
                $servidor->node->cor = $this->getCorPorSituacaoServidor($servidor->node->situacao);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('error', $message);
            return;
        }

        #dd($pessoa->servidores->edges[0]->node);

        $this->nome = $pessoa->nome;
        $this->cpf = $pessoa->cpf;
        $this->idpessoa = $pessoa->idpessoa;
        $this->containstitucional = $pessoa->containstitucional;
        $this->alunos = $pessoa->alunos->edges;
        $this->servidores = $pessoa->servidores->edges;
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
            'curso' => $this->curso,
            'nome' => $this->nome,
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
        $termo = trim($this->searchTerm);
        if (!is_null($termo)) {
            $query = $termo;
        } else {
            $query = null;
        }

        try {
            // Carrega a classe de pessoa
            $cursoGraphqlRequest = new CursoGraphqlRequest();

            // Define a paginacao
            $this->setPaginationDirection();

            // Define a requisicao e seus relacionamentos
            $cursos =
                $cursoGraphqlRequest
                    ->addRelationTipoCurso()
                    ->addRelationModalidade()
                    ->queryList($this->pagination, $query)
                    ->getResults();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            session()->flash('error', $message);
            return [];
        }

        // Atualiza as informacao de navegacao de paginas
        $this->setPageInfo($cursos->pageInfo);

        return $cursos->edges;
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
        return 'livewire.cursos';
    }

    public function closeUpdateModal()
    {
        $this->alunos = [];
        $this->servidores = [];
        $this->modalFormVisible = false;
    }
}
