<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Builders\Users;

use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Tests\Enums\RoleInterface;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class HasRolesTest extends TestCase
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
            ->withRole(RoleInterface::Admin)
            ->create();

        $this->unexpected = User::factory()
            ->count(3)
            ->create();
    }

    public function test(): void
    {
        $this->assertResultsMatch(
            User::query()
                ->hasRoles()
                ->get(),
            $this->expected,
            $this->unexpected,
        );
    }
}
