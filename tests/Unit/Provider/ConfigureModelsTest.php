<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\App;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ConfigureModelsTest extends TestCase
{
    protected CommonServiceProvider $provider;

    public function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
    }

    public function testProduction(): void
    {
        App::shouldReceive('environment')->andReturn('production');

        $this->provider->configureModels();

        $this->assertFalse(Model::preventsLazyLoading());
    }

    public function testDevelopment(): void
    {
        App::shouldReceive('environment')->andReturn('development');

        $this->provider->configureModels();

        $this->assertTrue(Model::preventsLazyLoading());

        $this->assertEquals(
            191,
            Builder::$defaultStringLength,
        );
    }
}
