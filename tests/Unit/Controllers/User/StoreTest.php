<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\User;

use Illuminate\Http\RedirectResponse;
use NetworkRailBusinessSystems\Common\Controllers\UserController;
use NetworkRailBusinessSystems\Common\FormRequests\ImportUserRequest;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class StoreTest extends TestCase
{
    protected UserController $controller;

    protected ImportUserRequest $request;

    protected RedirectResponse $redirect;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();
        $this->useEntraEmulator();

        $this->signInWithRole(Role::Admin->value);

        $this->controller = new UserController();
    }

    public function testWorks(): void
    {
        $this->request = new ImportUserRequest([
            'email' => 'gandalf.stormcrow@networkrail.co.uk',
        ]);

        $this->redirect = $this->controller->store($this->request);

        $this->assertDatabaseHas('users', [
            'email' => 'gandalf.stormcrow@networkrail.co.uk',
        ]);

        $this->assertFlashed(
            'The account for Gandalf Stormcrow was successfully created',
            'success',
        );

        $this->assertEquals(
            route('admin.users.show', 2),
            $this->redirect->getTargetUrl(),
        );
    }

    public function testFails(): void
    {
        $this->request = new ImportUserRequest([
            'email' => 'bad.crow@networkrail.co.uk',
        ]);

        $this->redirect = $this->controller->store($this->request);

        $this->assertFlashed(
            'Enter the e-mail of a person with a Network Rail account',
            'danger',
        );

        $this->assertEquals(
            route('admin.users.create'),
            $this->redirect->getTargetUrl(),
        );
    }
}
