# kenda-communication-plugin

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ahmedsalah/kenda-communication-plugin.svg?style=flat-square)](https://packagist.org/packages/ahmedsalah/kenda-communication-plugin)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ahmedsalah/kenda-communication-plugin/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ahmedsalah/kenda-communication-plugin/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/ahmedsalah/kenda-communication-plugin/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ahmedsalah/kenda-communication-plugin/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ahmedsalah/kenda-communication-plugin.svg?style=flat-square)](https://packagist.org/packages/ahmedsalah/kenda-communication-plugin)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.


## Installation

You can install the package via composer:

```bash
composer require ahmedsalah/kenda-communication-plugin
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="kenda-communication-plugin-migrations"
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="kenda-communication-plugin-config"
```

This is the contents of the published config file:

```php
return [

    /* -------------------------------------------------------------------------- */
    /*                                User Resolving */
    /* -------------------------------------------------------------------------- */
    'enable_user_resolving' => true,

    'user_model' => 'App\Models\User',
    'user_phone_number_column' => 'phone_number',

    /* -------------------------------------------------------------------------- */
    /*                                Function calls */
    /* -------------------------------------------------------------------------- */

    'functions' => [
        'example_function' => 'App\KendaCommunicationPlugin\Functions\ExampleFunction',
    ],

];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="kenda-communication-plugin-views"
```

## Usage

```php
$kendaCommunicationPlugin = new Kenda\KendaCommunicationPlugin();
echo $kendaCommunicationPlugin->echoPhrase('Hello, Kenda!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Ahmed Salah](https://github.com/ahmedsalah)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
