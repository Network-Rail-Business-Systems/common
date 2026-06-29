<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Overrides\CurlVersion;

use NetworkRailBusinessSystems\Common\Overrides\CurlVersion;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SupportsTls12Test extends TestCase
{
    public function test(): void
    {
        $this->assertTrue(
            CurlVersion::supportsTls12(),
        );
    }
}
