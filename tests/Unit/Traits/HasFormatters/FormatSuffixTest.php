<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\HasFormatters;

use NetworkRailBusinessSystems\Common\Tests\Data\Formatter;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FormatSuffixTest extends TestCase
{
    public function testValue(): void
    {
        $this->assertEquals(
            '12%',
            Formatter::checkValue('suffix'),
        );
    }

    public function testBlank(): void
    {
        $this->assertNull(
            Formatter::checkBlank('suffix'),
        );
    }
}
