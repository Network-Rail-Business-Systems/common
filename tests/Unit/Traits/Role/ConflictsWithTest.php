<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\Role;

use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ConflictsWithTest extends TestCase
{
    public function testTrueWhenRoleConflictsWithTarget(): void
    {
        $this->assertTrue(
            Role::Admin->conflictsWith(Role::User),
        );
    }

    public function testTrueWhenTargetConflictsWithRole(): void
    {
        $this->assertTrue(
            Role::User->conflictsWith(Role::Admin),
        );
    }

    public function testFalseWhen(): void
    {
        $this->assertFalse(
            Role::User->conflictsWith(Role::Other),
        );
    }
}
