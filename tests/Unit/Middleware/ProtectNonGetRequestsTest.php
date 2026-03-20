<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Middleware;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use NetworkRailBusinessSystems\Common\Middleware\ProtectNonGetRequests;
use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ProtectNonGetRequestsTest extends TestCase
{
    protected ProtectNonGetRequests $middleware;

    protected User $impersonated;

    protected User $impersonator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->middleware = new ProtectNonGetRequests();

        $this->impersonated = User::factory()->create();
        $this->impersonator = $this->signInWithPermission(Permission::Impersonate->value);
    }

    public function testAllowsGetWhenNotImpersonating(): void
    {
        $this->expectNotToPerformAssertions();

        $this->makeRequest('GET');
    }

    public function testAllowsPostWhenNotImpersonating(): void
    {
        $this->expectNotToPerformAssertions();

        $this->makeRequest('POST');
    }

    public function testAllowsGetWhenImpersonating(): void
    {
        $this->expectNotToPerformAssertions();

        $this->impersonator->impersonate($this->impersonated);
        $this->makeRequest('GET');
    }

    public function testDeniesPostWhenImpersonating(): void
    {
        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage(
            'You cannot perform this action while impersonating another User',
        );

        $this->impersonator->impersonate($this->impersonated);
        $this->makeRequest('POST');
    }

    protected function makeRequest(string $method): void
    {
        $request = new Request();
        $request->setMethod($method);
        $request->setUserResolver(function () {
            return $this->impersonator;
        });

        $this->middleware->handle($request, function () {});
    }
}
