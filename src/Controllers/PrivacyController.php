<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use Illuminate\Contracts\View\View;

class PrivacyController extends Controller
{
    public function show(): View
    {
        return view('common::privacy', [
            'breadcrumbs' => [
                'Privacy' => route('privacy'),
            ],
            'privacy' => config('common.privacy'),
            'title' => 'Privacy & Cookies',
        ]);
    }
}
