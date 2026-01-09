<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Mockery;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CheckHttpsTest extends TestCase
{
    protected function setUp(): void
    {
        // Must be empty to allow each test to define a host.
    }

    #[DataProvider('expectations')]
    public function test(
        string $host,
        ?string $expectation,
    ): void {
        Mockery::mock('overload:' . Request::class, function ($mock) use ($host) {
            $mock->shouldReceive('host')->andReturn($host);
        });

        parent::setUp();

        $provider = new CommonServiceProvider($this->app);
        $provider->checkHttps();

        $this->assertEquals(
            $expectation,
            $this->app['request']->server->get('HTTPS'),
            'Scheme was not forced as expected',
        );

        $this->assertEquals(
            $expectation === 'on' ? 'https://' : 'http://',
            URL::formatScheme(),
        );
    }

    public static function expectations(): array
    {
        return [
            [
                'host' => 'systems.hiav.networkrail.co.uk',
                'expectation' => 'on',
            ],
            [
                'host' => 'systems2.hiav.networkrail.co.uk',
                'expectation' => null,
            ],
            [
                'host' => 'systems3.hiav.networkrail.co.uk',
                'expectation' => 'on',
            ],
            [
                'host' => 'systems4.hiav.networkrail.co.uk',
                'expectation' => 'on',
            ],
            [
                'host' => 'systems5.hiav.networkrail.co.uk',
                'expectation' => 'on',
            ],
            [
                'host' => 'www.example.com',
                'expectation' => null,
            ],
        ];
    }
}
