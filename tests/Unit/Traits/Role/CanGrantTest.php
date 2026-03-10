<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\Role;

use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class CanGrantTest extends TestCase
{
    public function testTrueWhen(): void
    {
        $this->assertTrue(
            Role::Admin->canGrant(Role::User),
        );
    }

    public function testFalseWhen(): void
    {
        $this->assertFalse(
            Role::User->canGrant(Role::Admin),
        );
    }
}
