# User Module

User management and authentication system.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Authentication](#authentication)
  - [Authorization](#authorization)
  - [Profiles](#profiles)
  - [Roles & Permissions](#roles--permissions)
- [API Reference](#api-reference)
- [Contributing](#contributing)
- [License](#license)

## Overview
The User module provides a complete user management system with authentication, authorization, and profile management. It integrates with Laravel's built-in authentication system and extends it with additional features.

## Features
- User registration and authentication
- Email verification
- Password reset
- Role-based access control (RBAC)
- Profile management
- Social authentication
- Two-factor authentication (2FA)

## Installation
```bash
composer require modules/user
```

Publish assets and run migrations:
```bash
php artisan vendor:publish --tag=user-assets
php artisan migrate
```

## Configuration
Add the service provider to `config/app.php`:

```php
'providers' => [
    // ...
    Modules\User\Providers\UserServiceProvider::class,
],
```

## Usage

### Authentication
The module provides ready-to-use authentication controllers and views:
- Login/Logout
- Registration
- Password reset
- Email verification

### Authorization
Manage user access using roles and permissions:
- Create/Edit roles
- Assign permissions to roles
- Assign roles to users

### Profiles
Users can manage their profiles with:
- Personal information
- Avatar upload
- Password change
- Two-factor authentication setup

### Roles & Permissions
- Define granular permissions
- Group permissions into roles
- Assign multiple roles to users

## API Reference
See [API Documentation](api.md) for detailed class and method references.

## Contributing
Please see [CONTRIBUTING.md](contributing.md) for details.

## License
This module is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
