# Pagine Folio

## Introduzione

Folio è il sistema di routing basato su file system di Laravel. Le pagine sono automaticamente mappate alle rotte basandosi sulla struttura delle cartelle.

## Struttura delle Cartelle

```
resources/
└── views/
    └── pages/
        ├── auth/
        │   ├── login.blade.php
        │   ├── register.blade.php
        │   └── logout.blade.php
        ├── dashboard/
        │   └── index.blade.php
        └── index.blade.php
```

## Convenzioni

1. **Naming**:
   - Tutte le cartelle in lowercase
   - I file .blade.php in lowercase
   - Struttura gerarchica chiara

2. **Routing Automatico**:
   - `/` → `index.blade.php`
   - `/auth/login` → `auth/login.blade.php`
   - `/auth/logout` → `auth/logout.blade.php`
   - `/dashboard` → `dashboard/index.blade.php`

3. **Best Practices**:
   - Non definire rotte manualmente
   - Usare la struttura delle cartelle per il routing
   - Mantenere nomi di cartelle e file in lowercase
   - Usare `index.blade.php` per le pagine principali

## Esempi

### Pagina di Logout
```php
<?php

use Illuminate\Support\Facades\Auth;

Auth::logout();

return redirect()->route('home');
```

### Pagina di Login
```php
@extends('pub_theme::layouts.app')

@section('title', __('Login'))

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Form fields -->
        </form>
    </div>
</div>
@endsection
```

## Middleware

I middleware possono essere applicati alle pagine usando le direttive Folio:

```php
<?php

use function Laravel\Folio\{middleware};

middleware(['auth', 'verified']);

// Contenuto della pagina
```

## Collegamenti

- [Documentazione Folio](https://laravel.com/docs/folio)
- [Best Practices Routing](https://laravel.com/docs/routing)
- [Documentazione Volt](https://laravel.com/docs/volt)

## Collegamenti tra versioni di folio-pages.md
* [folio-pages.md](laravel/Modules/User/resources/views/docs/folio-pages.md)
* [folio-pages.md](laravel/Modules/Cms/docs/folio-pages.md)
* [folio-pages.md](laravel/Themes/One/docs/folio-pages.md)

