<?php

namespace Tests\Feature\Users;

use App\Http\Livewire\Users;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

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
}
