<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Enums\Logo;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WidthTest extends TestCase
{
    protected BinaryFileResponse $response;

    public function testSvgHeader(): void
    {
        $this->assertEquals(
            117,
            Logo::Header->width(),
        );
    }

    public function testSvgFooter(): void
    {
        $this->assertEquals(
            146,
            Logo::Footer->width(),
        );
    }

    public function testRealImage(): void
    {
        $this->assertEquals(
            133,
            Logo::MailHeader->width(),
        );
    }
}
