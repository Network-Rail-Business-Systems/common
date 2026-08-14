<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\Favicons;

use NetworkRailBusinessSystems\Common\Controllers\FaviconController;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class IcoTest extends TestCase
{
    protected FaviconController $controller;

    protected BinaryFileResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new FaviconController();
        $this->response = $this->controller->ico();
    }

    public function test(): void
    {
        $this->assertEquals(
            'favicon.ico',
            $this->response->getFile()->getFilename(),
        );
    }
}
