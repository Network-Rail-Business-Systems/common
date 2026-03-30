<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\Impersonation;

use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class CanBeImpersonatedTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->user = $this->signIn();
    }

    public function testTrueWhen(): void
    {
        $this->assertTrue(
            $this->user->canBeImpersonated(),
        );
    }

    public function testFalseWhen(): void
    {
        $this->user->assignRole(Role::Admin);

        $this->assertFalse(
            $this->user->canBeImpersonated(),
        );
    }
}
