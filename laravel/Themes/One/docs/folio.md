# Folio nel Tema One

## Introduzione

Folio è il sistema di routing basato su file system di Laravel che utilizziamo nel tema One. Questo documento spiega come utilizzare Folio nel nostro progetto.

## Struttura Base

```
resources/
└── views/
    └── pages/
        ├── auth/              # Pagine di autenticazione
        ├── dashboard/         # Area riservata
        ├── profile/          # Profilo utente
        └── ...               # Altre sezioni
```

## Convenzioni Principali

1. **Routing**:
   - Non definire rotte manualmente
   - Usare la struttura delle cartelle
   - Tutte le cartelle in lowercase
   - Tutti i file .blade.php in lowercase

2. **Middleware**:
   ```php
   <?php
   use function Laravel\Folio\{middleware};
   
   middleware(['auth', 'verified']);
   ```

3. **Layout**:
   ```php
   @extends('pub_theme::layouts.app')
   
   @section('title', __('Titolo Pagina'))
   
   @section('content')
   <!-- Contenuto -->
   @endsection
   ```

## Best Practices

1. **Struttura**:
   - Usare cartelle per organizzare le pagine
   - Usare `index.blade.php` per le pagine principali
   - Mantenere nomi di file e cartelle in lowercase

2. **Sicurezza**:
   - Applicare middleware appropriati
   - Validare input
   - Sanitizzare output

3. **Performance**:
   - Minimizzare le query
   - Usare eager loading
   - Cachare quando possibile

4. **Accessibilità**:
   - Struttura semantica
   - ARIA labels
   - Contrasto adeguato

## Esempi Pratici

### Pagina di Logout
```php
<?php
use Illuminate\Support\Facades\Auth;

Auth::logout();
return redirect()->route('home');
```

### Pagina con Middleware
```php
<?php
use function Laravel\Folio\{middleware};

middleware(['auth', 'verified']);

// Contenuto della pagina
```

### Pagina con Layout
```php
@extends('pub_theme::layouts.app')

@section('title', __('Dashboard'))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Contenuto -->
    </div>
</div>
@endsection
```

## Troubleshooting

1. **Pagina non trovata**:
   - Verificare il percorso del file
   - Controllare i permessi
   - Verificare la cache

2. **Middleware non funzionante**:
   - Verificare la sintassi
   - Controllare i log
   - Verificare la configurazione

3. **Layout non applicato**:
   - Verificare l'estensione
   - Controllare i nomi delle sezioni
   - Verificare la cache delle viste

## Collegamenti
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Documentazione Volt](https://laravel.com/docs/volt)
- [Best Practices Laravel](https://laravel.com/docs/best-practices)

## Integrazione con Laravel Folio

## Introduzione

Laravel Folio è utilizzato per gestire le rotte frontend del tema One. Questa integrazione permette una gestione flessibile e localizzata delle pagine.

## Struttura delle Pagine

Le pagine sono organizzate nella seguente struttura:

```
resources/views/pages/
├── pages/
│   ├── [slug].blade.php      # Gestore dinamico delle pagine
│   └── index.blade.php       # Pagina principale
└── about.blade.php           # Pagina About predefinita
```

## Gestione delle Pagine Dinamiche

Il file `[slug].blade.php` gestisce le pagine dinamiche utilizzando Laravel Folio:

```php
<?php

use Modules\Cms\Models\Page;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use function Laravel\Folio\{withTrashed, middleware, name, render};

withTrashed();
name('page_slug.view');
//middleware(['auth', 'verified']);

render(function (View $view, string $slug) {
    $locale = app()->getLocale();
    $page = Page::firstWhere(['slug' => $slug, 'locale' => $locale]);

    if (!$page) {
        // Prova a cercare la pagina nella lingua predefinita
        $page = Page::firstWhere(['slug' => $slug, 'locale' => config('app.fallback_locale', 'en')]);
    }

    return $view->with('page', $page);
});
```

Questo codice:
1. Recupera la lingua corrente dell'applicazione
2. Cerca una pagina con lo slug specificato nella lingua corrente
3. Se non trova la pagina, cerca nella lingua predefinita (fallback)
4. Passa la pagina trovata alla vista

La vista renderizza quindi il contenuto della pagina utilizzando i metodi del tema:

```php
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
@endif
```

## Localizzazione

La localizzazione delle pagine viene gestita a livello di database, non a livello di file system. Il modello `Page` utilizza il trait `HasTranslations` per gestire le traduzioni dei seguenti campi:

- `title`
- `content_blocks`
- `sidebar_blocks`
- `footer_blocks`

### Gestione delle Traduzioni

1. **Nel Database**:
   - Ogni pagina ha un campo `locale` che indica la lingua
   - I campi traducibili sono memorizzati come JSON nel database
   - Le traduzioni sono gestite attraverso il trait `HasTranslations`

2. **Fallback Automatico**:
   - Se una pagina non esiste nella lingua corrente, il sistema cerca automaticamente nella lingua predefinita
   - La lingua predefinita è definita in `config/app.php`

3. **Interfaccia Amministrativa**:
   - Le traduzioni possono essere gestite attraverso l'interfaccia Filament
   - È disponibile un selettore di lingua per passare da una lingua all'altra

## Best Practices

1. **Organizzazione dei Contenuti**:
   - Mantenere una struttura coerente delle directory
   - Utilizzare nomi di file descrittivi
   - Gestire le traduzioni attraverso il CMS

2. **Gestione dei Componenti**:
   - Riutilizzare i componenti esistenti
   - Mantenere la coerenza nel design
   - Utilizzare i blocchi predefiniti quando possibile

3. **Performance**:
   - Ottimizzare le query al database
   - Utilizzare il caching quando appropriato
   - Minimizzare il numero di richieste

4. **Manutenibilità**:
   - Documentare le modifiche
   - Seguire le convenzioni di naming
   - Mantenere il codice pulito e organizzato

## Integrazione con il CMS

Le pagine Folio si integrano con il modulo CMS attraverso:

1. **Modello Page**:
   - Gestisce il contenuto delle pagine
   - Supporta la localizzazione
   - Gestisce i blocchi di contenuto

2. **Blocchi di Contenuto**:
   - Hero
   - Feature Sections
   - Team
   - Stats
   - CTA
   - Paragraph

3. **Gestione dei Media**:
   - Immagini
   - Video
   - Documenti

## Supporto

Per assistenza tecnica, contattare:
- Email: support@saluteora.com
- Documentazione: https://docs.saluteora.com 

## Collegamenti tra versioni di folio.md
* [folio.md](laravel/Modules/User/resources/views/docs/folio.md)
* [folio.md](laravel/Themes/One/docs/folio.md)

