<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\User;

use Illuminate\Contracts\View\View;
use NetworkRailBusinessSystems\Common\Controllers\UserController;
use NetworkRailBusinessSystems\Common\ResourceCollections\UserRoleCollection;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ShowTest extends TestCase
{
    protected UserController $controller;

    protected User $user;

    protected View $view;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->signInWithRole(Role::Admin->value);

        $this->user = User::factory()->create();

        $this->controller = new UserController();
        $this->view = $this->controller->show($this->user);
    }

    public function test(): void
    {
        $this->assertViewRenders($this->view);

        $this->assertEquals(
            'common::admin.users.show',
            $this->view->name(),
        );

        $data = $this->view->getData();

        $this->assertEquals(
            [
                'Admin' => route('admin.index'),
                'Users' => route('admin.users.index'),
                $this->user->name => route('admin.users.show', $this->user),
            ],
            $data['breadcrumbs'],
        );

        $this->assertInstanceOf(
            UserRoleCollection::class,
            $data['roles'],
        );

        $this->assertEquals(
            "Manage {$this->user->name}",
            $data['title'],
        );

        $this->assertTrue(
            $this->user->is($data['user']),
        );
    }
}
