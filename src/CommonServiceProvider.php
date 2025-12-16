<?php

namespace NetworkRailBusinessSystems\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'common');
    }

    public function boot(): void
    {
        $this->bootPublishes();
        $this->redirectsBaseUrl();
        $this->configureModels();
        $this->checkHttps();
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('common.php'),
        ], 'config');
    }

    public function redirectsBaseUrl(): void
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

    public function configureModels(): void
    {
        Schema::defaultStringLength(191);
        Model::shouldBeStrict(App::environment() !== 'production');
    }

    public function checkHttps(): void
    {
        $this->checkNamespace();

//        $startTime = microtime(true);
//
//        for ($i = 0; $i < 1e6; $i++) {
//            $this->checkNamespace();
//        }
//
//        $endTime = microtime(true);
//        $duration = $endTime - $startTime;

        //dd('Took: ' . $duration . ' seconds' . PHP_EOL);
    }

    private function checkNamespace(): void
    {
        $serverName = Request::host();
        // 3.9s for 1e6 times
        if (
            in_array($serverName, [
                'systems.networkrail.co.uk',
                'systems.hiav.networkrail.co.uk',
                'systems3.networkrail.co.uk',
                'systems3.hiav.networkrail.co.uk',
                'systems4.networkrail.co.uk',
                'systems4.hiav.networkrail.co.uk',
                'systems5.networkrail.co.uk',
                'systems5.hiav.networkrail.co.uk',
            ])
        ) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }

        $namespaces = ['systems.', 'systems2.', 'systems4.', 'systems5.'];

        // 7.1s for 1e6 times
        //        if (
        //             array_any(
        //                 $namespaces,
        //                 function (string $namespace) use ($serverName) {
        //                     return str_starts_with($serverName, $namespace);
        //                 }
        //             )
        //        ) {
        //            URL::forceScheme('https');
        //            $this->app['request']->server->set('HTTPS', 'on');
        //        }

        // 4.45s for 1e6 times
        //        foreach ($namespaces as $namespace) {
        //            if (str_starts_with($serverName, $namespace)) {
        //                URL::forceScheme('https');
        //                $this->app['request']->server->set('HTTPS', 'on');
        //                break;
        //            }
        //        }
    }
}
