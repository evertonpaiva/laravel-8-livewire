<?php

namespace Database\Factories;

use App\Models\UserPermission;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserPermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserPermission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arrayRoles = ['admin', 'user'];
        $sentence = $this->faker->sentence(3);

        return [
            'role' => $arrayRoles[rand(0,1)],
            'route_name' => Str::slug($sentence),
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
