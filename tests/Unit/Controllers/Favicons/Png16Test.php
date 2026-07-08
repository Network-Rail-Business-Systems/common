<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\Favicons;

use NetworkRailBusinessSystems\Common\Controllers\FaviconController;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Png16Test extends TestCase
{
    protected FaviconController $controller;

    protected BinaryFileResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new FaviconController();
        $this->response = $this->controller->png16();
    }

    public function test(): void
    {
        $this->assertEquals(
            'favicon-16x16.png',
            $this->response->getFile()->getFilename(),
        );
    }
}
