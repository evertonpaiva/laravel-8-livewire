<?php

namespace Database\Factories;

use App\Models\Disciplina;
use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DisciplinaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Disciplina::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'disciplina' => $this->faker->unique()->numberBetween(1, 100000),
            'nome' => Str::upper($this->faker->word()),
            'iddepto' => Departamento::factory()->create()->iddepto,
        ];
    }
}
