<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\Role;

use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class CanImpersonateTest extends TestCase
{
    public function testTrueWhen(): void
    {
        $this->assertTrue(
            Role::Admin->canImpersonate(Role::User),
        );
    }

    public function testFalseWhen(): void
    {
        $this->assertFalse(
            Role::Admin->canImpersonate(Role::Admin),
        );
    }
}
