<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Policies\User;

use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ManageTest extends TestCase
{
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
            $this->policy->manage(
                $this->auth,
                $this->user,
            ),
            'You can manage Users',
        );
    }

    public function testDeniesWithout(): void
    {
        $this->assertPolicyDenies(
            $this->policy->manage(
                $this->auth,
                $this->user,
            ),
            'You cannot manage Users',
        );
    }
}
