<?php

namespace App\Http\Livewire;

use App\Models\NavigationMenu;

/**
 * Class NavigationMenus
 *
 * Componente para manipulação de dados de menu de navegação
 *
 * @package App\Http\Livewire
 */
class NavigationMenus extends ComponentCrud
{
    public $label;
    public $slug;
    public $sequence = 1;
    public $type = 'SidebarNav';
    public $icon;
    public $permission;

    /**
     * The validation rules.
     * @return array
     */
    public function rules()
    {
        return [
            'label' => 'required',
            'slug' => 'required',
            'sequence' => 'required',
            'type' => 'required',
            'icon' => 'required',
            'permission' => 'required',
        ];
    }

    /**
     * The create function
     */
    public function create()
    {
        $this->validate();
        NavigationMenu::create($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
        session()->flash('success', 'Menu de navegação criado.');
    }

    /**
     * The read function.
     *
     * @return mixed
     */
    public function read()
    {
        return NavigationMenu::paginate(self::TAMANHOPAGINA);
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        NavigationMenu::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
        session()->flash('success', 'Menu de navegação atualizado.');
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        NavigationMenu::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
        session()->flash('info', 'Menu de navegação removido.');
    }

    /**
     * Loads the model data
     * of this component
     */
    public function loadModel()
    {
        $data = NavigationMenu::find($this->modelId);
        $this->label = $data->label;
        $this->slug = $data->slug;
        $this->type = $data->type;
        $this->sequence = $data->sequence;
        $this->icon = $data->icon;
        $this->permission = $data->permission;
    }

    /**
     * The data for the model mapped
     * in this component.
     *
     * @return array
     */
    public function modelData()
    {
        return [
          'label' => $this->label,
          'slug' => $this->slug,
          'sequence' => $this->sequence,
          'type' => $this->type,
          'icon' => $this->icon,
          'permission' => $this->permission,
        ];
    }

    /**
     * Retorna o nome da view padrão
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'livewire.navigation-menus';
    }
}
