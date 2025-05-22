# AVVISO IMPORTANTE (2025-05-13)

> **Errore riscontrato:** Il componente `logo.blade.php` era stato posizionato erroneamente in `resources/views/components/ui/` invece che in `Modules/UI/resources/views/components/ui/`.
>
> **Causa:** Dimenticanza della regola di modularità Laraxot: tutti i componenti Blade UI condivisi devono essere sempre nel modulo UI, mai nella root Laravel.
>
> **Soluzione:** Seguire SEMPRE la regola documentata in [PATHS_AND_ASSETS.md](./PATHS_AND_ASSETS.md) e aggiornata anche nella root docs/links.md.

# Modulo UI

## Indice

### Versione Dettagliata
- [Architettura e Componenti](#architettura-e-componenti)
- [Filament](#filament)
- [Livewire e Volt](#livewire-e-volt)
- [Best Practices](#best-practices)
- [Documentazione Tecnica](#documentazione-tecnica)
- [Note Importanti](#note-importanti)
- [Collegamenti Bidirezionali](#collegamenti-bidirezionali)
- [Documentazione](#documentazione)
- [Dipendenze](#dipendenze)
- [Utilizzo](#utilizzo)

### Versione Alternativa
- Componenti Base
- Layout System
- Theme System
- Form System

## Best Practices

### Versione Dettagliata

### Gestione delle Rotte e dei Controller

1. **Non creare rotte manualmente**
   - Non aggiungere rotte in `web.php` o altri file di routing
   - Utilizzare Filament e Folio per la gestione automatica delle rotte
   - Le rotte vengono generate automaticamente in base alle risorse e alle pagine

2. **Non creare controller manualmente**
   - Evitare la creazione manuale di controller
   - Utilizzare Filament per la gestione delle risorse
   - Utilizzare Folio per la gestione delle pagine
   - I controller vengono generati automaticamente

3. **Gestione delle Lingue**
   - Utilizzare il componente `language-switcher` per il cambio lingua
   - La localizzazione viene gestita automaticamente da Filament e Folio
   - Non è necessario creare controller o rotte specifiche per la gestione delle lingue

4. **Componenti Blade**
   - Creare componenti Blade riutilizzabili
   - Utilizzare i componenti per la gestione dell'UI
   - I componenti possono essere utilizzati sia in Filament che in Folio

5. **Documentazione**
   - Documentare sempre i componenti e le loro funzionalità
   - Includere esempi di utilizzo
   - Specificare le dipendenze e i requisiti

### Versione Alternativa
- Component Design
- State Management
- Performance

## Decisione Architetturale
Questa documentazione integra entrambe le versioni emerse dal conflitto per fornire sia una panoramica rapida sia una guida dettagliata, facilitando la consultazione a diversi livelli di approfondimento.

## Backlink
- [Torna a docs/links.md](../../../../docs/links.md)
- [Vedi anche: Lang/docs/README.md](../../Lang/docs/README.md)
- [Vedi anche: User/docs/README.md](../../User/docs/README.md)
- [Vedi anche: Xot/docs/README.md](../../Xot/docs/README.md)

## Introduzione
Il modulo UI gestisce l'interfaccia utente del sistema, fornendo componenti riutilizzabili, layout e temi. Si integra con Filament, Livewire e Volt per offrire un'esperienza utente coerente e moderna.

## Convenzioni di Namespace
- Tutti i componenti devono seguire le convenzioni di namespace del progetto
- I namespace devono riflettere la struttura delle directory
- Utilizzare PSR-4 per l'autoloading

## Analisi PHPStan
- Livello di analisi: 8
- Nessun errore rilevato
- Documentazione completa dei tipi
- Test di copertura al 100%

## Architettura e Componenti
- [Componenti Base](./components/README.md)
- [Layout System](./components/layout.md)
- [Theme System](./themes/README.md)
- [Form System](./forms/README.md)
- [Blocks e Sezioni](./blocks/README.md)

## Filament
- Resource Management
- Form Builder
- UI Components

## Collegamenti correlati
> - [README.md documentazione generale](../../docs/README.md)
> - [README.md toolkit bashscripts](../../bashscripts/docs/README.md)
> - [README.md modulo GDPR](../Gdpr/docs/README.md)
> - [README.md modulo Chart](../Chart/docs/README.md) <!-- TODO: documento non presente -->
> - [README.md modulo Lang](../Lang/docs/README.md)
> - [README.md modulo Dental](../Dental/docs/README.md) <!-- TODO: documento non presente -->
> - [README.md modulo Reporting](../Reporting/docs/README.md) <!-- TODO: documento non presente -->
> - [README.md modulo Tenant](../Tenant/docs/README.md)
> - [README.md modulo CMS](../Cms/docs/README.md) <!-- TODO: documento non presente -->
> - [README.md modulo Xot](../Xot/docs/README.md)
> - [Collegamenti documentazione centrale](../../docs/collegamenti-documentazione.md)

## Livewire e Volt
- Component System
- Form Handling
- UI Updates

## Best Practices

### Gestione delle Rotte e dei Controller

1. **Non creare rotte manualmente**
   - Non aggiungere rotte in `web.php` o altri file di routing
   - Utilizzare Filament e Folio per la gestione automatica delle rotte
   - Le rotte vengono generate automaticamente in base alle risorse e alle pagine

2. **Non creare controller manualmente**
   - Evitare la creazione manuale di controller
   - Utilizzare Filament per la gestione delle risorse
   - Utilizzare Folio per la gestione delle pagine
   - I controller vengono generati automaticamente

3. **Gestione delle Lingue**
   - Utilizzare il componente `language-switcher` per il cambio lingua
   - La localizzazione viene gestita automaticamente da Filament e Folio
   - Non è necessario creare controller o rotte specifiche per la gestione delle lingue

4. **Componenti Blade**
   - Creare componenti Blade riutilizzabili
   - Utilizzare i componenti per la gestione dell'UI
   - I componenti possono essere utilizzati sia in Filament che in Folio

5. **Documentazione**
   - Documentare sempre i componenti e le loro funzionalità
   - Includere esempi di utilizzo
   - Specificare le dipendenze e i requisiti
## Documentazione Tecnica
- [Roadmap](./roadmap.md)
- [Bottlenecks](./bottlenecks.md)
- [Best Practices](./BEST-PRACTICES.md)
- [Testing](./testing.md)

## Note Importanti
1. Tutti i componenti devono estendere le classi base di Xot
2. Seguire le convenzioni di naming
3. Utilizzare i trait forniti
4. Documentare il codice

## Collegamenti Bidirezionali
- [Modulo User](../User/docs/README.md)
- [Modulo Lang](../Lang/docs/README.md)
- [Modulo Cms](../Cms/docs/README.md)

## Documentazione
- [Guida Iniziale](./getting-started.md)
- [Componenti](./components.md)
- [Layout](./layout.md)
- [Temi](./themes.md)
- [Filament](./filament/resources.md)
  - [Compatibilità dei Metodi dei Componenti Filament](./filament/component-methods-compatibility.md)
  - [Best Practices per i Wizard](./filament/wizard-best-practices.md)
  - [Traduzioni Automatiche](./filament/automatic-translations.md)

## Dipendenze
- Laravel Framework
- Filament
- Livewire
- Volt
- Folio
- Tailwind CSS
- Alpine.js

## Utilizzo
```php
// Esempio di utilizzo componente base
use Modules\UI\Components\BaseComponent;

class MyComponent extends BaseComponent
{
    public function render()
    {
        return view('ui::components.my-component');
    }
}

// Esempio di utilizzo layout
use Modules\UI\Layouts\BaseLayout;

class MyLayout extends BaseLayout
{
    public function render()
    {
        return view('ui::layouts.my-layout');
    }
}
```

## Struttura del Modulo

```
Modules/UI/
├── app/
│   ├── Models/
│   │   └── Theme.php
│   ├── Providers/
│   │   ├── UIServiceProvider.php
│   │   └── UIBaseServiceProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── ThemeResource.php
│   │   ├── Widgets/
│   │   │   └── ThemePreviewWidget.php
│   │   └── Pages/
│   │       └── ThemeManager.php
│   └── Http/
│       └── Controllers/
│           └── ThemeController.php
├── config/
│   └── ui.php
├── resources/
│   ├── css/
│   │   ├── app.css
│   │   └── themes/
│   ├── js/
│   │   ├── app.js
│   │   └── components/
│   └── views/
│       ├── components/
│       │   ├── ui/
│       │   │   ├── button.blade.php
│       │   │   ├── card.blade.php
│       │   │   └── form.blade.php
│       │   └── layout/
│       │       ├── app.blade.php
│       │       └── guest.blade.php
│       └── themes/
│           ├── light/
│           └── dark/
└── public/
    ├── css/
    ├── js/
    └── images/
```

## Componenti UI

### 1. Componenti Base
```php
// resources/views/components/ui/button.blade.php
@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'label' => null
])

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => "btn btn-{$variant} btn-{$size}"
    ]) }}
>
    @if($icon)
        <x-dynamic-component :component="'heroicon-o-'.$icon" class="w-5 h-5" />
    @endif
    @if($label)
        <span>{{ $label }}</span>
    @endif
    {{ $slot }}
</button>
```

### 2. Utilizzo in Filament
```php
// ❌ NON FARE QUESTO
use Filament\Forms\Components\TextInput;

TextInput::make('name')
    ->label('Nome')

// ✅ FARE QUESTO
use Modules\UI\Filament\Components\XotBaseTextInput;

XotBaseTextInput::make('name')
    ->label(['label' => 'Nome'])
```

### 3. Layout
```php
// resources/views/components/layout/app.blade.php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            {{ $navigation }}
        </nav>

        <main>
            {{ $slot }}
        </main>

        <footer class="bg-white border-t border-gray-100">
            {{ $footer }}
        </footer>
    </div>
</body>
</html>
```

## Best Practices

### 1. Componenti
- Utilizzare componenti Blade
- Seguire BEM per il CSS
- Implementare dark mode
- Supportare RTL

### 2. Filament
```php
// ❌ NON FARE QUESTO
use Filament\Forms\Components\TextInput;

class UserResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
        ]);
    }
}

// ✅ FARE QUESTO
use Modules\UI\Filament\Components\XotBaseTextInput;

class UserResource extends XotBaseResource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            XotBaseTextInput::make('name')
        ]);
    }
}
```

### 3. Temi
```php
// ❌ NON FARE QUESTO
<div class="bg-white text-black">

// ✅ FARE QUESTO
<div class="bg-background text-foreground">
```

## Dipendenze Principali

### Moduli
- **User**: Componenti autenticazione
- **Xot**: Componenti base
- **Lang**: Traduzioni UI

### Pacchetti
- Laravel Framework
- Filament
- Livewire
- Tailwind CSS

## Roadmap

### Prossime Feature
1. Nuovi componenti UI
2. Miglioramento temi
3. Ottimizzazione performance

### Miglioramenti Pianificati
1. Refactoring componenti
2. Miglioramento accessibilità
3. Ottimizzazione assets

## Contribuire

### Setup Sviluppo
1. Clona il repository
2. Installa le dipendenze
3. Configura l'ambiente
4. Esegui i test

### Convenzioni di Codice
- Seguire PSR-12
- Utilizzare type hints
- Documentare il codice
- Scrivere test unitari

### Processo di Pull Request
1. Crea un branch feature
2. Implementa le modifiche
3. Aggiungi i test
4. Aggiorna la documentazione
5. Crea la PR

## Troubleshooting

### Problemi Comuni
1. Stili non applicati
2. Componenti non renderizzati
3. Temi non funzionanti

### Soluzioni
1. Verifica assets
2. Controlla cache
3. Consulta documentazione

## Riferimenti

### Documentazione
- [Laravel Blade](https://laravel.com/docs/12.x/blade)
- [Filament](https://filamentphp.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)

### Collegamenti Interni
- [User Module](../User/docs/README.md)
- [Xot Module](../Xot/docs/README.md)
- [Lang Module](../Lang/docs/README.md)

## Changelog

### [1.0.0] - 2024-03-20
#### Added
- Implementazione iniziale
- Componenti base
- Sistema temi
- Layout responsive

#### Changed
- Miglioramento performance
- Ottimizzazione assets
- Refactoring componenti

#### Fixed
- Bug stili
- Problemi layout
### Versione HEAD

- Errori temi 

### Versione Incoming

- Errori temi 
- Livewire 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](../../../Chart/docs/README.md)
* [README.md](../../../Reporting/docs/README.md)
* [README.md](../../../Gdpr/docs/phpstan/README.md)
* [README.md](../../../Gdpr/docs/README.md)
* [README.md](../../../Notify/docs/phpstan/README.md)
* [README.md](../../../Notify/docs/README.md)
* [README.md](../../../Xot/docs/filament/README.md)
* [README.md](../../../Xot/docs/phpstan/README.md)
* [README.md](../../../Xot/docs/exceptions/README.md)
* [README.md](../../../Xot/docs/README.md)
* [README.md](../../../Xot/docs/standards/README.md)
* [README.md](../../../Xot/docs/conventions/README.md)
* [README.md](../../../Xot/docs/development/README.md)
* [README.md](../../../Dental/docs/README.md)
* [README.md](../../../User/docs/phpstan/README.md)
* [README.md](../../../User/docs/README.md)
* [README.md](../../../User/docs/README.md)
* [README.md](../../../UI/docs/phpstan/README.md)
* [README.md](../../../UI/docs/README.md)
* [README.md](../../../UI/docs/standards/README.md)
* [README.md](../../../UI/docs/themes/README.md)
* [README.md](../../../UI/docs/components/README.md)
* [README.md](../../../Lang/docs/phpstan/README.md)
* [README.md](../../../Lang/docs/README.md)
* [README.md](../../../Job/docs/phpstan/README.md)
* [README.md](../../../Job/docs/README.md)
* [README.md](../../../Media/docs/phpstan/README.md)
* [README.md](../../../Media/docs/README.md)
* [README.md](../../../Tenant/docs/phpstan/README.md)
* [README.md](../../../Tenant/docs/README.md)
* [README.md](../../../Activity/docs/phpstan/README.md)
* [README.md](../../../Activity/docs/README.md)
* [README.md](../../../Patient/docs/README.md)
* [README.md](../../../Patient/docs/standards/README.md)
* [README.md](../../../Patient/docs/value-objects/README.md)
* [README.md](../../../Cms/docs/blocks/README.md)
* [README.md](../../../Cms/docs/README.md)
* [README.md](../../../Cms/docs/standards/README.md)
* [README.md](../../../Cms/docs/content/README.md)
* [README.md](../../../Cms/docs/frontoffice/README.md)
* [README.md](../../../Cms/docs/components/README.md)
* [README.md](../../../../Themes/Two/docs/README.md)
* [README.md](../../../../Themes/One/docs/README.md)

## Regola sui Componenti Blade UI

> **IMPORTANTE:** Tutti i componenti Blade UI condivisi (es. logo, button, badge, ecc.) devono essere posizionati esclusivamente in:
>
> `/var/www/html/ptvx/laravel/Modules/UI/resources/views/components/ui/`
>
> **MAI** in `resources/views/components/ui/` della root Laravel.

Consulta la [documentazione dettagliata sui path e gli asset](./PATHS_AND_ASSETS.md) per motivazione, esempi e best practices.

---

## Server MCP consigliati per UI

Per il modulo UI, si consiglia di utilizzare i seguenti server MCP:

- **sequential-thinking**: per orchestrare workflow di generazione componenti UI, brainstorming di design e automazione di processi di revisione UI.
- **memory**: per mantenere una knowledge base di componenti, template, pattern di design e storico delle revisioni UI.
- **filesystem**: per esportare/importare componenti, template o asset grafici.
- **postgres**: se il modulo utilizza un database PostgreSQL per archiviare configurazioni UI, template o log di utilizzo.
- **puppeteer**: per automatizzare test end-to-end, generazione di screenshot di componenti, esportazione PDF o scraping di UI da siti esterni.

**Nota:**
- Usa solo server MCP Node.js disponibili su npm e avviabili con `npx`.
- Configura sempre gli argomenti obbligatori (es. directory per filesystem, stringa di connessione per postgres).
- Non usare fetch, mysql o redis se non attivo.

Per dettagli e best practice consulta la guida generale MCP nel workspace.

