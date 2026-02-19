<?php

namespace NetworkRailBusinessSystems\Common\Tests;

use AnthonyEdmonds\LaravelTestingTraits\AssertsFlashMessages;
use AnthonyEdmonds\LaravelTestingTraits\GetsRawCsvs;
use Laracasts\Flash\FlashServiceProvider;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use AssertsFlashMessages;
    use GetsRawCsvs;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    protected function getPackageProviders($app): array
    {
        return [
            CommonServiceProvider::class,
            FlashServiceProvider::class,
        ];
    }
}
