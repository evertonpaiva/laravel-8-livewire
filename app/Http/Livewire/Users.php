<?php

namespace App\Http\Livewire;

use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * Class Users
 *
 * Componente para manipulação de dados de usuário
 *
 * @package App\Http\Livewire
 */
class Users extends ComponentCrud
{
    public $modalConfirmRoleDeleteVisible;
    public $roleNameDelete;
    public $roleNameAdd;
    public $searchTerm;
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
     * @return mixed
     */
    public function read()
    {
        $query = '%' . trim($this->searchTerm) . '%';

        return User::where('nome', 'ilike', $query)
            ->orWhere('email', 'ilike', $query)
            ->orWhere('containstitucional', 'ilike', $query)
            ->orderBy('nome')
            ->paginate(self::TAMANHOPAGINA);
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
     * Exibe o modal para apagar um perfil de um usuário
     *
     * @param $id
     * @param $roleName
     */
    public function deleteRoleShowModal($id, $roleName)
    {
        $this->modelId = $id;
        $this->roleNameDelete = $roleName;
        $this->modalConfirmRoleDeleteVisible = true;
    }

    /**
     * Apaga o perfil de um usuário
     */
    public function deleteRole()
    {
        $user = User::find($this->modelId);
        $user->removeRole($this->roleNameDelete);
        $this->roles = $user->getRoleNames();
        $this->remainingRoles= $this->getRemainingRoles();

        $this->modalConfirmRoleDeleteVisible = false;
    }

    /**
     * Calcula vetor de perfis que o usuário não possui no sistema
     *
     * @return array
     */
    public function getRemainingRoles()
    {
        // Todos os perfis do sistema
        $allRoles = Role::pluck('name')->toArray();

        // Todos os perfis que o usuário não tem
        $remainingRoles = [];
        foreach ($allRoles as $key => $value) {
            // Testa se o usuário nao tem o perfil
            if (!in_array($value, $this->roles->toArray())) {
                $remainingRoles[] = $value;
            }
        }

        return $remainingRoles;
    }

    /**
     * Retorna o nome da view padrão
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'livewire.users';
    }
}
