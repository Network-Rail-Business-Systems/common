<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\HasFormatters;

use NetworkRailBusinessSystems\Common\Tests\Data\Formatter;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FormatBooleanTest extends TestCase
{
    public function testTrue(): void
    {
        $this->assertEquals(
            'Yes',
            Formatter::checkValue('boolean', true),
        );
    }

    public function testFalse(): void
    {
        $this->assertEquals(
            'No',
            Formatter::checkValue('boolean', false),
        );
    }

    public function testBlank(): void
    {
        $this->assertNull(
            Formatter::checkBlank('count'),
        );
    }
}
