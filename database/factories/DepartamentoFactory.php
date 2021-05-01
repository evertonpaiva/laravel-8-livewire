<?php

namespace Database\Factories;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DepartamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Departamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'iddepto' => $this->faker->unique()->numerify('###'),
            'depto' => Str::upper($this->faker->word()),
            'nome' =>  Str::upper($this->faker->sentence(3)),
        ];
    }
}
