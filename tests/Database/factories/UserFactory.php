<?php

namespace NetworkRailBusinessSystems\Common\Tests\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NetworkRailBusinessSystems\Common\Tests\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'name' => $this->faker->name(),
        ];
    }
}
