<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use Illuminate\Http\RedirectResponse;
use NetworkRailBusinessSystems\ActivityLog\ActivityHelper;
use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use NetworkRailBusinessSystems\Common\Models\User;

class UserRoleController extends Controller
{
    public function assign(User $user, RoleInterface $role): RedirectResponse
    {
        $this->authorize('assignRole', [$user, $role]);

        $user->assignRole($role);
        ActivityHelper::logRoleChange($user, $role->value, 'assigned');
        flash()->success("The \"$role->value\" Role has been successfully assigned.");

        return redirect()->route('admin.users.show', $user);
    }

    public function remove(User $user, RoleInterface $role): RedirectResponse
    {
        $this->authorize('removeRole', [$user, $role]);

        $user->removeRole($role);
        ActivityHelper::logRoleChange($user, $role->value, 'removed');
        flash()->success("The \"$role->value\" Role has been successfully removed.");

        return redirect()->route('admin.users.show', $user);
    }
}
