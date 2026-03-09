<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Builders\Users;

use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ByNameTest extends TestCase
{
    protected Collection $expected;

    protected Collection $unexpected;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $this->expected = User::factory()
            ->count(3)
            ->sequence(
                ['name' => 'anthony'],
                ['first_name' => 'ants'],
                ['last_name' => 'antique'],
            )
            ->create();

        $this->unexpected = User::factory()
            ->count(3)
            ->create();
    }

    public function test(): void
    {
        $this->assertResultsMatch(
            User::query()
                ->byName('ant')
                ->get(),
            $this->expected,
            $this->unexpected,
        );
    }
}
