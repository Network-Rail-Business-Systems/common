<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupExceptionsTest extends TestCase
{
    public function testHandlesGenericException(): void
    {
        $page = app(Handler::class)->render(
            request(),
            new ErrorException(''),
        );

        $this->assertStringStartsWith(
            '<h2 class="title">Whoops, something went wrong</h2>',
            $page->getContent(),
        );

        $this->assertEquals(
            500,
            $page->getStatusCode(),
        );
    }

    public function testHandlesHttpException(): void
    {
        $page = app(Handler::class)->render(
            request(),
            new ModelNotFoundException(),
        );

        $this->assertStringStartsWith(
            '<h2 class="title">Sorry, that page was not found</h2>',
            $page->getContent(),
        );

        $this->assertEquals(
            404,
            $page->getStatusCode(),
        );
    }

    public function testHandlesRedirect(): void
    {
        $redirect = app(Handler::class)->render(
            request(),
            new HttpResponseException(
                redirect()->back(),
            ),
        );

        $this->assertInstanceOf(
            RedirectResponse::class,
            $redirect,
        );
    }

    public function testHandlesValidation(): void
    {
        $redirect = app(Handler::class)->render(
            request(),
            new ValidationException(
                Validator::make([], []),
            ),
        );

        $this->assertInstanceOf(
            RedirectResponse::class,
            $redirect,
        );
    }
}
