<?php

namespace NetworkRailBusinessSystems\Common\Tests;

use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    protected function getPackageProviders($app): array
    {
        return [
            CommonServiceProvider::class,
        ];
    }
}
