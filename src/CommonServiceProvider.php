<?php

namespace NetworkRailBusinessSystems\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use NetworkRailBusinessSystems\Common\Commands\UpdatePermissions;
use NetworkRailBusinessSystems\Common\Controllers\PrivacyController;

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
        $this->setupPolicies();
        $this->setupRoutes();
        $this->setupViews();
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

    public function setupPolicies(): void
    {
        Gate::policy(
            config('common.models.user'),
            config('common.policies.user'),
        );
    }

    public function setupRoutes(): void
    {
        Route::macro('common', function () {
            Route::prefix('/privacy')
                ->controller(PrivacyController::class)
                ->group(function () {
                    Route::get('/', 'show')->name('privacy');
                });

            Route::middleware('EntraAuthenticated')->group(function () {
                Route::prefix('/admin')
                    ->name('admin.')
                    ->controller(config('common.controllers.admin'))
                    ->group(function () {
                        Route::get('/', 'index')->name('index');

                        Route::prefix('/users')
                            ->name('users.')
                            ->controller(config('common.controllers.user'))
                            ->group(function () {
                                Route::get('/', 'index')->name('index');
                                Route::get('/create', 'create')->name('create');
                                Route::post('/create', 'store')->name('store');
                                Route::get('/export', 'export')->name('export');

                                Route::activityLogActioner(config('common.models.user'));
                                Route::activityLogActioned(config('common.models.user'));

                                Route::prefix('/{user}')->group(function () {
                                    Route::get('/', 'show')->name('show');

                                    Route::prefix('/roles/{name}')
                                        ->name('roles.')
                                        ->controller(config('common.controllers.role'))
                                        ->group(function () {
                                            Route::post('/assign', 'assign')->name('assign');
                                            Route::post('/revoke', 'remove')->name('remove');
                                        });
                                });
                            });
                    });
            });
        });
    }

    public function setupViews(): void
    {
        $template = config('common.template') ?? 'govuk';
        $path = __DIR__ . '/Views/' . $template;

        $this->publishes([
            $path => resource_path('views/vendor/common'),
        ], 'common-views');

        $this->loadViewsFrom(
            $path,
            'common',
        );
    }
}
