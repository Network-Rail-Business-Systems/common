<?php

namespace NetworkRailBusinessSystems\Common\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use NetworkRailBusinessSystems\Common\Models\User;

class UserFactory extends Factory
{
    public function __construct(
        $count = null,
        ?Collection $states = null,
        ?Collection $has = null,
        ?Collection $for = null,
        ?Collection $afterMaking = null,
        ?Collection $afterCreating = null,
        $connection = null,
        ?Collection $recycle = null,
        ?bool $expandRelationships = null,
        array $excludeRelationships = [],
    ) {
        $this->model = config('common.models.user');

        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle, $expandRelationships, $excludeRelationships);
    }

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

    public function softDeleted(): static
    {
        return $this->state([
            'deleted_at' => $this->faker->date,
        ]);
    }

    public function withEmail(string $email): static
    {
        return $this->state([
            'email' => $email,
        ]);
    }

    public function withFirstName(string $name): static
    {
        return $this->state([
            'first_name' => $name,
        ]);
    }

    public function withRole(RoleInterface|string $role): static
    {
        return $this->afterCreating(function ($user) use ($role) {
            /** @var User $user */
            $user->assignRole($role);
        });
    }
}
