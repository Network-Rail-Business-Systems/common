<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Builders\Users;

use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ByRoleTest extends TestCase
{
    protected Collection $expected;

    protected Collection $unexpected;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->expected = User::factory()
            ->count(3)
            ->withRole(Role::Admin)
            ->create();

        $this->unexpected = User::factory()
            ->count(3)
            ->create();
    }

    public function test(): void
    {
        $this->assertResultsMatch(
            User::query()
                ->byRole(Role::Admin)
                ->get(),
            $this->expected,
            $this->unexpected,
        );
    }
}
