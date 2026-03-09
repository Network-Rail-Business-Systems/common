<?php

namespace NetworkRailBusinessSystems\Common\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;

class UserPolicy
{
    use HandlesAuthorization;

    public function manage(User $auth, User $user): Response
    {
        return $auth->can('manage_users') === true
            ? $this->allow('You can manage Users')
            : $this->deny('You cannot manage Users');
    }

    public function grant(User $auth, User $user, Role $desiredRole): Response
    {
        foreach ($auth->roles as $roleModel) {
            $grantingRole = Role::from($roleModel->name);

            if (
                $grantingRole->canGrant($desiredRole) === true
                && $grantingRole->conflictsWith($desiredRole) === false
            ) {
                return $this->allow("You can grant the $desiredRole->value Role");
            }
        }

        return $this->deny("You cannot grant the $desiredRole->value Role");
    }
}
