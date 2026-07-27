<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Overrides\CurlVersion;

use NetworkRailBusinessSystems\Common\Overrides\CurlVersion;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SupportsRequiredMultiplexTest extends TestCase
{
    public function test(): void
    {
        $this->assertFalse(
            CurlVersion::supportsRequiredMultiplex(),
        );
    }
}
