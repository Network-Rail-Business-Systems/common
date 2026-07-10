<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\Logo;

use NetworkRailBusinessSystems\Common\Controllers\LogoController;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HeaderTest extends TestCase
{
    protected LogoController $controller;

    protected BinaryFileResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new LogoController();
        $this->response = $this->controller->header();
    }

    public function test(): void
    {
        $this->assertEquals(
            'logo-header.svg',
            $this->response->getFile()->getFilename(),
        );
    }
}
