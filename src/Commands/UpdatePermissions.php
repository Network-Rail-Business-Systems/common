<?php

namespace NetworkRailBusinessSystems\Common\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use NetworkRailBusinessSystems\Common\Interfaces\PermissionInterface;
use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role as RoleModel;

class UpdatePermissions extends Command
{
    protected $signature = 'update:permissions';

    protected $description = 'Updates Roles and Permissions based on the defined enums';

    /** @var Collection<PermissionModel> */
    protected Collection $existingPermissions;

    /** @var Collection<RoleModel> */
    protected Collection $existingRoles;

    /** @var class-string<PermissionModel> */
    protected string $permissionModel;

    /** @var class-string<PermissionInterface> */
    protected string $permissionsEnum;

    /** @var class-string<RoleModel> */
    protected string $roleModel;

    /** @var class-string<RoleInterface> */
    protected string $rolesEnum;

    public function handle(): void
    {
        $this->info('This command will update the Roles and Permissions in this system to match the defined enums.');
        $this->confirm('Continue?');

        $this->setup();

        $this->loadExisting();
        $this->removeRoles();
        $this->removePermissions();
        $this->addRoles();
        $this->addPermissions();

        $this->loadExisting();
        $this->removeRolePermissions();
        $this->addRolePermissions();
        $this->resetCache();

        $this->info('Complete!');
    }

    protected function addPermissions(): void
    {
        $this->info('Adding new Permissions...');

        $permissions = $this->permissionsEnum::values();
        $toInsert = [];

        foreach ($permissions as $permission) {
            if ($this->existingPermissions->has($permission) === false) {
                $toInsert[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                ];
            }
        }

        $this->permissionModel::query()
            ->insert($toInsert);
    }

    protected function addRoles(): void
    {
        $this->info('Adding new Roles...');

        $roles = $this->rolesEnum::values();
        $toInsert = [];

        foreach ($roles as $role) {
            if ($this->existingRoles->has($role) === false) {
                $toInsert[] = [
                    'name' => $role,
                    'guard_name' => 'web',
                ];
            }
        }

        RoleModel::query()->insert($toInsert);
    }

    protected function addRolePermissions(): void
    {
        $this->info('Assigning permissions to roles...');

        $roles = $this->rolesEnum::cases();
        $toInsert = [];

        foreach ($roles as $role) {
            $assignments = $role->permissions();

            foreach ($assignments as $permission) {
                $toInsert[] = [
                    'permission_id' => $this->existingPermissions->get($permission->value),
                    'role_id' => $this->existingRoles->get($role->value),
                ];
            }
        }

        DB::table('role_has_permissions')
            ->insert($toInsert);
    }

    protected function loadExisting(): void
    {
        $this->info('Loading existing Roles and Permissions...');

        $this->existingRoles = RoleModel::query()->pluck('id', 'name');
        $this->existingPermissions = PermissionModel::query()->pluck('id', 'name');
    }

    protected function removePermissions(): void
    {
        $this->info('Removing old Permissions...');

        $permissions = $this->permissionsEnum::values();
        $toRemove = $this->existingPermissions
            ->flip()
            ->diff($permissions)
            ->keys();

        PermissionModel::query()
            ->whereIn('id', $toRemove)
            ->delete();
    }

    protected function removeRolePermissions(): void
    {
        $this->info('Wiping existing Permissions granted to Roles...');

        DB::table('role_has_permissions')
            ->delete();
    }

    protected function removeRoles(): void
    {
        $this->info('Removing old Roles...');

        $roles = $this->rolesEnum::values();
        $toRemove = $this->existingRoles
            ->flip()
            ->diff($roles)
            ->keys();

        RoleModel::query()
            ->whereIn('id', $toRemove)
            ->delete();
    }

    protected function resetCache(): void
    {
        $this->info('Resetting Spatie-Permissions cache...');

        $this->call('permission:cache-reset');
    }

    protected function setup(): void
    {
        $this->info('Setting up enums and models...');

        $this->permissionModel = config('common.models.permission');
        $this->permissionsEnum = config('common.enums.permissions');

        $this->roleModel = config('common.models.role');
        $this->rolesEnum = config('common.enums.roles');
    }
}
