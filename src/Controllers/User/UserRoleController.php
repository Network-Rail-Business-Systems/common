<?php

namespace App\Http\Controllers\User;

use App\Helpers\ActivityHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function grant(User $user, Role $role): RedirectResponse
    {
        $this->authorize('grant', [$user, $role]);

        $user->assignRole($role);
        ActivityHelper::logRoleChange($user, $role->name, 'granted');
        flash("The $role->name Role has been successfully granted.")->success();

        return redirect()->route('admin.users.show', $user);
    }

    public function revoke(User $user, Role $role): RedirectResponse
    {
        $this->authorize('grant', [$user, $role]);

        $user->removeRole($role);
        ActivityHelper::logRoleChange($user, $role->name, 'revoked');
        flash("The $role->name Role has been successfully revoked.")->success();

        return redirect()->route('admin.users.show', $user);
    }
}
