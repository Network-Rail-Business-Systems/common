<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use Illuminate\Support\Facades\Gate;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SetupPoliciesTest extends TestCase
{
    protected CommonServiceProvider $provider;

    public function setUp(): void
    {
        parent::setUp();

        Gate::clearResolvedInstances();

        $this->provider = new CommonServiceProvider($this->app);
        $this->provider->setupPolicies();
    }

    public function test(): void
    {
        $this->assertEquals(
            [
                'User::class' => UserPolicy::class,
                User::class => UserPolicy::class,
            ],
            Gate::policies(),
        );
    }
}
