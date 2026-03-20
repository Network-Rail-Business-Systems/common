<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\Permission;

use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class RolesTest extends TestCase
{
    #[DataProvider('expectations')]
    public function test(Permission $permission, array $expected): void
    {
        $this->assertEquals(
            $expected,
            $permission->roles(),
        );
    }

    public static function expectations(): array
    {
        return [
            [
                'permission' => Permission::ManageUsers,
                'expected' => [
                    Role::Admin,
                ],
            ],
            [
                'permission' => Permission::Impersonate,
                'expected' => [
                    Role::Admin,
                ],
            ],
        ];
    }
}
