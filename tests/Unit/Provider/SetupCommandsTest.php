<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\Artisan;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupCommandsTest extends TestCase
{
    protected CommonServiceProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
        $this->provider->setupCommands();
    }

    public function test(): void
    {
        $commands = Artisan::all();

        $this->assertArrayHasKey(
            'update:permissions',
            $commands,
        );
    }
}
