<?php

namespace App\Http\Livewire;

use GraphqlClient\GraphqlRequest\Ensino\CursoGraphqlRequest;
use App\Http\Traits\CursorRelayPagination;
use App\Models\Modalidade;
use App\Models\TipoCurso;

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
    public $idmodalidade;
    public $idtipocurso;
    public $modalidades = [];
    public $tiposCurso = [];

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
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
        $modalidades = Modalidade::all([
            'idmodalidade',
            'modalidade',
        ])->toArray();

        $arrayModalidades = [];
        foreach ($modalidades as $modalidade) {
            $arrayModalidades[Modalidade::idModalidadeToEnum($modalidade['idmodalidade'])] =
                $modalidade['modalidade'];
        }
        $this->modalidades = $arrayModalidades;

        if (empty($this->idmodalidade)) {
            $this->idmodalidade = null;
        }

        if (empty($this->idtipocurso)) {
            $this->idtipocurso = null;
        }

        $tiposCurso = TipoCurso::all([
            'idtipocurso',
            'tipocurso',
        ])->toArray();

        $arrayTiposCurso = [];
        foreach ($tiposCurso as $tipoCurso) {
            $arrayTiposCurso[TipoCurso::idTipoCursoToEnum($tipoCurso['idtipocurso'])] =
                $tipoCurso['tipocurso'];
        }
        $this->tiposCurso = $arrayTiposCurso;

        try {
            // Carrega a classe de curso
            $cursoGraphqlRequest = new CursoGraphqlRequest();

            // Define a paginacao
            $this->setPaginationDirection();

            // Define a requisicao e seus relacionamentos
            $cursos =
                $cursoGraphqlRequest
                    ->addRelationTipoCurso()
                    ->addRelationModalidade()
                    ->queryList($this->pagination, $this->searchTerm, $this->idtipocurso, $this->idmodalidade)
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
        $this->modalFormVisible = false;
    }
}
