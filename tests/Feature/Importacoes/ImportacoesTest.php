<?php

namespace Tests\Feature\Importacoes;

use App\Http\Livewire\Importacoes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Facades\Bus;
use App\Jobs\ImportModalidadeCurso;
use App\Jobs\ImportDepartamento;
use App\Jobs\ImportTipoCurso;
use App\Jobs\ImportDisciplina;

/**
 * @group importacao
 */
class ImportacoesTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function testImportacaoPageContainsImportacaoComponent()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        $this->get('/importacoes')
            ->assertSeeLivewire('importacoes');
    }

    public function testAdminCanListImportacoes()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Livewire::test(Importacoes::class)
            ->call('readyToLoadData');
    }

    public function testAdminCanCreateImportacaoModalidade()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Bus::fake();

        Livewire::test(Importacoes::class)
            ->call('createShowModal')
            ->set('type', 'modalidade')
            ->call('create');

        // Assert that a job was dispatched...
        Bus::assertDispatched(ImportModalidadeCurso::class);
    }

    public function testAdminCanCreateAndRunImportacaoModalidade()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Livewire::test(Importacoes::class)
            ->call('createShowModal')
            ->set('type', 'modalidade')
            ->call('create');
    }

    public function testAdminCanCreateImportacaoDepartamento()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Bus::fake();

        Livewire::test(Importacoes::class)
            ->call('createShowModal')
            ->set('type', 'departamento')
            ->call('create');

        // Assert that a job was dispatched...
        Bus::assertDispatched(ImportDepartamento::class);
    }

    public function testAdminCanCreateAndRunImportacaoDepartamento()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Livewire::test(Importacoes::class)
            ->call('createShowModal')
            ->set('type', 'departamento')
            ->call('create');
    }

    public function testAdminCanCreateImportacaoTipoCurso()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Bus::fake();

        Livewire::test(Importacoes::class)
            ->call('createShowModal')
            ->set('type', 'tipocurso')
            ->call('create');

        // Assert that a job was dispatched...
        Bus::assertDispatched(ImportTipoCurso::class);
    }

    public function testAdminCanCreateAndRunImportacaoTipoCurso()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Livewire::test(Importacoes::class)
            ->call('createShowModal')
            ->set('type', 'tipocurso')
            ->call('create');
    }


    public function testAdminCanCreateImportacaoDisciplina()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Bus::fake();

        Livewire::test(Importacoes::class)
            ->call('createShowModal')
            ->set('type', 'disciplina')
            ->call('create');

        // Assert that a job was dispatched...
        Bus::assertDispatched(ImportDisciplina::class);
    }

    public function testAdminCanCreateAndRunImportacaoDisciplina()
    {
        $user = User::factory()->create();
        $user->assignRole('Admin');
        $this->actingAs($user);

        Livewire::test(Importacoes::class)
            ->call('createShowModal')
            ->set('type', 'disciplina')
            ->call('create');
    }
}
