<?php

namespace NetworkRailBusinessSystems\Common\Tests\Enums;

use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use NetworkRailBusinessSystems\Common\Traits\RoleTrait;

enum Role: string implements RoleInterface
{
    use RoleTrait;

    case Admin = 'Admin';

    case Other = 'Other';

    case User = 'User';

    public function allowedImpersonations(): array
    {
        return match ($this) {
            Role::Admin => [
                Role::Other,
                Role::User,
            ],
            Role::Other => [
                Role::User,
            ],
            default => [],
        };
    }

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
                Role::User,
            ],
            default => [],
        };
    }

    public function permissions(): array
    {
        return match ($this) {
            Role::Admin => [
                Permission::AccessAdmin,
                Permission::Impersonate,
                Permission::ManageUsers,
            ],
            default => [],
        };
    }
}
