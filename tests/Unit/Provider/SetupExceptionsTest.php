<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use ErrorException;
use Illuminate\Foundation\Exceptions\Handler;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupExceptionsTest extends TestCase
{
    public function test(): void
    {
        $page = app(Handler::class)->render(
            request(),
            new ErrorException('', 500),
        );

        $this->assertStringStartsWith(
            '<h2 class="title">Whoops, something went wrong</h2>',
            $page->getContent(),
        );
    }
}
