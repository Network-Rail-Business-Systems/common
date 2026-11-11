<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Artisan;

use NetworkRailBusinessSystems\Common\Tests\TestCase;

abstract class CacheTestCase extends TestCase
{
    public const array COMMANDS = [
        'config',
        'event',
        'route',
        'view',
    ];

    public function test(): void
    {
        foreach (self::COMMANDS as $command) {
            $this->artisan("$command:cache")->assertSuccessful();
            $this->artisan("$command:clear")->assertSuccessful();
        }
    }
}
