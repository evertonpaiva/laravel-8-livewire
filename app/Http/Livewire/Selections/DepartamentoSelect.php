<?php

namespace App\Http\Livewire\Selections;

use Illuminate\Support\Collection;
use App\Models\Departamento;

class DepartamentoSelect extends BaseSelect
{
    protected $listeners = [
        'buscaDepartamentoChanged' => 'setSearchable'
    ];

    public function options($searchTerm = null) : Collection
    {
        $departamentos = Departamento::where('nome', 'ilike', '%'.$searchTerm.'%')
            ->orWhere('depto', 'ilike', '%'.$searchTerm.'%')
            ->orderBy('nome')
            ->get();

        $arrayData = [];
        foreach ($departamentos as $departamento) {
            $arrayData[] = array(
                'value' => $departamento->iddepto,
                'description' => $departamento->nome . ' (' . $departamento->iddepto . ')',
            );
        }

        return collect($arrayData);
    }

    public function selectedOption($value)
    {
        $this->emit('departamentoSelected', $value);

        $departamento = Departamento::where('iddepto', '=', $value)
            ->first();

        return array(
            'value' => $departamento->iddepto,
            'description' => $departamento->nome . ' (' . $departamento->iddepto . ')',
        );
    }
}
