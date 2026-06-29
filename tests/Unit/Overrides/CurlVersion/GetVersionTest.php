<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Overrides\CurlVersion;

use NetworkRailBusinessSystems\Common\Overrides\CurlVersion;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class GetVersionTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            '7.29.0',
            CurlVersion::getVersion(),
        );
    }
}
