<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\App;

use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ConfigureModelsTest extends TestCase
{
    public function testDevelopment(): void
    {
        App::shouldReceive('environment')->andReturn('development');

        $this->assertTrue(Model::preventsLazyLoading());

        $this->assertEquals(
            191,
            Builder::$defaultStringLength,
        );
    }

    public function testProduction(): void
    {
        App::shouldReceive('environment')->andReturn('production');
        $this->assertTrue(Model::preventsLazyLoading());
    }
}
