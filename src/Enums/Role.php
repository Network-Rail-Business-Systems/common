<?php

namespace NetworkRailBusinessSystems\Common\Enums;

enum Role: string
{
     case Admin = 'Admin';

     case User = 'User';

     public function assignments(): array
     {
         return match ($this) {
             Role::Admin => [
                 Permission::Impersonate,
                 Permission::ManageUsers,
             ],
             default => [],
         };
     }

    public static function values(): array
    {
        $values = [];
        $roles = Role::cases();

        foreach ($roles as $permission) {
            $values[] = $permission->value;
        }

        return $values;
    }
}
