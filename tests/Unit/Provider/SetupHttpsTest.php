<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Mockery;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[PreserveGlobalState(false)]
#[RunTestsInSeparateProcesses]
class SetupHttpsTest extends TestCase
{
    protected function setUp(): void
    {
        // Each test performs its own setup
    }

    public function testOn(): void
    {
        Mockery::mock('overload:' . App::class, function ($mock) {
            $mock->shouldReceive('runningInConsole')
                ->once()
                ->andReturnTrue();

            $mock->shouldReceive('isProduction')
                ->once()
                ->andReturnFalse();

            $mock->shouldReceive('isLocal')
                ->once()
                ->andReturnFalse();

            $mock->shouldReceive('runningUnitTests')
                ->once()
                ->andReturnFalse();
        });

        parent::setUp();

        $this->assertEquals(
            'on',
            $this->app['request']->server->get('HTTPS'),
        );

        $this->assertEquals(
            'https://',
            URL::formatScheme(),
        );
    }

    public function testOff(): void
    {
        Mockery::mock('overload:' . App::class, function ($mock) {
            $mock->shouldReceive('runningInConsole')
                ->once()
                ->andReturnTrue();

            $mock->shouldReceive('isProduction')
                ->once()
                ->andReturnFalse();

            $mock->shouldReceive('isLocal')
                ->once()
                ->andReturnTrue();

            $mock->shouldReceive('runningUnitTests')
                ->once()
                ->andReturnTrue();
        });

        parent::setUp();

        $this->assertNull(
            $this->app['request']->server->get('HTTPS'),
        );

        $this->assertEquals(
            'http://',
            URL::formatScheme(),
        );
    }
}
