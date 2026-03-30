<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\HasFormatters;

use NetworkRailBusinessSystems\Common\Tests\Data\Formatter;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FormatCurrencyTest extends TestCase
{
    public function testValue(): void
    {
        $this->assertEquals(
            '£12.00',
            Formatter::checkValue('currency'),
        );
    }

    public function testBlank(): void
    {
        $this->assertNull(
            Formatter::checkBlank('currency'),
        );
    }
}
