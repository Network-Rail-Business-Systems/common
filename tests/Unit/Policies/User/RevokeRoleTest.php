<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Policies\User;

use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class RevokeRoleTest extends TestCase
{
    protected Role $role;

    protected UserPolicy $policy;

    protected User $auth;

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

    public function testAllowsWithPermission(): void
    {
        $this->auth->assignRole(Role::Admin);

        $this->assertPolicyAllows(
            $this->policy->revokeRole(
                $this->auth,
                $this->user,
                Role::Admin,
            ),
            'You can revoke the "' . Role::Admin->value . '" Role',
        );
    }

    public function testDeniesWithout(): void
    {
        $this->assertPolicyDenies(
            $this->policy->revokeRole(
                $this->auth,
                $this->user,
                Role::Admin,
            ),
            'You cannot revoke the "' . Role::Admin->value . '" Role',
        );
    }
}
