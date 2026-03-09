<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Policies\User;

use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ManageTest extends TestCase
{
    protected UserPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->policy = new UserPolicy();
    }

    public function testAllowsWithPermission(): void
    {
        $this->assertPolicyAllows(
            $this->policy->manage(
                $this->signInWithPermission(
                    Permission::ManageUsers->value,
                ),
                new User(),
            ),
            'You can manage Users',
        );
    }

    public function testDeniesWithout(): void
    {
        $this->assertPolicyDenies(
            $this->policy->manage(
                $this->signIn(),
                new User(),
            ),
            'You cannot manage Users',
        );
    }
}
