<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\Setup;

use NetworkRailBusinessSystems\Common\Builders\UsersBuilder;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class QueryTest extends TestCase
{
    public function testOrdersByName(): void
    {
        $this->assertInstanceOf(
            UsersBuilder::class,
            User::query(),
        );
    }
}
