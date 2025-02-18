# Kenda Communication Plugin

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ahmedsalah/kenda-communication-plugin.svg?style=flat-square)](https://packagist.org/packages/ahmedsalah/kenda-communication-plugin)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ahmedsalah/kenda-communication-plugin/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ahmedsalah/kenda-communication-plugin/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/ahmedsalah/kenda-communication-plugin/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ahmedsalah/kenda-communication-plugin/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ahmedsalah/kenda-communication-plugin.svg?style=flat-square)](https://packagist.org/packages/ahmedsalah/kenda-communication-plugin)

## Overview

The **Kenda Communication Plugin** is a Laravel package designed to facilitate communication between your Laravel
application and WhatsApp services. It provides a structured way to register devices, websites, and functions, ensuring
secure and seamless integration with remote servers.

## Installation

You can install the package via Composer:

```bash
composer require ahmedsalah/kenda-communication-plugin
```

### Configuration

Publish the configuration file using the following command:

```bash
php artisan vendor:publish --tag="kenda-communication-plugin-config"
```

This will create a configuration file containing:

```php
return [
    'public_key_path' => env('KENDA_COMMUNICATION_PLUGIN_PUBLIC_KEY_PATH', 'public_key_server.kendaKey'),

    'enable_user_resolving' => env('KENDA_COMMUNICATION_PLUGIN_ENABLE_USER_RESOLVING', true),
    'enable_guest_user' => env('KENDA_COMMUNICATION_PLUGIN_ENABLE_GUEST_USER', true),

    'user_model' => env('KENDA_COMMUNICATION_PLUGIN_USER_MODEL', 'App\Models\User'),
    'user_phone_number_column' => env('KENDA_COMMUNICATION_PLUGIN_USER_PHONE_NUMBER_COLUMN', 'phone_number'),

    'functions' => [
        'example_function' => 'App\KendaCommunicationPlugin\Functions\ExampleFunction',
    ],
];
```

## Usage

### 1. Register a New Device

To begin, you must register a WhatsApp number (Device) with the server.

### 2. Register Your Website

Once the device is registered, register your website on the server. This allows your website to communicate with the API
and receive user requests.

### 3. Register Your Functions

Functions must be registered on the server to allow your Laravel application to execute them remotely.

### 4. Map Local Functions to Remote Server Functions

Each registered function must be mapped to a local function in your Laravel application.

Generate a function file:

```bash
php artisan kenda:generate-function
```

Then, map the function in the config file:
```php
return [
    'functions' => [
        'createUser' => 'App\KendaCommunicationPlugin\Functions\CreateUser',
        'writeArticle' => 'App\KendaCommunicationPlugin\Functions\WriteArticle',
    ],
];
```

## Additional Features

### Sending WhatsApp Messages

You can send WhatsApp messages directly to users using the following function:

```php
KendaCommunicationPlugin::sendWhatsappMessage(string $targetPhone, string $message);
```

This feature is useful for notifications and reminders. However, avoid excessive messaging to prevent getting blocked by
WhatsApp.

## Testing

Run the test suite using:
```bash
composer test
```

## Changelog

Refer to the [CHANGELOG](CHANGELOG.md) for a record of recent changes.

## Credits
- [Ahmed Salah](https://github.com/ahmedsalah)
- [All Contributors](../../contributors)

## License

This package is open-source under the MIT License. See [LICENSE](LICENSE.md) for details.

