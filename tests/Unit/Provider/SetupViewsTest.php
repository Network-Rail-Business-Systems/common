<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\View;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupViewsTest extends TestCase
{
    protected CommonServiceProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
        $this->provider->setupViews();
    }

    public function test(): void
    {
        $this->assertArrayHasKey(
            'common-views',
            $this->provider::$publishGroups,
        );

        $this->assertTrue(
            View::exists('common::users.index'),
        );

        $this->assertTrue(
            View::exists('common::users.show'),
        );
    }
}
