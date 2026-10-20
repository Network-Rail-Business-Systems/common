<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Enums\Logo;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HeightTest extends TestCase
{
    protected BinaryFileResponse $response;

    public function testSvgHeader(): void
    {
        $this->assertEquals(
            44,
            Logo::Header->height(),
        );
    }

    public function testSvgFooter(): void
    {
        $this->assertEquals(
            55,
            Logo::Footer->height(),
        );
    }

    public function testRealImage(): void
    {
        $this->assertEquals(
            50,
            Logo::MailHeader->height(),
        );
    }
}
