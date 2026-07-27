<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Overrides\CurlVersion;

use NetworkRailBusinessSystems\Common\Overrides\CurlVersion;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SupportsRequiredHttp2MultiplexTest extends TestCase
{
    public function test(): void
    {
        $this->assertFalse(
            CurlVersion::supportsRequiredHttp2Multiplex(),
        );
    }
}
