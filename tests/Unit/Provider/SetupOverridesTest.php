<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use GuzzleHttp\Handler\CurlVersion;
use Illuminate\Foundation\AliasLoader;
use NetworkRailBusinessSystems\Common\Overrides\CurlVersion as CurlVersionOverride;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupOverridesTest extends TestCase
{
    public function test(): void
    {
        $loader = AliasLoader::getInstance();

        $this->assertEquals(
            CurlVersionOverride::class,
            $loader->getAliases()[CurlVersion::class],
        );
    }
}
