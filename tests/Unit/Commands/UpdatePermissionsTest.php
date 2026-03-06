<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Commands;

use Illuminate\Support\Facades\DB;
use NetworkRailBusinessSystems\Common\Enums\Permission as PermissionEnum;
use NetworkRailBusinessSystems\Common\Enums\Role as RoleEnum;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role as RoleModel;

class UpdatePermissionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        RoleModel::create([
            'name' => RoleEnum::Admin,
        ]);

        RoleModel::create([
            'name' => 'Old Role'
        ]);

        PermissionModel::create([
            'name' => PermissionEnum::Impersonate,
        ]);

        PermissionModel::create([
            'name' => 'Old Permission',
        ]);

        DB::table('role_has_permissions')->insert([
            'permission_id' => 2,
            'role_id' => 2,
        ]);
    }

    public function test(): void
    {
        /** Command */
        $this->artisan('update:permissions')
            ->expectsOutput('This command will update the Roles and Permissions in this system to match the defined enums.')
            ->expectsConfirmation('Continue?', 'yes')
            ->expectsOutput('Setting up enums and models...')
            ->expectsOutput('Loading existing Roles and Permissions...')
            ->expectsOutput('Removing old Roles...')
            ->expectsOutput('Removing old Permissions...')
            ->expectsOutput('Adding new Roles...')
            ->expectsOutput('Adding new Permissions...')
            ->expectsOutput('Loading existing Roles and Permissions...')
            ->expectsOutput('Wiping existing Permissions granted to Roles...')
            ->expectsOutput('Resetting Spatie-Permissions cache...')
            ->expectsOutput('Complete!');

        /** Roles */
        $this->assertDatabaseHas('roles', [
            'name' => RoleEnum::Admin,
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => RoleEnum::User,
        ]);

        $this->assertDatabaseMissing('roles', [
            'name' => 'Old Role',
        ]);

        /** Permissions */
        $this->assertDatabaseHas('permissions', [
            'name' => PermissionEnum::Impersonate,
        ]);

        $this->assertDatabaseHas('permissions', [
            'name' => PermissionEnum::ManageUsers,
        ]);

        $this->assertDatabaseMissing('permissions', [
            'name' => 'Old Permission',
        ]);

        /** Role Permissions */
        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => 1,
            'role_id' => 1,
        ]);

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => 3,
            'role_id' => 1,
        ]);

        $this->assertDatabaseMissing('role_has_permissions', [
            'permission_id' => 2,
            'role_id' => 2,
        ]);
    }
}
