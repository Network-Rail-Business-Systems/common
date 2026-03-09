<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Enums\Role;

use NetworkRailBusinessSystems\Common\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AssignmentsTest extends TestCase
{
    #[DataProvider('expectations')]
    public function test(Role $role, array $expected): void
    {
        $this->assertEquals(
            $expected,
            $role->assignments(),
        );
    }

    public static function expectations(): array
    {
        $expectations = [];
        $roles = Role::cases();

        foreach ($roles as $role) {
            $expectations[] = [
                'role' => $role,
                'expected' => $role->assignments(),
            ];
        }

        return $expectations;
    }
}
