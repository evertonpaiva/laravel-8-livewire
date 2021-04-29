<?php

namespace App\Http\Livewire;

use App\Models\Importacao;
use App\Models\Modalidade;
use App\Models\Disciplina;
use App\Jobs\ImportDisciplina;
use App\Jobs\ImportModalidadeCurso;

/**
 * Class Users
 *
 * Componente para manipulação de dados de importação de dados
 *
 * @package App\Http\Livewire
 */
class Importacoes extends ComponentCrud
{
    public $searchTerm;
    public $type;
    public $modelType;
    public $started = false;
    public $success;
    public $requisicoes;
    public $processados;
    public $importados;
    public $ignorados;

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Importacao::find($this->modelId);
        $this->modelType = $data->model_type;
        $this->started = $data->started;
        $this->success = $data->success;
        $this->requisicoes = $data->requisicoes;
        $this->processados = $data->processados;
        $this->importados = $data->importados;
        $this->ignorados = $data->ignorados;
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
            'model_type' => $this->modelType,
        ];
    }

    /**
     * The validation rules.
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
        ];
    }

    /**
     * The read function.
     *
     * @return mixed
     */
    public function read()
    {
        #$query = '%' . trim($this->searchTerm) . '%';

        return Importacao::query()
            ->orderBy('id')
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
        return 'livewire.importacoes';
    }

    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        if ($this->type == 'modalidade') {
            $this->modelType = Modalidade::class;
            $this->validate();
            $importacao = Importacao::create($this->modelData());
            ImportModalidadeCurso::dispatch($importacao, $this->modelType);
        } elseif ($this->type == 'disciplina') {
            $this->modelType = Disciplina::class;
            $this->validate();
            $importacao = Importacao::create($this->modelData());
            ImportDisciplina::dispatch($importacao, $this->modelType);
        } else {
            session()->flash('warning', 'Tipo de importação \''. $this->type. '\' inválida');
            return;
        }
        $this->reset();
        $this->readyToLoadData();
        session()->flash('success', 'Importação cadastrada.');
    }
}
