<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Controllers\Privacy;

use Illuminate\Contracts\View\View;
use NetworkRailBusinessSystems\Common\Controllers\PrivacyController;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ShowTest extends TestCase
{
    protected PrivacyController $controller;

    protected View $view;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new PrivacyController();
        $this->view = $this->controller->show();
    }

    public function test(): void
    {
        $this->assertViewRenders($this->view);

        $this->assertEquals(
            'common::privacy',
            $this->view->name(),
        );

        $data = $this->view->getData();

        $this->assertEquals(
            [
                'Privacy' => route('privacy'),
            ],
            $data['breadcrumbs'],
        );

        $this->assertEquals(
            'Privacy & Cookies',
            $data['title'],
        );

        $this->assertEquals(
            config('common.privacy'),
            $data['privacy'],
        );
    }
}
