<?php

namespace NetworkRailBusinessSystems\Common\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use NetworkRailBusinessSystems\Common\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    // Management
    public function manage(User $auth, User $user): Response
    {
        return $auth->hasPermissionTo($user::managePermission()) === true
            ? $this->allow('You can manage Users')
            : $this->deny('You cannot manage Users');
    }

    // Roles
    public function assignRole(User $auth, User $user, RoleInterface $desiredRole): Response
    {
        foreach ($user->roles as $roleModel) {
            $existingRole = $desiredRole::from($roleModel->name);

            if ($desiredRole->conflictsWith($existingRole) === true) {
                return $this->deny("You cannot have both the \"$desiredRole->value\" and \"$existingRole->value\" Roles");
            }
        }

        foreach ($auth->roles as $roleModel) {
            $grantingRole = $desiredRole::from($roleModel->name);

            if ($grantingRole->canGrant($desiredRole) === true) {
                return $this->allow("You can assign the \"$desiredRole->value\" Role");
            }
        }

        return $this->deny("You cannot assign the \"$desiredRole->value\" Role");
    }

    public function removeRole(User $auth, User $user, RoleInterface $role): Response
    {
        foreach ($auth->roles as $roleModel) {
            $revokingRole = $role::from($roleModel->name);

            if ($revokingRole->canGrant($role) === true) {
                return $this->allow("You can remove the \"$role->value\" Role");
            }
        }

        return $this->deny("You cannot remove the \"$role->value\" Role");
    }

    // Impersonation
    public function beImpersonated(User $auth, User $user): Response
    {
        return $user->hasPermissionTo($user::impersonatePermission()) === false
            ? $this->allow('You can impersonate this User')
            : $this->deny('You cannot impersonate this User');
    }

    public function impersonate(User $auth, User $user): Response
    {
        return $user->hasPermissionTo($user::impersonatePermission()) === true
            ? $this->allow('You can impersonate Users')
            : $this->deny('You cannot impersonate Users');
    }
}
