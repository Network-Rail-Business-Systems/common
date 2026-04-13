![Composer status](.github/composer.svg)
![Coverage status](.github/coverage.svg)
![Laravel version](.github/laravel.svg)
![NPM status](.github/npm.svg)
![PHP version](.github/php.svg)
![Tests status](.github/tests.svg)

# Common

Provides common functionality for Network Rail Business Systems Laravel systems.

## What's in the box?

* Laravel 12 bootstrapping logic, such as HTTPS forced on for select servers
* CSV helpers for importing and exporting CSVs

## Installation

### Composer

You can install this library using Composer:

```bash
composer require networkrailbusinesssystems/common
```

### Service Provider

The Common service provider will be automatically registered.

If you need to manually load it, you can add the following to your `config/app.php` file:

```php
'providers' => [
    // ...
    NetworkRailBusinessSystems\Common\CommonServiceProvider::class,
],
```

### Publish files

The following can be published using `php artisan vendor:publish`:

| Key           | Usage                          | Target                        |
|---------------|--------------------------------|-------------------------------|
| common-config | The Common configuration file  | config/common.php             |
| common-views  | Views provided by this library | resources/views/vendor/common |

### Routes

Add the common routes to your system using the `Route::common()` macro.

## Configuration

The `config/common.php` file contains the following options:

| Key         | Usage                                                    | Type   | Default                    |
|-------------|----------------------------------------------------------|--------|----------------------------|
| controllers | Which controllers to use within common functions         | array  | role, user                 |
| enums       | Which enums to use within common functions               | array  | permissions, roles         |
| force_https | Whether to force HTTPS on regardless of the hostname     | string | false                      |
| home        | The base resource to redirect to from the root directory | string | /home                      |
| models      | Which models to use within common functions              | array  | permission, role, user     |
| permissions | Which Permissions to use within common functions         | array  | access_admin, manage_users |
| policies    | Which policies to use within common functions            | array  | user                       |
| template    | Which template group to use for views                    | string | govuk                      |

Where possible a default implementations has been provided for controllers, enums, models, and policies.

You can set or override each implementation by providing the fully qualified name of the new implementation.

### Enums

You must create enums for Roles and Permissions.

Each must implement the `RoleInterface` and `PermissionInterface` respectively.

A `RoleTrait` and `PermissionTrait` are provided for a standard implementation.

#### Permissions

You should add the following Permissions to your enum as a minimum:

* Permission::AccessAdmin
* Permission::ManageUsers

### Models

You must implement your own User model.

An abstract `User` model is provided for you to extend.

## Usage

The components provided by this library should be used in the following ways:

* Called via a provided route
* Called directly
* Extended

### Extending and overriding functionality

Before extending any of the components, consider whether the functionality you want to add is system specific, or something you could contribute into common.

The ideal is to keep all common system elements in this library to avoid duplication and reduce maintenance.

Where your functionality is system specific, such as a model relationship, ensure you extend the model from this library.

## CSVs

Use the `Csv` helper to import and export CSVs.

### Import

Utilise the `import` helper to validate the headers and rows of a CSV:

```php
$uploadedFile = $formRequest->file('uploaded-file');

$expectedHeaders = ['name'];

$rules = [
    'name' => ['required'],
];

$messages = [
    'name.*' => ['A name is required'],
];

/** @var SimpleExcelReader|array $csv */
$csv = Csv::import($uploadedFile, $expectedHeaders, $rules, $messages);
```

If the validation passes you will receive the `SimpleExcelReader` instance, where you can further process the rows.

If the validation fails you will receive an `array` of error messages.

### Export

Utilise the `export` helper to quickly output a CSV of array entries:

```php
$data = [...$someData];

/** @returns BinaryFileResponse */
return Csv::export('my-file', $data);
```

The helper will automatically lowercase and snake-case the filename.

If will also prepend the date, unless you set the `prefixDate` parameter to false.

You may select the disk to be used for the temporary file using the `disk` parameter.

If the provided dataset is empty the CSV will not be created.

Instead, an `HttpResponseException` will be thrown and a message flashed to inform the user.

Ensure that the `rows` passed into `export` can be turned into a flat array per row, otherwise it may fail.

## HasFormatters

The `HasFormatters` trait is provided for consistent formatting of values in common formats.

| Method           | Type             | Output                                           |
|------------------|------------------|--------------------------------------------------|
| formatCount()    | array\|Arrayable | String with count before plural or singular term | 
| formatCurrency() | float\|int       | String in £0.00 format                           |
| formatDate()     | Carbon           | String in d/m/Y H:i format                       |
| formatPrefix()   | string\|int      | String with prefix added before value            |
| formatSuffix()   | string\|int      | String with suffix added after value             |
| formatText()     | string           | String with `\n` converted to `<br/>`            |

Each method has additional parameters to customise its behaviour.

They also handle "blank" values, returning either `null` or a defined value of your choice.

## ImprovedHasAttribute

By default, Laravel only checks `$attributes` and `$casts` on a `Model` for attribute existence.

This causes an exception to be thrown when using strict models, even though the attribute name is correct.

Adding `use ImprovedHasAttribute` to a model adds `$fillable` and `$guarded` to the check to avoid this.

## Help and support

You are welcome to raise any issues or questions on GitHub.

If you wish to contribute to this library, raise an issue before submitting a forked pull request.

## Licence

Published under the MIT licence.
