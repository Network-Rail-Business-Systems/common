<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\User;

use AnthonyEdmonds\LaravelFind\FinderOutput;
use Illuminate\Contracts\View\View;
use NetworkRailBusinessSystems\Common\Controllers\UserController;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class IndexTest extends TestCase
{
    protected UserController $controller;

    protected View $view;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->signInWithRole(Role::Admin->value);

        $this->controller = new UserController();
        $this->view = $this->controller->index();
    }

    public function test(): void
    {
        $this->assertViewRenders($this->view);

        $this->assertEquals(
            'common::admin.users.index',
            $this->view->name(),
        );

        $data = $this->view->getData();

        $this->assertEquals(
            [
                'Admin' => route('admin.index'),
                'Users' => route('admin.users.index'),
            ],
            $data['breadcrumbs'],
        );

        $this->assertEquals(
            'Manage Users',
            $data['title'],
        );

        $this->assertInstanceOf(
            FinderOutput::class,
            $data['finder'],
        );
    }
}
