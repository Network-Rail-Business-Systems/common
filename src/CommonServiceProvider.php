<?php

namespace NetworkRailBusinessSystems\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use NetworkRailBusinessSystems\Common\Commands\UpdatePermissions;
use NetworkRailBusinessSystems\Common\Controllers\FaviconController;
use NetworkRailBusinessSystems\Common\Controllers\LogoController;
use NetworkRailBusinessSystems\Common\Controllers\PrivacyController;
use NetworkRailBusinessSystems\Common\Jobs\CleanupFailedJobs;
use NetworkRailBusinessSystems\Common\Jobs\CleanupTempStorage;
use NetworkRailBusinessSystems\Common\Jobs\StripStaleUsers;
use NetworkRailBusinessSystems\Common\Jobs\WarnStaleUsers;

class CommonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'common');
        $this->setupOverrides();
    }

    public function boot(): void
    {
        $this->setupBaseUrlRedirect();
        $this->setupCommands();
        $this->setupConfig();
        $this->setupHttps();
        $this->setupJobs();
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

    public function setupJobs(): void
    {
        Schedule::job(new WarnStaleUsers())
            ->daily()
            ->name('warn_stale_users')
            ->onOneServer();

        Schedule::job(new StripStaleUsers())
            ->daily()
            ->name('strip_stale_users')
            ->onOneServer();

        Schedule::job(new CleanupFailedJobs(168))
            ->weekly()
            ->name('cleanup_failed_jobs')
            ->onOneServer();

        Schedule::job(new CleanupTempStorage())
            ->daily()
            ->name('cleanup_temp_storage')
            ->onOneServer();
    }

    public function setupModels(): void
    {
        Schema::defaultStringLength(191);
        Model::shouldBeStrict(App::isProduction() === false);
    }

    public function setupOverrides(): void
    {
        $loader = AliasLoader::getInstance();

        $loader->alias(
            'GuzzleHttp\Handler\CurlVersion',
            'NetworkRailBusinessSystems\Common\Overrides\CurlVersion',
        );
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
            Route::supportPage();

            Route::prefix('/favicons')
                ->name('favicons.')
                ->controller(FaviconController::class)
                ->group(function () {
                    Route::get('/ico', 'ico')->name('ico');

                    Route::prefix('/png')
                        ->name('png.')
                        ->group(function () {
                            Route::get('/16', 'png16')->name('16');
                            Route::get('/32', 'png32')->name('32');
                            Route::get('/48', 'png48')->name('48');
                            Route::get('/64', 'png64')->name('64');
                        });
                });

            Route::prefix('/privacy')
                ->controller(PrivacyController::class)
                ->group(function () {
                    Route::get('/', 'show')->name('privacy');
                });

            Route::prefix('/logos')
                ->name('logos.')
                ->controller(LogoController::class)
                ->group(function () {
                    Route::get('/header', 'header')->name('header');
                    Route::get('/footer', 'footer')->name('footer');
                });

            Route::middleware('EntraAuthenticated')->group(function () {
                Route::prefix('/admin')
                    ->name('admin.')
                    ->controller(config('common.controllers.admin'))
                    ->group(function () {
                        Route::get('/', 'index')->name('index');

                        Route::supportPageAdmin();

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

        config()->prepend('view.paths', $path);
    }
}
