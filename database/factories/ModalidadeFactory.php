<?php

namespace Database\Factories;

use App\Models\Modalidade;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ModalidadeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Modalidade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'idmodalidade' => $this->faker->unique()->numberBetween(1, 1000),
            'modalidade' => Str::upper($this->faker->unique()->word()),
        ];
    }
}
