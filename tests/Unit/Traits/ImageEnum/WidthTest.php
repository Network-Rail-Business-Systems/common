<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\ImageEnum;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class WidthTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            133,
            Logo::MailHeader->width(),
        );
    }
}
