<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\ImageEnum;

use NetworkRailBusinessSystems\Common\Enums\Favicon;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class HeightTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            16,
            Favicon::Png16->height(),
        );
    }
}
