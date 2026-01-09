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

        App::shouldReceive('environment')->andReturn('production');
    }

    public function testInConsoleNoRedirectWhenBaseUrl(): void
    {
        $this->expectNotToPerformAssertions();

        App::shouldReceive('runningInConsole')->andReturn(true);
        URL::shouldReceive('getRequest->path')->andReturn('/');

        try {
            $this->provider->redirectsBaseUrl();
        } catch (HttpResponseException $exception) {
            $this->fail('Redirect was thrown when it should not have');
        } catch (Throwable $exception) {
            $this->fail($exception->getMessage());
        }
    }

    public function testRedirectsToDefaultWhenBaseUrl(): void
    {
        $exception = new HttpResponseException(
            redirect(
                '/home',
            ),
        );

        $this->expectException($exception);
        $this->expectExceptionObject($exception);

        App::shouldReceive('runningInConsole')->andReturn(false);
        URL::shouldReceive('getRequest->path')->andReturn('/');

        $this->provider->redirectsBaseUrl();
    }

    public function testRedirectsToConfiguredWhenBaseUrl(): void
    {
        config()->set('common.home', '/dashboard');

        $exception = new HttpResponseException(
            redirect(
                '/dashboard',
            ),
        );

        $this->expectException($exception);
        $this->expectExceptionObject($exception);

        App::shouldReceive('runningInConsole')->andReturn(false);
        URL::shouldReceive('getRequest->path')->andReturn('/');

        $this->provider->redirectsBaseUrl();
    }

    public function testDoesNotRedirectWhenNotBaseUrl(): void
    {
        $this->expectNotToPerformAssertions();

        App::shouldReceive('runningInConsole')->andReturn(false);
        URL::shouldReceive('getRequest->path')->andReturn('/home');

        try {
            $this->provider->redirectsBaseUrl();
        } catch (HttpResponseException $exception) {
            $this->fail('Redirect was thrown when it should not have');
        } catch (Throwable $exception) {
            $this->fail($exception->getMessage());
        }
    }
}
