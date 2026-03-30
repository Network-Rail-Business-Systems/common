<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\Impersonation;

use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class CanImpersonateTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->user = $this->signIn();
    }

    public function testTrueWhenAdmin(): void
    {
        $this->user->assignRole(Role::Admin);

        $this->assertTrue(
            $this->user->canImpersonate(),
        );
    }

    public function testFalseWhenNotAdmin(): void
    {
        $this->assertFalse(
            $this->user->canImpersonate(),
        );
    }
}
