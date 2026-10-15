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
        Mockery::mock('overload:' . App::class, function ($mock) {
            $mock->shouldReceive('runningInConsole')
                ->once()
                ->andReturnTrue();

            $mock->shouldReceive('isProduction')
                ->once()
                ->andReturnFalse();

            $mock->shouldReceive('runningUnitTests')
                ->once()
                ->andReturnFalse();
        });

        parent::setUp();
    }

    public function test(): void
    {
        $this->assertEquals(
            'on',
            $this->app['request']->server->get('HTTPS'),
            'Scheme was not forced as expected',
        );

        $this->assertEquals(
            'https://',
            URL::formatScheme(),
        );
    }
}
