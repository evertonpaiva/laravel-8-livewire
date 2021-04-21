<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ComponentCrud
 *
 * Classe base para criação de formulários CRUD. Os formulários deverão extender essa classe para
 * adquirir algumas funções de manipulação já padronizada
 *
 * @package App\Http\Livewire
 */
abstract class ComponentCrud extends Component
{
    use WithPagination;

    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;
    public $readyToLoad = false;

    /**
     * Shows the create modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->readyToLoadData();
    }

    /**
     * Shows the form modal
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->readyToLoadData();
        $this->modelId = $id;
        $this->loadModel();
    }

    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
        $this->readyToLoadData();
    }

    /**
     * Marca que o componente está pronto para carregar
     * os dados
     */
    public function readyToLoadData()
    {
        $this->readyToLoad = true;
    }

    /**
     * Carrega os dados e renderiza o componente na tela
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view($this->getDefaultView(), [
            'data' => $this->readyToLoad ? $this->read() : [],
        ]);
    }

    abstract public function create();

    abstract public function read();

    abstract public function modelData();

    abstract public function getDefaultView();
}
