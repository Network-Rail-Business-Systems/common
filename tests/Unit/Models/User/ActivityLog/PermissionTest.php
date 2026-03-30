<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\ActivityLog;

use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class PermissionTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    public function testPermission(): void
    {
        $this->assertEquals(
            Permission::ManageUsers->value,
            $this->user->permission(),
        );
    }
}
