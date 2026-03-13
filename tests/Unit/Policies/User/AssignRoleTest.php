<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Policies\User;

use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class AssignRoleTest extends TestCase
{
    protected User $auth;

    protected Role $role;

    protected UserPolicy $policy;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->policy = new UserPolicy();
        $this->auth = User::factory()->create();
        $this->user = User::factory()->create();
    }

    public function testDeniesWhenConflicted(): void
    {
        $this->auth->assignRole(Role::Admin);
        $this->user->assignRole(Role::User);

        $this->assertPolicyDenies(
            $this->policy->assignRole(
                $this->auth,
                $this->user,
                Role::Admin,
            ),
            'You cannot have both the "' . Role::Admin->value . '" and "' . Role::User->value . '" Roles',
        );
    }

    public function testAllowsWithPermission(): void
    {
        $this->auth->assignRole(Role::Admin);

        $this->assertPolicyAllows(
            $this->policy->assignRole(
                $this->auth,
                $this->user,
                Role::Admin,
            ),
            'You can assign the "Admin" Role',
        );
    }

    public function testDeniesWhenCannotGrant(): void
    {
        $this->assertPolicyDenies(
            $this->policy->assignRole(
                $this->auth,
                $this->user,
                Role::Admin,
            ),
            'You cannot assign the "Admin" Role',
        );
    }
}
