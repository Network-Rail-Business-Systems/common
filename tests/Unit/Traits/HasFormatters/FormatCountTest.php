<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\HasFormatters;

use NetworkRailBusinessSystems\Common\Tests\Data\Formatter;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FormatCountTest extends TestCase
{
    public function testValue(): void
    {
        $this->assertEquals(
            '3 penguins',
            Formatter::checkValue('count'),
        );
    }

    public function testBlank(): void
    {
        $this->assertNull(
            Formatter::checkBlank('count'),
        );
    }
}
