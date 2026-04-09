<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupRoutesTest extends TestCase
{
    protected CommonServiceProvider $provider;

    public function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
        $this->provider->setupRoutes();
    }

    public function test(): void
    {
        $this->assertEquals(
            'http://localhost/privacy',
            route('privacy'),
        );

        $this->assertEquals(
            'http://localhost/admin',
            route('admin.index'),
        );

        $this->assertEquals(
            'http://localhost/admin/users',
            route('admin.users.index'),
        );

        $this->assertEquals(
            'http://localhost/admin/users/1/roles/admin/assign',
            route('admin.users.roles.assign', [1, 'admin']),
        );
    }
}
