<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Enums\Permission;

use NetworkRailBusinessSystems\Common\Enums\Permission;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AssignmentsTest extends TestCase
{
    #[DataProvider('expectations')]
    public function test(Permission $permission, array $expected): void
    {
        $this->assertEquals(
            $expected,
            $permission->assignments(),
        );
    }

    public static function expectations(): array
    {
        $expectations = [];
        $permissions = Permission::cases();

        foreach ($permissions as $permission) {
            $expectations[] = [
                'permission' => $permission,
                'expected' => $permission->assignments(),
            ];
        }

        return $expectations;
    }
}
