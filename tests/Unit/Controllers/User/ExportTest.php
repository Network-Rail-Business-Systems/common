<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use NetworkRailBusinessSystems\Common\Controllers\UserController;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportTest extends TestCase
{
    protected UserController $controller;

    protected BinaryFileResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $now = Carbon::now();
        Carbon::setTestNow($now);

        Storage::fake('temp');

        $this->useDatabase();
        $this->usePermissions();

        $this->signInWithRole(Role::Admin->value);

        $this->controller = new UserController();
        $this->response = $this->controller->export();
    }

    public function test(): void
    {
        $this->assertEquals(
            'attachment; filename=2026_03_19_cmn_users.csv',
            $this->response->headers->get('content-disposition'),
        );
    }
}
