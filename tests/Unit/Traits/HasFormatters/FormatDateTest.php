<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\HasFormatters;

use NetworkRailBusinessSystems\Common\Tests\Data\Formatter;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FormatDateTest extends TestCase
{
    public function testValue(): void
    {
        $this->assertEquals(
            '13/12/2026 00:00',
            Formatter::checkValue('date'),
        );
    }

    public function testBlank(): void
    {
        $this->assertNull(
            Formatter::checkBlank('date'),
        );
    }
}
