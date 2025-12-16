<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Throwable;

class ProviderTest extends TestCase
{
    protected CommonServiceProvider $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new CommonServiceProvider($this->app);
    }

    public function testRedirectsWhenBaseUrl(): void
    {
        $exception = new HttpResponseException(redirect(config('common.home')));
        $this->expectException($exception);
        $this->expectExceptionObject($exception);

        App::shouldReceive('runningInConsole')->andReturn(false);
        URL::shouldReceive('getRequest->path')->andReturn('/');

        $this->provider->boot();
    }

    public function test(): void
    {
        $this->expectNotToPerformAssertions();

        App::shouldReceive('runningInConsole')->andReturn(false);
        URL::shouldReceive('getRequest->path')->andReturn('/dashboard');

        try {
            $this->provider->boot();
        } catch (Throwable $exception) {}
    }
}
