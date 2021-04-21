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
    }

    abstract public function create();

    abstract public function read();

    abstract public function modelData();

    abstract public function render();
}
