# Routing e Pagine

## Introduzione

Il modulo CMS supporta due approcci principali per la gestione del routing e delle pagine: Laravel Folio e il routing tradizionale. Questa sezione descrive come configurare e utilizzare entrambi gli approcci.

## Laravel Folio

### Installazione
```bash
composer require laravel/folio
php artisan folio:install
```

### Struttura delle Pagine
```
resources/
└── views/
    └── pages/
        ├── index.blade.php
        ├── about.blade.php
        └── contact.blade.php
```

### Esempio di Pagina
```php
<?php

use App\Models\Post;

return view('folio::page', [
    'title' => 'Home',
    'posts' => Post::latest()->take(3)->get(),
]);
```

### Middleware
```php
// config/folio.php
return [
    'middleware' => ['web'],
    'path' => resource_path('views/pages'),
];
```

## Routing Tradizionale

### Definizione delle Route
```php
// routes/web.php
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
```

### Controller
```php
<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'page' => Page::where('slug', 'home')->first()
        ]);
    }

    public function about()
    {
        return view('pages.about', [
            'page' => Page::where('slug', 'about')->first()
        ]);
    }

    public function contact()
    {
        return view('pages.contact', [
            'page' => Page::where('slug', 'contact')->first()
        ]);
    }
}
```

## Gestione delle Pagine

### Modello Page
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
```

### Vista Blade
```blade
@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)

@section('meta_description', $page->meta_description)

@section('content')
    <article class="prose lg:prose-xl">
        <h1>{{ $page->title }}</h1>
        {!! $page->content !!}
    </article>
@endsection
```

## Best Practices

1. **SEO**
   - Utilizzare meta tags appropriati
   - Implementare sitemap
   - Ottimizzare gli URL

2. **Performance**
   - Implementare il caching
   - Ottimizzare le query
   - Utilizzare eager loading

3. **Sicurezza**
   - Validare l'input
   - Sanitizzare l'output
   - Implementare CSRF protection

## Risorse Utili

- [Documentazione Laravel Folio](https://laravel.com/docs/12.x/folio)
- [GitHub Laravel Folio](https://github.com/laravel/folio)
- [Laravel News Folio](https://laravel-news.com/laravel-folio)

## Troubleshooting

### Errori Comuni

1. **Problemi di Routing**
   - Verificare la configurazione delle route
   - Controllare i middleware
   - Aggiornare le dipendenze

2. **Problemi di Cache**
   - Pulire la cache delle route
   - Aggiornare la cache delle viste
   - Riavviare il server

3. **Problemi di Performance**
   - Ottimizzare le query
   - Implementare il caching
   - Utilizzare CDN 
