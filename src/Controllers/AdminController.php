<?php

namespace NetworkRailBusinessSystems\Common\Controllers;

use BackedEnum;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $this->authorize(
            config('common.permissions.access_admin'),
        );

        $links = [];
        $settings = config('common.admin') ?? [];

        foreach ($settings as $label => $config) {
            $links[$label] = $this->makeLink(
                $config['route'],
                $config['permission'] ?? null,
            );
        }

        ksort($links, SORT_STRING|SORT_FLAG_CASE);

        return view('common::admin.index', [
            'breadcrumbs' => [
                'Admin' => route('admin.index'),
            ],
            'links' => $links,
            'title' => 'Admin',
        ]);
    }

    protected function makeLink(string $route, BackedEnum|string|null $permission): array
    {
        if (
            is_string($permission) === true
            && str_starts_with($permission, 'config:') === true
        ) {
            $permission = config(
                str_replace('config:', '', $permission),
            );
        }

        return [
            'route' => route($route),
            'permission' => $permission,
        ];
    }
}
