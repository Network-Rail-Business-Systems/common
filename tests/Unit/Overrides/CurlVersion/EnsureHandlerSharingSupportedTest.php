<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Overrides\CurlVersion;

use NetworkRailBusinessSystems\Common\Overrides\CurlVersion;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class EnsureHandlerSharingSupportedTest extends TestCase
{
    public function test(): void
    {
        $this->expectNotToPerformAssertions();

        CurlVersion::ensureHandlerSharingSupported();
    }
}
