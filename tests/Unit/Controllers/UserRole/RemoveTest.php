<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\UserRole;

use Illuminate\Http\RedirectResponse;
use NetworkRailBusinessSystems\Common\Controllers\UserRoleController;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class RemoveTest extends TestCase
{
    protected UserRoleController $controller;

    protected RedirectResponse $redirect;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->user = User::factory()->create();
        $this->user->assignRole(Role::Admin);
        $this->signInWithRole(Role::Admin->value);

        $this->controller = new UserRoleController();
        $this->redirect = $this->controller->remove($this->user, Role::Admin);
    }

    public function test(): void
    {
        $this->assertFalse(
            $this->user->hasRole(Role::Admin),
        );

        $this->assertActivity(
            $this->user,
            'role',
            Role::Admin->value . ' Role removed',
        );

        $this->assertFlashed(
            'The "' . Role::Admin->value . '" Role has been successfully removed.',
            'success',
        );

        $this->assertEquals(
            route('admin.users.show', $this->user),
            $this->redirect->getTargetUrl(),
        );
    }
}
