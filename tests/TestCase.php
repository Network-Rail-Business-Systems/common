<?php

namespace NetworkRailBusinessSystems\Common\Tests;

use AnthonyEdmonds\LaravelFind\FinderServiceProvider;
use AnthonyEdmonds\LaravelFormBuilder\Traits\AssertsForms;
use AnthonyEdmonds\LaravelTestingTraits\AssertsActivities;
use AnthonyEdmonds\LaravelTestingTraits\AssertsFlashMessages;
use AnthonyEdmonds\LaravelTestingTraits\AssertsOrder;
use AnthonyEdmonds\LaravelTestingTraits\AssertsPolicies;
use AnthonyEdmonds\LaravelTestingTraits\AssertsResults;
use AnthonyEdmonds\LaravelTestingTraits\AssertsValidationRules;
use AnthonyEdmonds\LaravelTestingTraits\AssertsViews;
use AnthonyEdmonds\LaravelTestingTraits\GetsRawCsvs;
use AnthonyEdmonds\LaravelTestingTraits\SignsInUsers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\FlashServiceProvider;
use NetworkRailBusinessSystems\ActivityLog\ActivityLogServiceProvider;
use NetworkRailBusinessSystems\Common\CommonServiceProvider;
use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Entra\Traits\AssertsEntra;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\Permission\PermissionServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use AssertsFlashMessages;
    use GetsRawCsvs;
    use SignsInUsers;
    use AssertsResults;
    use AssertsPolicies;
    use AssertsOrder;
    use AssertsActivities;
    use AssertsViews;
    use AssertsForms;
    use AssertsEntra;
    use AssertsValidationRules;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('common.enums.permissions', Permission::class);
        config()->set('common.enums.roles', Role::class);
        config()->set('common.permissions.access_admin', Permission::AccessAdmin);
        config()->set('common.permissions.impersonate', Permission::Impersonate);
        config()->set('common.permissions.manage_users', Permission::ManageUsers);
        config()->set('common.template', 'bulma');
        config()->set('common.models.user', User::class);

        config()->set('activitylog.default_auth_driver', null);
        config()->set('activitylog.default_log_name', 'default');

        config()->set('app.acronym', 'CMN');

        config()->set('entra.sync_attributes', [
            'displayName' => 'name',
            'givenName' => 'first_name',
            'id' => 'azure_id',
            'mail' => 'email',
            'surname' => 'last_name',
        ]);
        config()->set('entra.user_model', User::class);
        config()->set('entra.emulator.users', [
            [
                'businessPhones' => '01234567890',
                'displayName' => 'Gandalf Stormcrow',
                'givenName' => 'Gandalf',
                'id' => '123ab4c5-6789-01de-f2g3-45678hijk9lm',
                'jobTitle' => 'Wizard',
                'mail' => 'gandalf.stormcrow@networkrail.co.uk',
                'mobilePhone' => '01234567890',
                'officeLocation' => 'Minas Tirith',
                'surname' => 'Stormcrow',
                'userPrincipalName' => 'gandalf@networkrail.co.uk',
            ],
        ]);

        config()->set('laravel-impersonate.session_key', 'impersonated_by');
        config()->set('laravel-impersonate.session_guard', 'impersonator_guard');
        config()->set('laravel-impersonate.session_guard_using', 'impersonator_guard_using');
        config()->set('laravel-impersonate.default_impersonator_guard', 'web');

        config()->set('testing-traits.user_model', User::class);

        $this->withoutVite();
        View::replaceNamespace('common', __DIR__ . '/../src/Views/bulma');

        $router = app('router');
        $router->common();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActivityLogServiceProvider::class,
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
