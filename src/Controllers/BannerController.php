<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use AnthonyEdmonds\GovukLaravel\Helpers\GovukDate;
use AnthonyEdmonds\LaravelFormBuilder\Helpers\Field;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use NetworkRailBusinessSystems\Common\FormRequests\BannerRequest;

class BannerController extends Controller
{
    public const string CACHE_KEY = 'system-banner';

    public const array BANNER_TYPES = [
        'info' => 'Notice',
        'danger' => 'Outage',
        'warning' => 'Warning',
    ];

    public const array BLANK_BANNER = [
        'type' => null,
        'title' => null,
        'message' => null,
        'ends_at' => null,
    ];

    public function create(): View
    {
        $this->authorize(
            config('common.permissions.manage_banner'),
        );

        $existingBanner = Cache::get(self::CACHE_KEY) ?? self::BLANK_BANNER;

        return view('common::admin.banner.create', [
            'method' => 'POST',
            'questions' => [
                Field::radios(
                    'type',
                    'Which type of banner are you setting?',
                    self::BANNER_TYPES,
                )
                    ->setValue($existingBanner['type']),
                Field::input(
                    'title',
                    'What should the title of the banner be?',
                )
                    ->setValue($existingBanner['title']),
                Field::input(
                    'message',
                    'What message would you like to put on the banner?',
                )
                    ->setValue($existingBanner['message']),
                Field::date(
                    'ends_at',
                    'When should this banner stop being shown?',
                )
                    ->setValue($existingBanner['ends_at'])
                    ->optional()
                    ->setHint('Leave blank to show until the system cache is cleared'),
            ],
            'submitButtonMode' => '',
            'submitButtonLabel' => 'Save banner',
            'otherButtonHref' => route('admin.index'),
            'otherButtonMethod' => 'GET',
            'otherButtonLabel' => 'Cancel and back',
        ]);
    }

    public function store(BannerRequest $request): RedirectResponse
    {
        $this->authorize(
            config('common.permissions.manage_banner'),
        );

        $end = $request->input('ends_at-day') !== null
            ? GovukDate::parseDate($request, 'ends_at')
            : null;

        Cache::put(
            self::CACHE_KEY,
            [
                'type' => $request->input('type'),
                'title' => $request->input('title'),
                'message' => $request->input('message'),
                'ends_at' => $end,
            ],
            $end,
        );

        flash()->success('The system banner was successfully set');

        return Redirect::route('admin.banner.create');
    }

    public function clear(): RedirectResponse
    {
        $this->authorize(
            config('common.permissions.manage_banner'),
        );

        Cache::forget(self::CACHE_KEY);

        flash()->success('The system banner was successfully cleared');

        return Redirect::route('admin.banner.create');
    }
}
