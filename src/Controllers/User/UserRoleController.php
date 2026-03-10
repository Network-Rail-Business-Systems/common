<?php

namespace NetworkRailBusinessSystems\Common\Controllers\User;

use Illuminate\Http\RedirectResponse;
use NetworkRailBusinessSystems\ActivityLog\ActivityHelper;
use NetworkRailBusinessSystems\Common\Controllers\Controller;
use NetworkRailBusinessSystems\Common\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function grant(User $user, Role $role): RedirectResponse
    {
        $this->authorize('assignRole', [$user, $role]);

        $user->assignRole($role);
        ActivityHelper::logRoleChange($user, $role->name, 'granted');
        flash()->success("The $role->name Role has been successfully granted.");

        return redirect()->route('admin.users.show', $user);
    }

    public function revoke(User $user, Role $role): RedirectResponse
    {
        $this->authorize('revokeRole', [$user, $role]);

        $user->removeRole($role);
        ActivityHelper::logRoleChange($user, $role->name, 'revoked');
        flash()->success("The $role->name Role has been successfully revoked.");

        return redirect()->route('admin.users.show', $user);
    }
}
