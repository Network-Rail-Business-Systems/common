<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use Illuminate\Http\RedirectResponse;
use NetworkRailBusinessSystems\ActivityLog\ActivityHelper;
use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use NetworkRailBusinessSystems\Common\Models\User;

class UserRoleController extends Controller
{
    public function __construct()
    {
        app()->bind(User::class, config('common.models.user'));
    }

    public function assign(User $user, string $name): RedirectResponse
    {
        $role = $this->getRole($name);
        $this->authorize('assignRole', [$user, $role]);

        $user->assignRole($role);
        ActivityHelper::logRoleChange($user, $role->value, 'assigned');
        flash()->success("The \"$role->value\" Role has been successfully assigned.");

        return redirect()->route('admin.users.show', $user);
    }

    public function remove(User $user, string $name): RedirectResponse
    {
        $role = $this->getRole($name);
        $this->authorize('removeRole', [$user, $role]);

        $user->removeRole($role);
        ActivityHelper::logRoleChange($user, $role->value, 'removed');
        flash()->success("The \"$role->value\" Role has been successfully removed.");

        return redirect()->route('admin.users.show', $user);
    }

    protected function getRole(string $name): RoleInterface
    {
        /** @var RoleInterface $roleClass */
        $roleClass = config('common.enums.roles');
        return $roleClass::from($name);
    }
}
