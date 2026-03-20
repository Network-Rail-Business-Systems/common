<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\Admin;

use Illuminate\Contracts\View\View;
use NetworkRailBusinessSystems\Common\Controllers\AdminController;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class IndexTest extends TestCase
{
    protected AdminController $controller;

    protected View $view;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->signInWithRole(Role::Admin->value);

        $this->controller = new AdminController();
        $this->view = $this->controller->index();
    }

    public function test(): void
    {
        $this->assertViewRenders($this->view);

        $this->assertEquals(
            'common::admin.index',
            $this->view->name(),
        );

        $data = $this->view->getData();

        $this->assertEquals(
            [
                'Admin' => route('admin.index'),
            ],
            $data['breadcrumbs'],
        );

        $this->assertEquals(
            'Admin',
            $data['title'],
        );
    }
}
