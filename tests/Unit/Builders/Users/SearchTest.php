<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Builders\Users;

use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Tests\Enums\RoleInterface;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SearchTest extends TestCase
{
    protected Collection $expected;

    protected Collection $unexpected;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->unexpected = User::factory()
            ->count(3)
            ->create();
    }

    public function test(): void
    {
        $this->expected = new Collection([
            User::factory()
                ->withRole(RoleInterface::Admin)
                ->create(),
            User::factory()->create([
                'first_name' => 'Admonish',
            ]),
            User::factory()->create([
                'last_name' => 'Admantium',
            ]),
            User::factory()->create([
                'email' => 'Adm@example.com',
            ]),
        ]);

        $this->assertResultsMatch(
            User::query()
                ->search('Adm')
                ->get(),
            $this->expected,
            $this->unexpected,
        );
    }

    public function testById(): void
    {
        $this->expected = User::factory()
            ->count(1)
            ->create();

        $this->assertResultsMatch(
            User::query()
                ->search('4')
                ->get(),
            $this->expected,
            $this->unexpected,
        );
    }

    public function testEmpty(): void
    {
        $this->expected = User::factory()
            ->count(3)
            ->withRole('Admin')
            ->create();

        $this->assertResultsMatch(
            User::query()
                ->search('')
                ->get(),
            $this->expected->merge($this->unexpected),
            new Collection(),
        );
    }
}
