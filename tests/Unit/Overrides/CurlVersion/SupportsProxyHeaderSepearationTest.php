<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Overrides\CurlVersion;

use NetworkRailBusinessSystems\Common\Overrides\CurlVersion;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SupportsProxyHeaderSepearationTest extends TestCase
{
    public function test(): void
    {
        $this->assertFalse(
            CurlVersion::supportsProxyHeaderSeparation(),
        );
    }
}
