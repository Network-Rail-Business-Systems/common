<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\Setup;

use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class BootedTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        User::factory()
            ->count(3)
            ->create();
    }

    public function testOrdersByName(): void
    {
        $this->assertAscending(
            User::query()->get(),
            'name',
        );
    }
}
