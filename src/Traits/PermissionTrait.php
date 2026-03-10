<?php

namespace NetworkRailBusinessSystems\Common\Traits;

use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;

trait PermissionTrait
{
    public function roles(): array
    {
        /** @var class-string<RoleInterface> $rolesEnum */
        $rolesEnum = config('common.enums.roles');
        $cases = $rolesEnum::cases();
        $roles = [];

        foreach ($cases as $role) {
            if (in_array($this, $role->permissions()) === true) {
                $roles[] = $role;
            }
        }

        return $roles;
    }

    public static function values(): array
    {
        $values = [];
        $permissions = static::cases();

        foreach ($permissions as $permission) {
            $values[] = $permission->value;
        }

        return $values;
    }
}
