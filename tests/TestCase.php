<?php

namespace NetworkRailBusinessSystems\Common\Tests;

use AnthonyEdmonds\LaravelFind\FinderServiceProvider;
use AnthonyEdmonds\LaravelTestingTraits\AssertsFlashMessages;
use AnthonyEdmonds\LaravelTestingTraits\GetsRawCsvs;
use AnthonyEdmonds\LaravelTestingTraits\SignsInUsers;
use Illuminate\Support\Facades\Artisan;
use Laracasts\Flash\FlashServiceProvider;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\Permission\PermissionServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use AssertsFlashMessages;
    use GetsRawCsvs;
    use SignsInUsers;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('testing-traits.user_model', User::class);
        config()->set('laravel-impersonate.session_key', 'impersonated_by');
        config()->set('laravel-impersonate.session_guard', 'impersonator_guard');
        config()->set('laravel-impersonate.session_guard_using', 'impersonator_guard_using');
        config()->set('laravel-impersonate.default_impersonator_guard', 'web');

        $this->withoutVite();
    }

    protected function getPackageProviders($app): array
    {
        return [
            CommonServiceProvider::class,
            FinderServiceProvider::class,
            FlashServiceProvider::class,
            PermissionServiceProvider::class,
        ];
    }

    protected function useDatabase(): void
    {
        $this->app->useDatabasePath(__DIR__ . '/Database');
        $this->runLaravelMigrations();
    }

    protected function usePermissions(): void
    {
        Artisan::call('update:permissions --no-interaction');
    }
}
