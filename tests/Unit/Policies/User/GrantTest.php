<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Policies\User;

use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use NetworkRailBusinessSystems\Common\Tests\Enums\RoleInterface;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class GrantTest extends TestCase
{
    protected RoleInterface $role;

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
            $this->policy->grant(
                $this->signInWithRole(RoleInterface::Admin->value),
                new User(),
                RoleInterface::Admin,
            ),
            'You can grant the Admin Role',
        );
    }

    public function testDeniesWithout(): void
    {
        $this->assertPolicyDenies(
            $this->policy->grant(
                $this->signIn(),
                new User(),
                RoleInterface::Admin,
            ),
            'You cannot grant the Admin Role',
        );
    }
}
