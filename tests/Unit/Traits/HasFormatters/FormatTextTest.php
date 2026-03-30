<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\HasFormatters;

use NetworkRailBusinessSystems\Common\Tests\Data\Formatter;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FormatTextTest extends TestCase
{
    public function testValue(): void
    {
        $this->assertEquals(
            "My<br />\nText",
            Formatter::checkValue('text'),
        );
    }

    public function testBlank(): void
    {
        $this->assertNull(
            Formatter::checkBlank('text'),
        );
    }
}
