<?php

namespace Tests\Feature\Disciplinas;

use App\Http\Livewire\Disciplinas;
use App\Models\User;
use App\Models\Disciplina;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * @group disciplina
 */
class DisciplinasTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testDisciplinaPageContainsDisciplinaComponent()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->get('/disciplinas')
            ->assertSeeLivewire('disciplinas');
    }

    public function testAdminCanListDisciplinasWithFilters()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Disciplina::factory()->count(20)->create();

        Livewire::test(Disciplinas::class)
            ->set('iddepto', 'ADM')
            ->call('readyToLoadData');
    }
}
