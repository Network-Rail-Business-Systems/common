<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupConfigTest extends TestCase
{
    protected CommonServiceProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
        $this->provider->setupConfig();
    }

    public function test(): void
    {
        $this->assertArrayHasKey(
            'common-config',
            $this->provider::$publishGroups,
        );
    }
}
