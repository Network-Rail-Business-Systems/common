<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Enums\Logo;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AssetPathTest extends TestCase
{
    protected BinaryFileResponse $response;

    public function test(): void
    {
        $this->assertStringStartsWith(
            'file://',
            Logo::Header->assetPath(),
        );
    }
}
