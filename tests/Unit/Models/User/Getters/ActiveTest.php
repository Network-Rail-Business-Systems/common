<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\Getters;

use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ActiveTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $this->user = User::factory()->create();
    }

    public function testTrueWhen(): void
    {
        $this->assertTrue(
            $this->user->active,
        );
    }

    public function testFalseWhen(): void
    {
        $this->user->delete();

        $this->assertFalse(
            $this->user->active,
        );
    }
}
