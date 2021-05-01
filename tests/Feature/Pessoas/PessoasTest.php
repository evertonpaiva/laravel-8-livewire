<?php

namespace Tests\Feature\Pessoas;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Livewire\Pessoas;
use Livewire\Livewire;

/**
 * @group pessoa
 */
class PessoasTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testPessoaPageContainsPessoaComponent()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->get('/pessoas')
            ->assertSeeLivewire('pessoas');
    }

    public function testAdminCanListPessoasWithoutFilters()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->loginIntegracao();

        Livewire::test(Pessoas::class)
            ->call('readyToLoadData');
    }

    public function testAdminCanListPessoaDetail()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->loginIntegracao();

        Livewire::test(Pessoas::class)
            ->call('updateShowModal', 656582)
            ->call('closeUpdateModal');
    }
}
