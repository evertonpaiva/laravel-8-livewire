<?php

namespace Tests\Feature\Cursos;

use App\Models\User;
use App\Models\TipoCurso;
use App\Models\Modalidade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Livewire\Cursos;
use Livewire\Livewire;

/**
 * @group curso
 */
class CursosTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testCursoPageContainsCursoComponent()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->get('/cursos')
            ->assertSeeLivewire('cursos');
    }

    public function testAdminCanListCursosWithoutFilters()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->loginIntegracao();

        Livewire::test(Cursos::class)
            ->call('readyToLoadData');
    }

    public function testAdminCanListCursosWithFilters()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        TipoCurso::factory()->count(3)->create();
        Modalidade::factory()->count(3)->create();

        $this->loginIntegracao();

        Livewire::test(Cursos::class)
            ->set('idmodalidade', 'PRESENCIAL')
            ->set('idtipocurso', 'GRADUACAO')
            ->call('readyToLoadData');
    }
}
