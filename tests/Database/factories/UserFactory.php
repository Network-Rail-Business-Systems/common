<?php

namespace NetworkRailBusinessSystems\Common\Tests\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use NetworkRailBusinessSystems\Common\Tests\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'azure_id' => $this->faker->unique()->uuid(),
            'email' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'name' => $this->faker->name(),
        ];
    }

    public function withRole(RoleInterface|string $role): self
    {
        return $this->afterCreating(function (User $user) use ($role) {
            $user->assignRole($role);
        });
    }
}
