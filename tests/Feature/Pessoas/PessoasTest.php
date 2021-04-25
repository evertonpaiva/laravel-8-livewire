<?php

namespace Tests\Feature\Pessoas;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
