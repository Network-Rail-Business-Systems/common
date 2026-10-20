<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\ImageEnum;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class HeightTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            50,
            Logo::MailHeader->height(),
        );
    }
}
