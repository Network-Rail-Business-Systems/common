<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Policies\User;

use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ImpersonateTest extends TestCase
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

    public function testDeniesWithoutPermission(): void
    {
        $this->assertPolicyDenies(
            $this->policy->impersonate(
                $this->auth,
                $this->user,
            ),
            'You cannot impersonate Users',
        );
    }

    public function testAllowsWithPermission(): void
    {
        $this->user->assignRole(Role::Admin);

        $this->assertPolicyAllows(
            $this->policy->impersonate(
                $this->auth,
                $this->user,
            ),
            'You can impersonate Users',
        );
    }
}
