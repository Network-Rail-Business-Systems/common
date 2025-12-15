![Composer status](.github/composer.svg)
![Coverage status](.github/coverage.svg)
![Laravel version](.github/laravel.svg)
![NPM status](.github/npm.svg)
![PHP version](.github/php.svg)
![Tests status](.github/tests.svg)

# Common

Provides common functionality for Network Rail Business Systems Laravel systems.

## What's in the box?

* Laravel 12 bootstrapping logic, i.e. HTTPS forced on for select servers.

## Installation

### Composer

You can install this library using Composer:

```bash
composer require network-rail-business-systems/common
```

### Service Provider

The Form Builder service provider will be automatically registered.

If you need to manually load it, you can add the following to your `config/app.php` file:

```php
'providers' => [
    // ...
    NetworkRailBusinessSystems\Common\CommonServiceProvider::class,
],
```

### Publish files

The following can be published using `php artisan vendor:publish`:

| Key    | Usage                                  | Target                            |
|--------|----------------------------------------|-----------------------------------|
| common | The Form Builder configuration file    | config/common.php                 |

## Configuration

The `config/common.php` file contains the following options:

| Key  | Usage                                                    | Type   | Default    |
|------|----------------------------------------------------------|--------|------------|
| home | The base resource to redirect to from the root directory | string | /dashboard |

## Structure

TODO

## Help and support

You are welcome to raise any issues or questions on GitHub.

If you wish to contribute to this library, raise an issue before submitting a forked pull request.

## Licence

Published under the MIT licence.
