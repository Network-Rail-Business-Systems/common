<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\App;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupModelsTest extends TestCase
{
    protected CommonServiceProvider $provider;

    public function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
    }

    public function testProduction(): void
    {
        App::shouldReceive('isProduction')->andReturnTrue();

        $this->provider->setupModels();

        $this->assertFalse(Model::preventsLazyLoading());
    }

    public function testDevelopment(): void
    {
        App::shouldReceive('isProduction')->andReturnFalse();

        $this->provider->setupModels();

        $this->assertTrue(Model::preventsLazyLoading());

        $this->assertEquals(
            191,
            Builder::$defaultStringLength,
        );
    }
}
