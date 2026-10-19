<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Enums\Logo;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PathTest extends TestCase
{
    protected BinaryFileResponse $response;

    public function test(): void
    {
        $this->assertStringEndsWith(
            '/src/Resources/Images/logo-header.svg',
            Logo::Header->path(),
        );
    }
}
