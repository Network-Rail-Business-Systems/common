<?php

namespace NetworkRailBusinessSystems\Common\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use NetworkRailBusinessSystems\Common\Models\User;
use Spatie\Permission\Models\Role;

class UserPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, User $account): Response
    {
        return $user->can('manage_users') === true
            ? $this->allow('You can manage Users')
            : $this->deny('You cannot manage Users');
    }

    public function grant(User $user, User $account, Role $role): Response
    {
        return $user->can('grant', $role) === true
            ? $this->allow("You can grant the $role->name Role")
            : $this->deny("You cannot grant the $role->name Role");
    }
}
