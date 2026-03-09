<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\Permission;

use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class PermissionTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            [
                Permission::Impersonate->value,
                Permission::ManageUsers->value,
            ],
            Permission::values(),
        );
    }
}
