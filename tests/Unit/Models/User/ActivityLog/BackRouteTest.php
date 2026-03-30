<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\ActivityLog;

use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class BackRouteTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $this->user = User::factory()->create();
    }

    public function testBackRoute(): void
    {
        $this->assertEquals(
            route('admin.users.show', $this->user),
            $this->user->backRoute(),
        );
    }
}
