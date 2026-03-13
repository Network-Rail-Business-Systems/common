<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\User;

use Illuminate\Contracts\View\View;
use NetworkRailBusinessSystems\Common\Controllers\UserController;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class CreateTest extends TestCase
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
        $this->view = $this->controller->create();
    }

    public function test(): void
    {
        $this->assertViewRenders($this->view);

        $this->assertEquals(
            'common::admin.users.create',
            $this->view->name(),
        );

        $data = $this->view->getData();

        $this->assertEquals(
            route('admin.users.create'),
            $data['action'],
        );

        $this->assertEquals(
            route('admin.users.index'),
            $data['back'],
        );

        $this->assertField(
            [
                'hint' => 'Enter their complete e-mail address including the domain',
                'label' => 'What is their e-mail address?',
                'name' => 'email',
                'width' => 20,
            ],
            $data['fields'][0],
        );

        $this->assertEquals(
            'Import User',
            $data['title'],
        );
    }
}
