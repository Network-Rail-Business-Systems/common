<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\Banner;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use NetworkRailBusinessSystems\Common\Controllers\BannerController;
use NetworkRailBusinessSystems\Common\FormRequests\BannerRequest;
use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class StoreTest extends TestCase
{
    protected BannerController $controller;

    protected RedirectResponse $redirect;

    protected BannerRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->signInWithPermission(Permission::ManageBanner);

        $this->controller = new BannerController();
    }

    public function test(): void
    {
        $this->request = new BannerRequest([
            'type' => 'info',
            'message' => 'Potato',
            'ends_at' => 1,
            'ends_at-day' => 7,
            'ends_at-month' => 12,
            'ends_at-year' => 2026,
        ]);

        $this->redirect = $this->controller->store($this->request);

        $this->assertEquals(
            [
                'type' => 'info',
                'message' => 'Potato',
                'ends_at' => Carbon::create(2026, 12, 7),
            ],
            Cache::get(BannerController::CACHE_KEY),
        );

        $this->assertFlashed(
            'The system banner was successfully set',
            'success',
        );

        $this->assertEquals(
            route('admin.banner.create'),
            $this->redirect->getTargetUrl(),
        );
    }

    public function testHandlesNullEndsAt(): void
    {
        $this->request = new BannerRequest([
            'type' => 'info',
            'message' => 'Potato',
            'ends_at' => 1,
            'ends_at-day' => null,
            'ends_at-month' => null,
            'ends_at-year' => null,
        ]);

        $this->redirect = $this->controller->store($this->request);

        $this->assertEquals(
            [
                'type' => 'info',
                'message' => 'Potato',
                'ends_at' => null,
            ],
            Cache::get(BannerController::CACHE_KEY),
        );
    }
}
