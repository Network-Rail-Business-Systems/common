<?php

namespace NetworkRailBusinessSystems\Common\Traits;

use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;

trait RoleTrait
{
    abstract public function conflicts(): array;

    abstract public function grants(): array;

    abstract public function permissions(): array;

    public function canGrant(RoleInterface $role): bool
    {
        return in_array(
            $role,
            $this->grants(),
        ) === true;
    }

    public function conflictsWith(RoleInterface $role): bool
    {
        return in_array(
            $role,
            $this->conflicts(),
        ) === true;
    }

    public static function values(): array
    {
        $values = [];
        $roles = static::cases();

        foreach ($roles as $role) {
            $values[] = $role->value;
        }

        return $values;
    }
}
