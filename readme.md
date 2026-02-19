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

| Key    | Usage                         | Target                            |
|--------|-------------------------------|-----------------------------------|
| common | The Common configuration file | config/common.php                 |

## Configuration

The `config/common.php` file contains the following options:

| Key  | Usage                                                    | Type   | Default |
|------|----------------------------------------------------------|--------|---------|
| home | The base resource to redirect to from the root directory | string | /home   |

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

## Help and support

You are welcome to raise any issues or questions on GitHub.

If you wish to contribute to this library, raise an issue before submitting a forked pull request.

## Licence

Published under the MIT licence.
