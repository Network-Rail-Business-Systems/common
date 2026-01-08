<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\App;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class BootPublishesTest extends TestCase
{
    public function test(): void
    {
        $provider = new CommonServiceProvider($this->app);
        $provider->bootPublishes();

        /** @var array $publishGroups */
        $this->assertContains(
            App::basePath() . '/config/common.php',
            $provider::$publishGroups['config'],
        );
    }
}
