<?php

namespace NetworkRailBusinessSystems\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use NetworkRailBusinessSystems\Common\Commands\UpdatePermissions;

class CommonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'common');
    }

    public function boot(): void
    {
        $this->setupBaseUrlRedirect();
        $this->setupCommands();
        $this->setupConfig();
        $this->setupHttps();
        $this->setupModels();
    }

    public function setupBaseUrlRedirect(): void
    {
        if (
            App::runningInConsole() === false
            && URL::getRequest()->path() === '/'
        ) {
            throw new HttpResponseException(
                redirect(
                    config('common.home'),
                ),
            );
        }
    }

    public function setupCommands(): void
    {
        $this->commands([
            UpdatePermissions::class,
        ]);
    }

    public function setupConfig(): void
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('common.php'),
        ], 'common-config');
    }

    public function setupHttps(): void
    {
        if (
            config('common.force_https', false) === true
            || in_array(Request::host(), [
                'systems.hiav.networkrail.co.uk',
                'systems3.hiav.networkrail.co.uk',
                'systems4.hiav.networkrail.co.uk',
                'systems5.hiav.networkrail.co.uk',
            ])
        ) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }

    public function setupModels(): void
    {
        Schema::defaultStringLength(191);
        Model::shouldBeStrict(App::environment() !== 'production');
    }

    public function setupViews(): void
    {
        $template = config('common.template') ?? 'govuk';

        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/common'),
        ], 'common-views');

        $this->loadViewsFrom(
            __DIR__ . '/Views/' . $template,
            'common',
        );
    }
}
