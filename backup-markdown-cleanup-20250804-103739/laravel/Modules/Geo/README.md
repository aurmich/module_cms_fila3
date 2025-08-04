# :package_description
# Geo Module

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laraxot/module_geo_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_geo_fila3)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/laraxot/module_geo_fila3/run-tests?label=tests)](https://github.com/laraxot/module_geo_fila3/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/laraxot/module_geo_fila3/Check%20&%20fix%20styling?label=code%20style)](https://github.com/laraxot/module_geo_fila3/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laraxot/module_geo_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_geo_fila3)
<!--delete-->
---
This repo can be used to scaffold a Laravel package. Follow these steps to get started:

1. Press the "Use template" button at the top of this repo to create a new repo with the contents of this skeleton.
2. Run "php ./configure.php" to run a script that will replace all placeholders throughout all the files.
3. Have fun creating your package.
4. If you need help creating a package, consider picking up our <a href="https://laravelpackage.training">Laravel Package Training</a> video course.
---
<!--/delete-->
This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/:package_name.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/:package_name)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require laraxot/module_geo_fila3
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="module_geo_fila3-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="module_geo_fila3-config"
```

This is the contents of the published config file:

## Overview

The Geo module is a central repository for all geographical data and functionality within the application. It provides a consistent way to manage locations, addresses, and geographical hierarchies across all modules.

## Features

- **Geographical Hierarchy Management**: Handle regions, provinces, cities, and postal codes (CAPs)
- **Address Management**: Store and manage complete address information
- **Reusable Address Components**: AddressesField component for DRY address management
- **Location Services**: Work with geographical coordinates and points of interest
- **Data Consistency**: Single source of truth for all geographical data
- **API Ready**: Easily expose geographical data through APIs

## Installation

1. Install the package via Composer:

   ```bash
   composer require laraxot/module_geo_fila3
   ```

2. Publish and run the migrations:

   ```bash
   php artisan vendor:publish --tag="module_geo_fila3-migrations"
   php artisan migrate
   ```

3. (Optional) Publish the configuration file:

   ```bash
   php artisan vendor:publish --tag="module_geo_fila3-config"
   ```

## Usage

### Basic Usage

```php
use Modules\Geo\Models\Region;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\City;
use Modules\Geo\Models\Cap;

// Get all regions with their provinces
$regions = Region::with('provinces')->get();

// Get all cities in a province
$province = Province::find(1);
$cities = $province->cities;

// Get CAPs for a city
$city = City::find(1);
$caps = $city->caps;
```

### AddressesField Component

The Geo module provides a reusable `AddressesField` component for managing multiple addresses in Filament forms:

```php
use Modules\Geo\Filament\Forms\Components\AddressesField;

// Basic usage in a Filament Resource
AddressesField::make('addresses')
    ->relationship('addresses')
    ->minItems(1)
    ->addActionLabel('Add Address')
    ->columnSpanFull()

// Advanced configuration
AddressesField::make('addresses')
    ->relationship('addresses')
    ->minItems(1)
    ->maxItems(5)
    ->reorderable(true)
    ->managePrimary(true)
    ->addActionLabel('Add Location')
```

**Features:**
- **Multiple Addresses**: Manage collections of addresses with repeater
- **Conditional Visibility**: Name field appears only with multiple addresses
- **Primary Address Logic**: Automatic exclusive primary address management
- **Complete Italian Schema**: Full cascade selection (Region → Province → City → CAP)
- **Configurable**: Flexible API for different use cases
```

### Relationships

- **Region** has many **Provinces**
- **Province** belongs to a **Region** and has many **Cities**
- **City** belongs to a **Province** and has many **CAPs**
- **Cap** belongs to a **City**

## Documentation

For detailed documentation, please see the [documentation](docs/architecture.md).

## Migration Guide

If you're migrating from another module (like SaluteOra) that had its own geographical models, please see the [migration guide](docs/migration-guide.md).

## Module Configuration

The default configuration is as follows:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="module_geo_fila3-views"
```

## Usage

```php
$variable = new VendorName\Skeleton();
echo $variable->echoPhrase('Hello, VendorName!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [:author_name](https://github.com/:author_username)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
