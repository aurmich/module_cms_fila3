<<<<<<< HEAD
<<<<<<< HEAD
=======

### Versione HEAD

>>>>>>> f1c9277 (.)
# Routing e Pagine nel Modulo CMS

## Indice
1. [Introduzione](#introduzione)
2. [Architettura Folio + Volt + Filament](#architettura-folio--volt--filament)
3. [Struttura delle Pagine](#struttura-delle-pagine)
4. [Integrazione con il CMS](#integrazione-con-il-cms)
5. [Localizzazione](#localizzazione)
6. [Best Practices](#best-practices)
7. [Troubleshooting](#troubleshooting)
8. [Collegamenti Bidirezionali](#collegamenti-bidirezionali)

## Introduzione

Il modulo CMS di il progetto utilizza Laravel Folio per il routing basato su file, Volt per la gestione dello stato e Filament per i form complessi. Questo approccio garantisce una separazione chiara delle responsabilità e una maggiore manutenibilità del codice.

> **IMPORTANTE**: In il progetto, non definire rotte frontend in `routes/web.php`. Utilizzare sempre Laravel Folio per il routing frontend.

## Architettura Folio + Volt + Filament

### Folio: Routing Basato su File

Folio gestisce automaticamente il routing basato sui file nella directory `Themes/{ThemeName}/resources/views/pages`. Ogni file `.blade.php` diventa automaticamente una rotta accessibile.

### Volt: Gestione dello Stato

Volt fornisce un modo semplice per aggiungere interattività alle pagine Folio, gestendo lo stato e la logica dei componenti.

### Filament: Form Complessi

Per i form complessi, il progetto utilizza i widget Filament integrati nelle pagine Folio tramite Livewire.

```php
// In una vista Blade (es. register.blade.php)
@livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class, ['type' => 'patient'])
```

## Struttura delle Pagine

La struttura delle directory per le pagine nel tema è organizzata come segue:

```
Themes/{ThemeName}/resources/views/pages/
├── index.blade.php             # Homepage principale
├── about.blade.php             # Pagina "Chi siamo"
├── pages/                      # Sottocartella per le pagine dinamiche
│   ├── index.blade.php         # Indice delle pagine dinamiche
│   └── [slug].blade.php        # Gestore per le pagine dinamiche dal CMS
├── auth/                       # Pagine di autenticazione
├── profile/                    # Pagine profilo utente
└── ... altre sezioni ...
```

### Nomenclatura dei File

Folio segue convenzioni specifiche per la nomenclatura dei file:

1. **File statici**: `nome-pagina.blade.php` → `/nome-pagina`
2. **Parametri dinamici**: `[parametro].blade.php` → `/{valore-parametro}`
3. **Parametri opzionali**: `[[parametro]].blade.php` → `/` o `/{valore-parametro}`
4. **Index files**: `index.blade.php` → `/` (nella directory corrente)

### Esempio di Pagina Dinamica

```php
<?php
use Modules\Cms\Models\Page;
use Illuminate\View\View;
use function Laravel\Folio\{withTrashed, name, render};

withTrashed();
name('page_slug.view');

render(function (View $view, string $slug) {
    $locale = app()->getLocale();
    $page = Page::firstWhere(['slug' => $slug]);
    
    return $view->with([
        'page' => $page,
        'locale' => $locale
    ]);
});
?>

<x-layouts.marketing>
    <div class="max-w-[calc(100%-30px)] sm:max-w-[calc(100%-80px)] lg:max-w-[996px] mx-auto pb-12 font-roboto">
        @if($page)
            <div class="py-10">
                <h1 class="text-[2rem] mb-4 font-roboto font-semibold text-neutral-5">
                    {{ $page->title }}
                </h1>
            </div>

            @if(!empty($page->sidebar_blocks))
                <div class="grid grid-cols-1 lg:grid-cols-[21.25rem,1fr] gap-4">
                    <div class="space-y-6">
                        {{ $_theme->showPageSidebarContent($page->slug) }}
                    </div>

                    {{ $_theme->showPageContent($page->slug) }}
                </div>
            @else
                <div>
                    {{ $_theme->showPageContent($page->slug) }}
                </div>
            @endif
        @else
            <!-- Pagina non trovata -->
            <div class="flex flex-col items-center justify-center py-8 space-y-4">
                <!-- Contenuto per errore 404 -->
            </div>
        @endif
    </div>
</x-layouts.marketing>
```

## Integrazione con il CMS

Il modulo CMS si integra con Folio per gestire le pagine dinamiche. I componenti chiave di questa integrazione sono:

### 1. Modello Page

Il modello `Page` dal modulo CMS memorizza i dati delle pagine, inclusi:
- Titolo
- Slug (URL)
- Contenuto (usando blocchi strutturati)
- Informazioni della sidebar
- Traduzioni

### 2. Helper del Tema

Il tema fornisce helper per renderizzare il contenuto delle pagine:

- `$_theme->showPageContent($slug)`: Renderizza i blocchi principali della pagina
- `$_theme->showPageSidebarContent($slug)`: Renderizza i blocchi della sidebar della pagina

## Localizzazione

### Struttura degli URL Localizzati

In il progetto, tutti gli URL devono includere il prefisso della lingua corrente. La struttura corretta è:

```
/{locale}/sezione/pagina
```

Esempi:
- `/it/pages/chi-siamo`
- `/en/pages/about-us`

### Generazione Corretta dei Link

Quando si generano link alle pagine, è fondamentale includere sempre la locale corrente:

```php
// CORRETTO
<a href="{{ url('/' . app()->getLocale() . '/pages/' . $page->slug) }}">{{ $page->title }}</a>

// ERRATO - manca la locale
<a href="{{ url('/pages/' . $page->slug) }}">{{ $page->title }}</a>
```

### Recupero della Locale

La locale corrente può essere recuperata usando:

```php
$locale = app()->getLocale();
<<<<<<< HEAD
=======
=======

### Versione Alternativa

>>>>>>> f1c9277 (.)
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
<<<<<<< HEAD
>>>>>>> feb96d7 (.)
=======

---

>>>>>>> f1c9277 (.)
```

## Best Practices

<<<<<<< HEAD
<<<<<<< HEAD
=======

### Versione HEAD

>>>>>>> f1c9277 (.)
### Organizzazione delle Pagine

1. **Modularità**: Creare directory dedicate per gruppi di pagine correlate
2. **Riutilizzo**: Utilizzare componenti Blade per elementi ripetuti
3. **Chiarezza**: Utilizzare nomi di file descrittivi che riflettono il contenuto

### Form Complessi

1. **Widget Filament**: Utilizzare widget Filament per form complessi
2. **Integrazione Livewire**: Integrare i widget nelle pagine Folio tramite Livewire
3. **Separazione delle Responsabilità**: Mantenere la logica di validazione nei widget

### Performance e SEO

1. **Caching**: Implementare il caching per le pagine che cambiano raramente
2. **Eager Loading**: Utilizzare il caricamento anticipato per le relazioni quando appropriato
3. **Meta Tags**: Utilizzare meta tags appropriati per SEO
4. **Sitemap**: Implementare sitemap per migliorare l'indicizzazione

### Sicurezza

1. **Validazione Input**: Validare tutti gli input utente
2. **Sanitizzazione Output**: Sanitizzare l'output per prevenire XSS
3. **CSRF Protection**: Implementare protezione CSRF per tutti i form
<<<<<<< HEAD
=======
=======

### Versione Alternativa

>>>>>>> f1c9277 (.)
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
>>>>>>> feb96d7 (.)

---


## Troubleshooting

### Errori Comuni

1. **Problemi di Routing**
<<<<<<< HEAD
<<<<<<< HEAD
=======

### Versione HEAD

>>>>>>> f1c9277 (.)
   - Verificare la struttura delle directory
   - Controllare la nomenclatura dei file
   - Assicurarsi che i file siano nella directory corretta

2. **Problemi di Localizzazione**
   - Verificare che gli URL includano il prefisso della lingua
   - Controllare che la locale sia recuperata correttamente
   - Assicurarsi che i link siano generati con la locale corretta

3. **Problemi di Integrazione**
   - Verificare che i widget Filament siano integrati correttamente
   - Controllare che i namespace siano corretti
   - Assicurarsi che le dipendenze siano installate

## Collegamenti Bidirezionali

- [Documentazione Generale sul Routing](../../../Xot/docs/ROUTING.md) - Modulo Xot
- [Architettura Folio + Volt + Filament](../../../Xot/docs/FOLIO_VOLT_ARCHITECTURE.md) - Modulo Xot
- [Struttura dei Moduli](../../../Xot/docs/MODULE_STRUCTURE.md) - Modulo Xot
- [Localizzazione](../../../Lang/docs/packages/localization.md) - Modulo Lang
- [Collegamenti alla Root](../../../../docs/routing.md)

## Collegamenti tra versioni di routing.md
* [routing.md](docs/routing.md)
* [routing.md](laravel/Modules/Cms/docs/frontoffice/routing.md)

<<<<<<< HEAD
=======
=======

### Versione Alternativa

>>>>>>> f1c9277 (.)
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
<<<<<<< HEAD
>>>>>>> feb96d7 (.)
=======

---

>>>>>>> f1c9277 (.)
