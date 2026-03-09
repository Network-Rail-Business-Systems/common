<?php

namespace NetworkRailBusinessSystems\Common\Enums;

enum Permission: string
{
    case Impersonate = 'impersonate';

    case ManageUsers = 'manage_users';

    public function assignments(): array
    {
        $roles = Role::cases();

        foreach ($roles as $role) {
            if (in_array($this, $role->assignments()) === true) {
                $roles[] = $role;
            }
        }

        return $roles;
    }

    public static function values(): array
    {
        $values = [];
        $permissions = Permission::cases();

        foreach ($permissions as $permission) {
            $values[] = $permission->value;
        }

        return $values;
    }
}
