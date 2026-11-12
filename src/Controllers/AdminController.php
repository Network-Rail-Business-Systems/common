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

        $links = [];
        $settings = config('common.admin') ?? [];

        foreach ($settings as $label => $config) {
            $links[$label] = $this->makeLink(
                $config['route'],
                $config['permission'] ?? null,
            );
        }

        ksort($links);

        return view('common::admin.index', [
            'breadcrumbs' => [
                'Admin' => route('admin.index'),
            ],
            'links' => $links,
            'title' => 'Admin',
        ]);
    }

    protected function makeLink(string $route, ?string $permission): array
    {
        if (
            $permission !== null
            && str_starts_with($permission, 'config:') === true
        ) {
            $permission = str_replace('config:', '', $permission);
            $permission = config($permission);
        }

        return [
            'route' => route($route),
            'permission' => $permission,
        ];
    }
}
