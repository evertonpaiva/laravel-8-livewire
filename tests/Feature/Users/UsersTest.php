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

    /** @test */
    public function user_page_contains_user_component()
    {
        $this->actingAs(User::factory(['role' => 'admin'])->create());

        $this->get('/users')
            ->assertSeeLivewire('users');
    }

    /**
     * @test
     */
    public function canCreateUser()
    {
        $this->actingAs(User::factory()->create());

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

    /**
     * @test
     */
    public function checkRequiredFieldsCreateUser()
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
