<?php

namespace App\Http\Livewire;

use App\Models\Disciplina;
use App\Models\Departamento;

/**
 * Class Users
 *
 * Componente para manipulação de dados de pessoa
 *
 * @package App\Http\Livewire
 */
class Disciplinas extends ComponentCrud
{
    public $searchTerm;
    public $disciplina;
    public $nome;
    public $iddepto;
    public $departamentos = [];

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
        $this->departamentos = Departamento::query()
            ->orderBy('nome')
            ->get()
            ->toArray();

        $query = '%' . trim($this->searchTerm) . '%';

        $disciplinas = Disciplina::with('departamento')
            ->where('nome', 'ilike', $query);

        if ($this->iddepto) {
            $disciplinas = $disciplinas->where('iddepto', $this->iddepto);
        }

        return $disciplinas->orderBy('nome')
            ->paginate(self::TAMANHOPAGINA);
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
        return 'livewire.disciplinas';
    }
}
