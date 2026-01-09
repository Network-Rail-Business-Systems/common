<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Mockery;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Throwable;

class BootTest extends TestCase
{
    protected CommonServiceProvider $provider;

    public function setUp(): void
    {
        Mockery::mock('overload:' . Request::class, function ($mock) {
            $mock->shouldReceive('host')->andReturn('systems.hiav.networkrail.co.uk');
        });

        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
    }

    public function test(): void
    {
        try {
            $this->provider->boot();
        } catch (Throwable $exception) {
            $this->fail($exception->getMessage());
        }

        $this->assertArrayHasKey(
            'config',
            $this->provider::$publishGroups,
        );

        $this->assertTrue(Model::preventsLazyLoading());

        $this->assertEquals(
            'on',
            $this->app['request']->server->get('HTTPS'),
        );
    }
}
