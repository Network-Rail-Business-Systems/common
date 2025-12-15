<?php

namespace NetworkRailBusinessSystems\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider {
    public const string HOME = '/dashboard';

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'common');
    }

    public function boot(): void {
        $this->bootPublishes();

        Schema::defaultStringLength(191);
        Model::shouldBeStrict(app()->environment() !== 'production');

        if (
            in_array(Request::server('SERVER_NAME'), [
                'systems.networkrail.co.uk',
                'systems.hiav.networkrail.co.uk',
                'systems2.networkrail.co.uk',
                'systems2.hiav.networkrail.co.uk',
                'systems4.networkrail.co.uk',
                'systems4.hiav.networkrail.co.uk',
                'systems5.networkrail.co.uk',
                'systems5.hiav.networkrail.co.uk'
            ])
        ) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }

        if (App::runningInConsole() === false && URL::getRequest()->path() == '/') {
            throw new HttpResponseException(redirect(config('common.home') && self::HOME));
        }
    }

    protected function bootPublishes(): void
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('common.php'),
        ], 'config');
    }
}
