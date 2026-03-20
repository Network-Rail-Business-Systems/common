<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\Setup;

use NetworkRailBusinessSystems\Common\Builders\UsersBuilder;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class NewEloquentBuilderTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    public function testOrdersByName(): void
    {
        $this->assertInstanceOf(
            UsersBuilder::class,
            $this->user->newEloquentBuilder(
                User::query()->toBase(),
            ),
        );
    }
}
