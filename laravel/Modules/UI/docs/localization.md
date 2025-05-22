# Localizzazione

## Best Practices

### Gestione delle Lingue

1. **Utilizzo dei Componenti**
   - Utilizzare il componente `language-switcher` per il cambio lingua
   - La localizzazione viene gestita automaticamente da Filament e Folio
   - Non è necessario creare controller o rotte specifiche

2. **File di Traduzione**
   - Mantenere i file di traduzione in `resources/lang/{locale}`
   - Utilizzare chiavi in inglese per le traduzioni
   - Organizzare le traduzioni in file per modulo

3. **Configurazione**
   - La configurazione viene gestita attraverso il file `config/laravel-localization.php`
   - Non è necessario modificare file di routing o creare controller

4. **Middleware**
   - Il middleware di localizzazione viene gestito automaticamente da Filament e Folio
   - Non è necessario creare middleware personalizzati

## Componente Language Switcher

### Utilizzo Base

```blade
<x-ui::language-switcher />
```

### Personalizzazione

```blade
<x-ui::language-switcher
    :languages="['it', 'en']"
    :show-flags="true"
    :show-names="true"
/>
```

### Funzionalità

Il componente gestisce automaticamente:
- Cambio lingua
- Persistenza della selezione
- Traduzioni
- UI/UX

Non è necessario:
- Creare controller
- Aggiungere rotte
- Gestire la logica di cambio lingua

## Configurazione

### File di Configurazione

```php
// config/laravel-localization.php
return [
    'languages' => [
        'it' => [
            'name' => 'Italiano',
            'script' => 'Latn',
            'native' => 'Italiano',
            'regional' => 'it_IT',
        ],
        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'native' => 'English',
            'regional' => 'en_GB',
        ],
    ],
    'detect' => [
        'browser' => true,
        'session' => true,
        'cookie' => true,
    ],
    'selection' => [
        'default' => 'it',
        'fallback' => 'en',
    ],
];
```

### File di Traduzione

```php
// resources/lang/it/auth.php
return [
    'login' => 'Accedi',
    'register' => 'Registrati',
    'logout' => 'Esci',
];

// resources/lang/en/auth.php
return [
    'login' => 'Login',
    'register' => 'Register',
    'logout' => 'Logout',
];
```

## Best Practices per le Traduzioni

1. **Chiavi di Traduzione**
   - Utilizzare chiavi in inglese
   - Seguire la convenzione `namespace.key`
   - Mantenere le chiavi in minuscolo con underscore

2. **Organizzazione**
   - Organizzare le traduzioni in file per modulo
   - Mantenere i file di traduzione in `resources/lang/{locale}`
   - Utilizzare file di traduzione per ogni lingua supportata

3. **Utilizzo**
   - Utilizzare la funzione `__()` per le traduzioni
   - Utilizzare la funzione `trans()` per le traduzioni
   - Utilizzare la funzione `Lang::get()` per le traduzioni

4. **Esempi**

```php
// Corretto
__('auth.login')
trans('auth.login')
Lang::get('auth.login')

// Non Corretto
__('Accedi')
trans('Accedi')
Lang::get('Accedi')
```

## Integrazione con Filament e Folio

1. **Filament**
   - La localizzazione viene gestita automaticamente
   - Non è necessario creare controller o rotte
   - Utilizzare i componenti UI per la gestione delle lingue

2. **Folio**
   - La localizzazione viene gestita automaticamente
   - Non è necessario creare controller o rotte
   - Utilizzare i componenti UI per la gestione delle lingue

3. **Componenti**
   - I componenti UI sono compatibili con Filament e Folio
   - Non è necessario creare componenti personalizzati
   - Utilizzare i componenti esistenti per la gestione delle lingue 
# Localizzazione UI

## Integrazione con Laravel Localization

Il modulo UI utilizza il pacchetto [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization) per gestire la localizzazione dell'applicazione, integrato con Filament e Folio.

### Architettura

Il progetto utilizza:
- **Filament** per la gestione del backend e delle risorse
- **Folio** per la gestione delle pagine e delle rotte
- **Laravel Localization** per la gestione delle traduzioni

### Configurazione

La configurazione si trova in `Modules/UI/config/laravellocalization.php` e include:

1. **Lingue Supportate**
   - Italiano (it)
   - Inglese (en)

2. **Rilevamento Lingua**
   - Browser
   - Header Accept-Language
   - Sessione
   - Cookie
   - Query String
   - Route

3. **Selezione Lingua**
   - URL con prefisso lingua
   - Header Accept-Language
   - Sessione
   - Cookie
   - Query String
   - Route

4. **Redirect Lingua**
   - Redirect alla lingua predefinita
   - Redirect se la lingua non è supportata
   - Redirect se la lingua non è nelle lingue supportate

### Utilizzo

#### Nelle View (Folio)

```blade
{{-- Ottieni la lingua corrente --}}
{{ LaravelLocalization::getCurrentLocale() }}

{{-- Ottieni l'URL localizzato --}}
{{ LaravelLocalization::getLocalizedURL('en', 'about') }}

{{-- Ottieni le lingue supportate --}}
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
        {{ $properties['native'] }}
    </a>
@endforeach
```

#### Nelle Risorse Filament

```php
use Filament\Resources\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ExampleResource extends Resource
{
    public static function getNavigationLabel(): string
    {
        return LaravelLocalization::getCurrentLocale() === 'it' ? 'Esempio' : 'Example';
    }
}
```

### Best Practices

1. **Architettura**
   - Utilizzare Filament per la gestione del backend
   - Utilizzare Folio per la gestione delle pagine
   - Non creare controller o rotte manualmente
   - Non modificare `web.php`

2. **URL**
   - Utilizzare sempre `LaravelLocalization::getLocalizedURL()` per generare URL localizzati
   - Non hardcodare i prefissi delle lingue negli URL

3. **View**
   - Utilizzare le traduzioni di Laravel (`__()`, `trans()`)
   - Non hardcodare testi nelle view
   - Utilizzare i componenti Blade per la riusabilità

4. **Filament**
   - Localizzare le etichette delle risorse
   - Localizzare i campi dei form
   - Localizzare i messaggi di validazione

5. **Folio**
   - Organizzare le pagine per lingua
   - Utilizzare i middleware di localizzazione
   - Gestire i redirect con `LaravelLocalization::getLocalizedURL()`

### Struttura Directory

```
Modules/UI/
├── app/
│   ├── Filament/
│   │   └── Resources/        # Risorse Filament localizzate
│   └── Providers/           # Service Provider
├── config/
│   └── laravellocalization.php
├── resources/
│   ├── lang/               # File di traduzione
│   │   ├── it/
│   │   └── en/
│   └── views/
│       └── components/     # Componenti Blade
└── docs/
    └── LOCALIZATION.md     # Documentazione
```

### Collegamenti Correlati
- [Documentazione Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Documentazione Folio](https://laravel.com/docs/folio)
- [Best Practices UI](./UI_BEST_PRACTICES.md)
- [Guida Componenti](./COMPONENTS_GUIDE.md) 
