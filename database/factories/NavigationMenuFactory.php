<?php

namespace Database\Factories;

use App\Models\NavigationMenu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NavigationMenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NavigationMenu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arrayTypes = ['SidebarNav', 'TopNav'];
        $sentence = $this->faker->sentence(3);

        return [
            'sequence' => $this->faker->numberBetween(1, 999999),
            'type' => $arrayTypes[rand(0,1)],
            'label' =>  $sentence,
            'slug' => Str::slug($sentence),
            'icon' => 'fas fa-home',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
