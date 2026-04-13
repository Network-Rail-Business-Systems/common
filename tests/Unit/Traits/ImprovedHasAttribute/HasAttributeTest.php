<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\ImprovedHasAttribute;

use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class HasAttributeTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    public function testFalseWhenFalsy(): void
    {
        $this->assertFalse(
            $this->user->hasAttribute(''),
        );
    }

    public function testTrueWhenFillable(): void
    {
        $this->assertTrue(
            $this->user->hasAttribute('email'),
        );
    }

    public function testTrueWhenGuarded(): void
    {
        $this->assertTrue(
            $this->user->hasAttribute('azure_id'),
        );
    }

    public function testResolvesParent(): void
    {
        $this->assertFalse(
            $this->user->hasAttribute('potato'),
        );
    }
}
