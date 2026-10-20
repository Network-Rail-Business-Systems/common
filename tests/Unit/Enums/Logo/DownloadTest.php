<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Enums\Logo;

use NetworkRailBusinessSystems\Common\Enums\Logo;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadTest extends TestCase
{
    protected BinaryFileResponse $response;

    public function test(): void
    {
        $this->response = Logo::Header->download();

        $this->assertStringEndsWith(
            Logo::Header->value,
            $this->response->getFile()->getRealPath(),
        );

        $this->assertTrue(
            $this->response->headers->has('etag'),
        );

        $this->assertTrue(
            $this->response->headers->has('last-modified'),
        );

        $this->assertTrue(
            $this->response->headers->has('date'),
        );

        $this->assertEquals(
            'max-age=0, public',
            $this->response->headers->get('cache-control'),
        );
    }
}
