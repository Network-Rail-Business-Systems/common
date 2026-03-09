<?php

namespace NetworkRailBusinessSystems\Common\Tests\Enums;

use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use NetworkRailBusinessSystems\Common\Traits\RoleTrait;

enum Role: string implements RoleInterface
{
    use RoleTrait;

    case Admin = 'Admin';

    case User = 'User';

    public function conflicts(): array
    {
        return match ($this) {
            Role::Admin => [
                Role::User,
            ],
            default => [],
        };
    }

    public function grants(): array
    {
        return match ($this) {
            Role::Admin => [
                Role::Admin,
            ],
            default => [],
        };
    }

    public function permissions(): array
    {
        return match ($this) {
            Role::Admin => [
                Permission::Impersonate,
                Permission::ManageUsers,
            ],
            default => [],
        };
    }
}
