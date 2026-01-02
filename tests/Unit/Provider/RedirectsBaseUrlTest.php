<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Throwable;

class RedirectsBaseUrlTest extends TestCase
{
    protected CommonServiceProvider $provider;

    public function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);

        App::shouldReceive('runningInConsole')->andReturn(false);
        App::shouldReceive('environment')->andReturn('production');
    }

    public function testRedirectsWhenBaseUrl(): void
    {
        $exception = new HttpResponseException(
            redirect(
                '/dashboard',
            ),
        );

        $this->expectException($exception);
        $this->expectExceptionObject($exception);

        URL::shouldReceive('getRequest->path')->andReturn('/');

        $this->provider->redirectsBaseUrl();
    }

    public function testDoesNotRedirectWhenNotBaseUrl(): void
    {
        $this->expectNotToPerformAssertions();

        URL::shouldReceive('getRequest->path')->andReturn('/dashboard');

        try {
            $this->provider->redirectsBaseUrl();
        } catch (Throwable $exception) {
            $this->fail('Redirect was thrown when it should not have');
        }
    }
}
