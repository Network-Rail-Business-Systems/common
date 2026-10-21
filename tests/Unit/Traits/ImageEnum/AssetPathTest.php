<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\ImageEnum;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class AssetPathTest extends TestCase
{
    public function test(): void
    {
        $this->assertStringStartsWith(
            'file://',
            Logo::Header->assetPath(),
        );
    }
}
