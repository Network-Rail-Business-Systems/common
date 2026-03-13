<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupRoutesTest extends TestCase
{
    protected CommonServiceProvider $provider;

    public function setUp(): void
    {
        parent::setUp();

        Gate::clearResolvedInstances();

        $this->provider = new CommonServiceProvider($this->app);
        $this->provider->setupRoutes();
    }

    public function test(): void
    {
        $this->assertTrue(
            Route::has('admin.'),
        );

        $this->assertTrue(
            Route::has('admin.users.'),
        );

        $this->assertTrue(
            Route::has('admin.users.roles.'),
        );
    }
}
