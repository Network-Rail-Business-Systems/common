<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\HasFormatters;

use NetworkRailBusinessSystems\Common\Tests\Data\Formatter;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FormatPrefixTest extends TestCase
{
    public function testValue(): void
    {
        $this->assertEquals(
            '#123',
            Formatter::checkValue('prefix'),
        );
    }

    public function testBlank(): void
    {
        $this->assertNull(
            Formatter::checkBlank('prefix'),
        );
    }
}
