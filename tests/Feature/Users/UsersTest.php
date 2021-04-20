<?php

namespace Tests\Feature\Users;

use App\Http\Livewire\Users;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Support\Arr;

/**
 * @group user
 */
class UsersTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testUserPageContainsUserComponent()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->get('/users')
            ->assertSeeLivewire('users');
    }

    public function testCanCreateUser()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $userFake = User::factory()->make();

        Livewire::test(Users::class)
            ->set('nome', $userFake->nome)
            ->set('email', $userFake->email)
            ->set('containstitucional', $userFake->containstitucional)
            ->set('cpf', $userFake->cpf)
            ->set('idpessoa', $userFake->idpessoa)
            ->set('password', $userFake->password)
            ->call('create');

        $this->assertDatabaseHas('users', $userFake->getAttributes());
    }

    public function testCheckRequiredFieldsCreateUser()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Users::class)
            ->call('create')
            ->assertHasErrors([
                'nome' => 'required',
                'email' => 'required',
                'containstitucional' => 'required',
                'cpf' => 'required',
                'idpessoa' => 'required',
            ]);
    }

    public function testUserInformationCanBeUpdated()
    {
        $userAdmin = User::factory()->create();
        $userAdmin->assignRole('Admin');
        $this->actingAs($userAdmin);

        $user = User::factory()->create()->first();

        $user->nome = 'Test nome';
        $user->email = 'test@email.com';
        $user->containstitucional = 'test.test';
        $user->cpf = '99999999999';
        $user->idpessoa = 999999;

        Livewire::test(Users::class)
            ->call('updateShowModal', $user->id)
            ->set('nome', $user->nome)
            ->set('email', $user->email)
            ->set('containstitucional', $user->containstitucional)
            ->set('cpf', $user->cpf)
            ->set('idpessoa', $user->idpessoa)
            ->call('update');

        $this->assertDatabaseHas(
            'users',
            Arr::except($user->getAttributes(), ['updated_at'])
        );
    }

    public function testAdminUserCanAddRole()
    {
        $userAdmin = User::factory()->create();
        $userAdmin->assignRole('Admin');
        $this->actingAs($userAdmin);

        $user = User::factory()->create();

        // perfil a adicionar
        $roleName = 'Usuário';

        Livewire::test(Users::class)
            ->call('updateShowModal', $user->id)
            ->set('roleNameAdd', $roleName)
            ->call('update');

        // o perfil adicionado esta no vetor de perfis do usuario?
        $this->assertTrue(
            in_array(
                $roleName,
                $user->fresh()
                    ->getRoleNames()
                    ->toArray()
            )
        );
    }

    public function testAdminUserCanRemoveRole()
    {
        $userAdmin = User::factory()->create();
        $userAdmin->assignRole('Admin');
        $this->actingAs($userAdmin);

        // perfil a remover
        $roleName = 'Usuário';

        $user = User::factory()->create();
        $user->assignRole($roleName);

        Livewire::test(Users::class)
            ->call('updateShowModal', $user->id)
            ->call('update')
            ->call('deleteRoleShowModal', $user->id, $roleName)
            ->call('deleteRole');

        // o perfil adicionado nao esta no vetor de perfis do usuario?
        $this->assertTrue(
            !in_array(
                $roleName,
                $user->fresh()
                    ->getRoleNames()
                    ->toArray()
            )
        );
    }

    public function testUserCanBeDeleted()
    {
        $userAdmin = User::factory()->create();
        $userAdmin->assignRole('Admin');
        $this->actingAs($userAdmin);

        $user = User::factory()->create()->first();

        $component = Livewire::test(Users::class)
            ->call('deleteShowModal', $user->id)
            ->call('delete');

        $this->assertDatabaseMissing('users', $user->getAttributes());
    }
}
