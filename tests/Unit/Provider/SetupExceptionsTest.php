<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Foundation\Exceptions\Handler as FoundationHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Illuminate\Foundation\Configuration\Exceptions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetupExceptionsTest extends TestCase
{
    protected CommonServiceProvider $provider;

    protected FoundationHandler $handler;

    protected Exceptions $exceptions;

    protected function setUp(): void
    {
        parent::setUp();

        View::replaceNamespace('govuk', realpath(__DIR__ . '/../../Data'));

        $this->provider = new CommonServiceProvider($this->app);
        $this->handler = $this->app->make(FoundationHandler::class);
        $this->exceptions = new Exceptions($this->handler);
        $this->provider->setupExceptions($this->exceptions);
        ;
    }

    public function testRendersViews(): void
    {
        $response = $this->handler->render(
            Request::create('/incorrect'),
            new NotFoundHttpException('Not found'),
        );

        $this->assertSame(404, $response->getStatusCode());
        $this->assertStringContainsString('404-error', $response->getContent());
    }
}
