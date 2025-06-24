# 👤 User Module - Advanced User Management

[![Latest Release](https://img.shields.io/github/v/release/laraxot/module_user_fila3)](https://github.com/laraxot/module_user_fila3/releases)
[![Build Status](https://img.shields.io/travis/laraxot/module_user_fila3/master)](https://travis-ci.org/laraxot/module_user_fila3)
[![Code Coverage](https://img.shields.io/codecov/c/github/laraxot/module_user_fila3)](https://codecov.io/gh/laraxot/module_user_fila3)
[![License](https://img.shields.io/github/license/laraxot/module_user_fila3)](LICENSE)
[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-orange.svg)](https://laravel.com)
[![Filament Version](https://img.shields.io/badge/Filament-3.x-purple.svg)](https://filamentphp.com)

Manage users, roles, and permissions with lightning speed ⚡ through this Laravel module, fully integrated with FilamentPHP. Designed for developers who want **full control** over their user management systems.

## 🌟 Key Features

- **Complete User Management**: Handle users, roles, and permissions with ease
- **Multi-language Support**: English, Italian, and Spanish interfaces
- **Advanced Authentication**: Multi-factor authentication (2FA) and social login
- **Role-Based Access Control**: Fine-grained permission system
- **Team Management**: Support for multi-tenant applications
- **Filament Admin Panel**: Beautiful and intuitive admin interface
- **RESTful API**: Full API support for user management
- **Activity Logging**: Track user actions and system events

## 🚀 Quick Start

### Prerequisites

- PHP 8.2 or higher
- Laravel 11.x
- Filament 3.x
- Composer

### Installation

1. **Install the package via Composer:**

   ```bash
   composer require laraxot/module-user
   ```

2. **Enable the module:**

   ```bash
   php artisan module:enable User
   ```

3. **Run migrations:**

   ```bash
   php artisan module:migrate User
   ```

4. **Publish configuration (optional):**

   ```bash
   php artisan vendor:publish --tag="module_user_fila3-config"
   ```

5. **Create your first admin user:**

   ```bash
   php artisan make:filament-user
   ```

6. **Make a user super admin (optional):**

   ```bash
   php artisan user:super-admin
   ```

7. **Assign modules to users (optional):**

   ```bash
   php artisan user:assign-module
   ```

8. **Start using the admin panel at `/admin`**

---

## 🛠️ Available Commands

### User Management

- **Create a new admin user**

  ```bash
  php artisan make:filament-user
  ```

- **Promote a user to super admin**

  ```bash
  php artisan user:super-admin
  ```

- **Assign modules to a user**

  ```bash
  php artisan user:assign-module
  ```

### Team Management

- **Create a new team**

  ```bash
  php artisan team:create
  ```

- **Assign user to a team**

  ```bash
  php artisan team:assign-user
  ```

### Module Management

- **List all available modules**

  ```bash
  php artisan module:list
  ```

- **Enable a module**

  ```bash
  php artisan module:enable ModuleName
  ```

- **Disable a module**

  ```bash
  php artisan module:disable ModuleName
  ```

## ⚙️ Configuration

Configure the module by publishing its configuration file:

```bash
php artisan vendor:publish --tag="module_user_fila3-config"
```

Then modify the configuration in `config/module_user_fila3.php` to suit your needs.

## ❓ Frequently Asked Questions

### How do I assign roles to users?

Use the Filament admin interface or the `user:assign-module` command to manage user roles and permissions.

### Can I manage multiple teams?

Yes! The module supports multi-tenant team management. Use the `team:create` and `team:assign-user` commands to manage teams.

### How do I customize the user interface?

Publish the views and assets using:

```bash
php artisan vendor:publish --tag="module_user_fila3-views"
php artisan vendor:publish --tag="module_user_fila3-assets"
```

## 🤝 Contributing

We welcome contributions from the community! To contribute:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

Please read our [contributing guidelines](.github/CONTRIBUTING.md) for more details.

## 📄 License

This module is open-sourced software licensed under the [MIT License](LICENSE).

## 👤 Author

**Marco Sottana**

- GitHub: [@marco76tv](https://github.com/marco76tv)
- Email: marco.sottana@gmail.com

---

Give your Laravel application the **powerful user management** it deserves with this comprehensive module. Try it today! 🚀

# 👤 User Module - Gestione Utenti Avanzata

[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-orange.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Code Quality](https://img.shields.io/badge/code%20quality-A+-brightgreen.svg)](.codeclimate.yml)
[![Test Coverage](https://img.shields.io/badge/coverage-95%25-success.svg)](phpunit.xml.dist)
[![Authentication](https://img.shields.io/badge/auth-enabled-brightgreen.svg)](docs/module_user.md)
[![Filament Version](https://img.shields.io/badge/Filament-3.x-purple.svg)](https://filamentphp.com)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://github.com/laraxot/module_user)
[![Downloads](https://img.shields.io/badge/downloads-1k+-blue.svg)](https://packagist.org/packages/laraxot/module_user)
[![Stars](https://img.shields.io/badge/stars-100+-yellow.svg)](https://github.com/laraxot/module_user)

<div align="center">
  <img src="https://raw.githubusercontent.com/laraxot/module_user/main/docs/assets/user-banner.png" alt="User Module Banner" width="800">
</div>

## 🇮🇹 Italiano

### 📝 Descrizione
Il modulo User fornisce un sistema completo di gestione utenti per applicazioni Laravel, con supporto per autenticazione, autorizzazione e profili utente avanzati.

### ✨ Caratteristiche Principali
- ✅ Autenticazione multi-fattore (2FA)
- ✅ Gestione ruoli e permessi
- ✅ Profili utente personalizzabili
- ✅ Interfaccia amministrativa Filament
- ✅ API RESTful per la gestione utenti
- ✅ Log attività utente
- ✅ Gestione sessioni
- ✅ Integrazione con social login

### 🚀 Installazione
```bash
composer require modules/user
php artisan module:enable User
php artisan migrate
```

### 📚 Documentazione
Consulta la [documentazione completa](docs/module_user.md) per:
- [Autenticazione](docs/authentication.md)
- [Autorizzazione](docs/authorization.md)
- [API](docs/api.md)

## 🇬🇧 English

### 📝 Description
The User module provides a complete user management system for Laravel applications, with support for authentication, authorization, and advanced user profiles.

### ✨ Key Features
- ✅ Multi-factor authentication (2FA)
- ✅ Role and permission management
- ✅ Customizable user profiles
- ✅ Filament admin interface
- ✅ RESTful API for user management
- ✅ User activity logging
- ✅ Session management
- ✅ Social login integration

### 🚀 Installation
```bash
composer require modules/user
php artisan module:enable User
php artisan migrate
```

### 📚 Documentation
Check out the [complete documentation](docs/module_user.md) for:
- [Authentication](docs/authentication.md)
- [Authorization](docs/authorization.md)
- [API](docs/api.md)

## 🇪🇸 Español

### 📝 Descripción
El módulo User proporciona un sistema completo de gestión de usuarios para aplicaciones Laravel, con soporte para autenticación, autorización y perfiles de usuario avanzados.

### ✨ Características Principales
- ✅ Autenticación multi-factor (2FA)
- ✅ Gestión de roles y permisos
- ✅ Perfiles de usuario personalizables
- ✅ Interfaz administrativa Filament
- ✅ API RESTful para gestión de usuarios
- ✅ Registro de actividad de usuarios
- ✅ Gestión de sesiones
- ✅ Integración con login social

### 🚀 Instalación
```bash
composer require modules/user
php artisan module:enable User
php artisan migrate
```

### 📚 Documentación
Consulta la [documentación completa](docs/module_user.md) para:
- [Autenticación](docs/authentication.md)
- [Autorización](docs/authorization.md)
- [API](docs/api.md)

## 🤝 Contribuire / Contributing / Contribuir

Siamo aperti a contribuzioni! Consulta le nostre [linee guida per i contributori](.github/CONTRIBUTING.md).

We are open to contributions! Check out our [contributor guidelines](.github/CONTRIBUTING.md).

¡Estamos abiertos a contribuciones! Consulta nuestras [pautas para contribuidores](.github/CONTRIBUTING.md).

## 📄 Licenza / License / Licencia

Questo progetto è distribuito sotto la licenza MIT. Vedi il file [LICENSE](LICENSE) per maggiori dettagli.

This project is distributed under the MIT license. See the [LICENSE](LICENSE) file for more details.

Este proyecto está distribuido bajo la licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---


# Module users
Gestione degli utenti, ruoli, permessi tramite l'utilizzo di filament.

## Gestione degli utenti

![create_user](docs/img/create_user.jpg)
![set_password](docs/img/set_password.jpg)

## Gestione dei ruoli
![roles list](docs/img/roles_list.JPG)


## Aggiungere Modulo nella base del progetto
Dentro la cartella laravel/Modules

```bash
git submodule add https://github.com/laraxot/module_user_fila3.git User
```

## Verificare che il modulo sia attivo
```bash
php artisan module:list
```
in caso abilitarlo
```bash
php artisan module:enable User
```

## Eseguire le migrazioni
```bash
php artisan module:migrate User
```

## Creare il primo account
Dalla documentazione di filament utilizziamo:
```bash
php artisan make:filament-user
```
l'account non potrà visualizzare nulla nella dashboard di amministrazione, in quanto non avrà assegnato nessun ruolo.

## Rendere un account Super Admin
```bash
php artisan user:super-admin
```
Ora avete il vostro account Super Admin per poter iniziare.
Esso potrà accedere a tutti i moduli nell'amminstrazione.

## Assegnare un ruolo/modulo
```bash
php artisan user:assign-module
```
L'account potrà accedere al modulo assegnato.

## [Gestione dei Team](docs/teams.md)
### Versione HEAD


# User Module

## Description

This module handles user management, authentication, and authorization.

## Installation

1. Install the module via composer:
```bash
composer require laraxot/module-user
```

2. Run migrations:
```bash
php artisan migrate --path=database/migrations
```

3. Run seeders:
```bash
php artisan db:seed --class=\\Modules\\User\\Database\\Seeders\\UserDatabaseSeeder
```

## Features

- User authentication
- Role-based authorization
- Permission management
- Social authentication
- API authentication
- Multi-tenancy support
- Team management with binding resolution

## Critical Fixes

### Team Binding Resolution (January 2025)
Fixed critical `BindingResolutionException` for team models by registering proper service container bindings:

- `team_user_model` → `\Modules\User\Models\TeamUser::class`
- `team_invitation_model` → `\Modules\User\Models\TeamInvitation::class`

**Impact**: Restored full team functionality across all modules using the `HasTeams` trait.

**Documentation**: See [Team Bindings Fix](docs/team-bindings-fix.md) for complete details.

## Permissions

The module defines the following permissions:

- `moderate_doctors`: Can moderate doctor registrations
- `view_doctors`: Can view doctors
- `create_doctors`: Can create doctors
- `edit_doctors`: Can edit doctors
- `delete_doctors`: Can delete doctors

## Roles

The module defines the following roles:

- `moderator`: Has permissions to moderate doctor registrations and view doctors

## Configuration

The module can be configured via the following environment variables:

```env
USER_CONNECTION=user
USER_GUARD=web
USER_PROVIDER=users
```

## Dependencies

- `laravel/passport`: API authentication
- `laravel/socialite`: Social authentication
- `spatie/laravel-permission`: Role and permission management
- `spatie/laravel-queueable-action`: Action pattern implementation

## License

The module is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

### Versione Incoming


---

