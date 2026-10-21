<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\ImageEnum;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class RealPathTest extends TestCase
{
    public function test(): void
    {
        $this->assertStringEndsWith(
            '/src/Resources/Images/logo-header.svg',
            Logo::Header->realPath(),
        );
    }
}
