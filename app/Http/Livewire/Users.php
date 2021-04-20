<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination;

    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modalConfirmRoleDeleteVisible;
    public $roleNameDelete;
    public $roleNameAdd;
    public $modelId;
    public $searchTerm;

    /**
     * Put your custom public properties here!
     */
    public $nome;
    public $email;
    public $cpf;
    public $idpessoa;
    public $containstitucional;
    public $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
    public $roles = [];
    public $remainingRoles = [];

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [
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
        $query = '%' . trim($this->searchTerm) . '%';

        return User::where('nome', 'ilike', $query)
            ->orWhere('email', 'ilike', $query)
            ->orWhere('containstitucional', 'ilike', $query)
            ->orderBy('nome')
            ->paginate(10);
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        $user = User::find($this->modelId);
        $user->update($this->modelData());

        // caso tenha selecionado um perfil a adicionar, o adiciona
        if (isset($this->roleNameAdd)) {
            $user->assignRole($this->roleNameAdd);
            $this->roles = $user->getRoleNames();
            $this->remainingRoles= $this->getRemainingRoles();
        }

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

    public function deleteRoleShowModal($id, $roleName)
    {
        $this->modelId = $id;
        $this->roleNameDelete = $roleName;
        $this->modalConfirmRoleDeleteVisible = true;
    }

    public function deleteRole()
    {
        $user = User::find($this->modelId);
        $user->removeRole($this->roleNameDelete);
        $this->roles = $user->getRoleNames();
        $this->remainingRoles= $this->getRemainingRoles();

        $this->modalConfirmRoleDeleteVisible = false;
    }

    public function getRemainingRoles()
    {
        // Todos os perfis do sistema
        $allRoles = Role::pluck('name')->toArray();

        // Todos os perfis que o usuário não tem
        $remainingRoles = [];
        foreach ($allRoles as $key => $value) {
            // Testa se o usuário nao tem o perfil
            #dd($value, $this->roles->toArray(), !in_array($value, $this->roles->toArray()));
            if (!in_array($value, $this->roles->toArray())) {
                $remainingRoles[] = $value;
            }
        }

        return $remainingRoles;
    }
}
