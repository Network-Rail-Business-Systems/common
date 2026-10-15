<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\URL;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupHttpsTest extends TestCase
{
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
