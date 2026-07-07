<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\Schedule;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupJobsTest extends TestCase
{
    protected CommonServiceProvider $provider;

    public function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
    }

    public function test(): void
    {
        $this->assertCount(
            4,
            Schedule::events(),
        );
    }
}
