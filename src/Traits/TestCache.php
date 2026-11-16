<?php

namespace NetworkRailBusinessSystems\Common\Traits;

trait TestCache
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
