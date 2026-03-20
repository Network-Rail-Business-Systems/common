<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Builders\Users;

use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Finders\UserFinder;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ByFilterTest extends TestCase
{
    protected Collection $expected;

    protected Collection $unexpected;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();
    }

    public function testAll(): void
    {
        $this->expected = User::factory()
            ->count(3)
            ->create();

        $this->unexpected = new Collection();

        $this->assertResultsMatch(
            User::query()
                ->byFilter(
                    UserFinder::FILTER_ALL,
                )
                ->get(),
            $this->expected,
            $this->unexpected,
        );
    }

    public function testRoles(): void
    {
        $this->expected = User::factory()
            ->count(3)
            ->withRole(Role::Admin)
            ->create();

        $this->unexpected = User::factory()
            ->count(3)
            ->create();

        $this->assertResultsMatch(
            User::query()
                ->byFilter(UserFinder::FILTER_ROLES)
                ->get(),
            $this->expected,
            $this->unexpected,
        );
    }
}
