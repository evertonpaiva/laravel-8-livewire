<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;
    public $searchTerm;

    /**
     * Put your custom public properties here!
     */
    public $role = 'user';
    public $nome;
    public $email;
    public $cpf;
    public $idpessoa;
    public $containstitucional;
    public $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'role' => 'required',
            'nome' => 'required',
            'email' => 'required',
            'cpf' => 'required',
            'idpessoa' => 'required',
            'containstitucional' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = User::find($this->modelId);
        $this->role = $data->role;
        $this->nome = $data->nome;
        $this->email = $data->email;
        $this->cpf = $data->cpf;
        $this->idpessoa = $data->idpessoa;
        $this->containstitucional = $data->containstitucional;
        $this->password = $data->password;
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
            'role' => $this->role,
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'idpessoa' => $this->idpessoa,
            'containstitucional' => $this->containstitucional,
            'password' => $this->password,
        ];
    }

    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        User::create($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return User::where(function ($sub_query) {
            $query = '%' . trim(strtolower($this->searchTerm)) . '%';

            $sub_query->whereRaw('LOWER(nome) like ?', [$query])
                ->orWhereRaw('LOWER(email) like ?', [$query])
                ->orWhereRaw('LOWER(containstitucional) like ?', [$query]);
        })->paginate(10);
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        User::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        User::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

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

    public function render()
    {
        return view('livewire.users', [
            'data' => $this->read(),
        ]);
    }
}
