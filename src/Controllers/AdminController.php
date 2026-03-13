<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $this->authorize(
            config('common.permissions.access_admin'),
        );

        return view('common::admin.index', [
            'breadcrumbs' => [
                'Admin' => route('admin.index'),
            ],
            'title' => 'Admin',
        ]);
    }
}
