<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\Favicons;

use NetworkRailBusinessSystems\Common\Controllers\FaviconController;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Png32Test extends TestCase
{
    protected FaviconController $controller;

    protected BinaryFileResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new FaviconController();
        $this->response = $this->controller->png32();
    }

    public function test(): void
    {
        $this->assertEquals(
            'favicon-32x32.png',
            $this->response->getFile()->getFilename(),
        );
    }
}
