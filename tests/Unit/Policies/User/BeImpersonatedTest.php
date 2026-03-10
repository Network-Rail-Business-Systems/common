<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Policies\User;

use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class BeImpersonatedTest extends TestCase
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

    public function testDeniesWhenCanImpersonate(): void
    {
        $this->auth->assignRole(Role::Admin);
        $this->user->assignRole(Role::Admin);

        $this->assertPolicyDenies(
            $this->policy->beImpersonated(
                $this->auth,
                $this->user,
            ),
            'You cannot impersonate this User',
        );
    }

    public function testAllowsWhenCannot(): void
    {
        $this->auth->assignRole(Role::Admin);

        $this->assertPolicyAllows(
            $this->policy->beImpersonated(
                $this->auth,
                $this->user,
            ),
            'You can impersonate this User',
        );
    }
}
