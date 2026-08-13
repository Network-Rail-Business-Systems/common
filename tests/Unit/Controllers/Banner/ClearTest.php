<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\Banner;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use NetworkRailBusinessSystems\Common\Controllers\BannerController;
use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ClearTest extends TestCase
{
    protected BannerController $controller;

    protected RedirectResponse $redirect;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->signInWithPermission(Permission::ManageBanner);

        Cache::put(BannerController::CACHE_KEY, 'Potato');

        $this->controller = new BannerController();
        $this->redirect = $this->controller->clear();
    }

    public function test(): void
    {
        $this->assertFalse(
            Cache::has(BannerController::CACHE_KEY),
        );

        $this->assertFlashed(
            'The system banner was successfully cleared',
            'success',
        );

        $this->assertEquals(
            route('admin.banner.create'),
            $this->redirect->getTargetUrl(),
        );
    }
}
