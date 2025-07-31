# XOT Module

Core functionality and base classes for the application.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [API Reference](#api-reference)
- [Contributing](#contributing)
- [License](#license)

## Overview
XOT (eXtensible Object Toolkit) is the core module that provides foundational functionality used by all other modules.

## Features
- Base classes for Filament resources
- Core services and utilities
- Common interfaces and traits
- Base models and controllers

## Installation
```bash
composer require modules/xot
```

## Configuration
Add the service provider to `config/app.php`:

```php
'providers' => [
    // ...
    Modules\Xot\Providers\XotServiceProvider::class,
],
```

## Usage
### Base Classes
- `XotBaseModel`: Base model class
- `XotBaseController`: Base controller
- `XotBaseResource`: Base Filament resource

## API Reference
See [API Documentation](api.md) for detailed class and method references.

## Contributing
Please see [CONTRIBUTING.md](contributing.md) for details.

## License
This module is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
