<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\HasFormatters;

use NetworkRailBusinessSystems\Common\Tests\Data\Formatter;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FormatPersonTest extends TestCase
{
    public function testValue(): void
    {
        $this->assertEquals(
            [
                'Hello',
                'There',
            ],
            Formatter::checkValue('person'),
        );
    }

    public function testBlank(): void
    {
        $this->assertNull(
            Formatter::checkBlank('person'),
        );
    }
}
