<?php

namespace Database\Factories;

use App\Models\TipoCurso;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TipoCursoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TipoCurso::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idtipocurso' => Str::upper($this->faker->unique()->randomLetter()),
            'tipocurso' => Str::upper($this->faker->unique()->word()),
        ];
    }
}
