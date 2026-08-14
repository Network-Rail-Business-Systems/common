<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\Banner;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use NetworkRailBusinessSystems\Common\Controllers\BannerController;
use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class CreateTest extends TestCase
{
    protected BannerController $controller;

    protected View $view;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->usePermissions();

        $this->signInWithPermission(Permission::ManageBanner);

        Cache::put(BannerController::CACHE_KEY, [
            'type' => 'info',
            'message' => 'Potato',
            'ends_at' => Carbon::create(2026, 12, 7),
        ]);

        $this->controller = new BannerController();
        $this->view = $this->controller->create();
    }

    public function test(): void
    {
        $this->assertViewRenders($this->view);

        $data = $this->view->getData();

        $fields = $data['questions'];

        $this->assertField(
            [
                'name' => 'type',
                'label' => 'Which type of banner are you setting?',
                'options' => BannerController::BANNER_TYPES,
                'value' => 'info',
            ],
            $fields[0],
        );

        $this->assertField(
            [
                'name' => 'message',
                'label' => 'What message would you like to put on the banner?',
                'value' => 'Potato',
            ],
            $fields[1],
        );

        $this->assertField(
            [
                'name' => 'ends_at',
                'label' => 'When should this banner stop being shown?',
                'optional' => true,
                'hint' => 'Leave blank to show until the system cache is cleared',
                'value' => Carbon::create(2026, 12, 7),
            ],
            $fields[2],
        );
    }
}
