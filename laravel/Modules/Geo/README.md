# Geo Module

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laraxot/module_geo_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_geo_fila3)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/laraxot/module_geo_fila3/run-tests?label=tests)](https://github.com/laraxot/module_geo_fila3/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/laraxot/module_geo_fila3/Check%20&%20fix%20styling?label=code%20style)](https://github.com/laraxot/module_geo_fila3/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laraxot/module_geo_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_geo_fila3)

## Overview

The Geo module is a central repository for all geographical data and functionality within the application. It provides a consistent way to manage locations, addresses, and geographical hierarchies across all modules.

## Features

- **Geographical Hierarchy Management**: Handle regions, provinces, cities, and postal codes (CAPs)
- **Address Management**: Store and manage complete address information
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
