<<<<<<< HEAD
<<<<<<< HEAD
=======

### Versione HEAD

>>>>>>> f1c9277 (.)
# Modulo CMS

Un modulo CMS modulare, estensibile e riutilizzabile per Laravel, con supporto per Filament, Volt e Folio.

## Caratteristiche

- Gestione pagine e contenuti
- Blocchi di contenuto personalizzabili
- Menu e navigazione
- Gestione media
- Layout e temi
- API RESTful e GraphQL
- Pannello amministrativo con Filament
- Componenti reattivi con Volt
- Routing basato su file con Folio

## Requisiti

- PHP 8.2+
- Laravel 11.x
- Filament 3.x
- Laravel Volt
- Laravel Folio
- Composer

## Installazione

```bash
composer require modules/cms
```

Pubblicare le risorse:

```bash
php artisan vendor:publish --provider="Modules\Cms\Providers\CmsServiceProvider"
```

Eseguire le migrazioni:

```bash
php artisan module:migrate cms
```

## Configurazione

Il modulo può essere configurato tramite il file `config/cms.php`:

```php
return [
    'prefix' => 'cms',
    'middleware' => ['web', 'auth'],
    'cache' => [
        'enabled' => true,
        'ttl' => 3600
    ],
    'media' => [
        'disk' => 'public',
        'path' => 'media'
    ]
];
```

## Utilizzo

### Creazione Pagina

```php
use Modules\Cms\Actions\CreatePageAction;

$page = app(CreatePageAction::class)->execute([
    'title' => 'La mia pagina',
    'slug' => 'la-mia-pagina',
    'content' => 'Contenuto della pagina'
]);
```

### Aggiunta Blocco

```php
use Modules\Cms\Actions\AddBlockAction;

$block = app(AddBlockAction::class)->execute($page, [
    'type' => 'text',
    'content' => 'Contenuto del blocco'
]);
```

### Componente Volt

```php
use Livewire\Volt\Component;

class PageEditor extends Component
{
    public Page $page;
    
    public function save(): void
    {
        $this->page->save();
    }
}
```

### Pagina Folio

```php
use Illuminate\View\View;

class Show
{
    public function __invoke(Page $page): View
    {
        return view('cms::pages.show', [
            'page' => $page
        ]);
    }
}
<<<<<<< HEAD
=======
=======

### Versione Alternativa

>>>>>>> f1c9277 (.)
# Modulo CMS - SaluteOra

Modulo per la gestione dei contenuti del sito SaluteOra.

## Caratteristiche

- Gestione pagine
- Gestione menu
- Contenuti dinamici
- Editor visuale
- Supporto multilingua

## Struttura

Il modulo è organizzato secondo le convenzioni di Laravel Modules e segue la struttura standard:

```
Modules/Cms/
├── app/                    # Codice principale del modulo
│   ├── Http/              # Controllers, Middleware, Requests
│   ├── Models/            # Modelli del modulo
│   ├── Filament/          # Resources e Pages di Filament
│   ├── Providers/         # Service Providers
│   └── Console/           # Comandi Artisan
├── config/                # File di configurazione
├── database/              # Migrations e Seeders
├── resources/             # Assets e Views
├── routes/                # File delle routes
├── tests/                 # Test del modulo
└── docs/                  # Documentazione del modulo
<<<<<<< HEAD
>>>>>>> feb96d7 (.)
=======

---

>>>>>>> f1c9277 (.)
```

## Documentazione

<<<<<<< HEAD
<<<<<<< HEAD
=======

### Versione HEAD

>>>>>>> f1c9277 (.)
- [Architettura](docs/architecture.md)
- [Tecnologie](docs/technologies.md)
- [Frontend](docs/frontoffice/README.md)
- [API](docs/api/README.md)
- [Sviluppo](docs/developer/README.md)
- [Utente](docs/user/README.md)

## Testing

```bash
composer test
```

## Contribuire

Le pull request sono benvenute. Per modifiche importanti, aprire prima una issue per discutere la modifica proposta.

## Licenza

MIT
<<<<<<< HEAD
=======
=======

### Versione Alternativa

>>>>>>> f1c9277 (.)
La documentazione è disponibile nella cartella `docs`:

- [Struttura del Modulo](docs/structure.md)
- [Convenzioni Filament](docs/filament.md)
- [Gestione Contenuti](docs/content.md)

## Setup

### Installazione

```bash
# Non è necessario installare il modulo separatamente, 
# è già parte del progetto SaluteOra
```

### Configurazione

```php
// Configurare il file config/cms.php
```

## Utilizzo

### Filament Admin

Accedere al pannello di amministrazione Filament per gestire i contenuti del CMS:

- Pagine: creazione e modifica di pagine del sito
- Menu: gestione dei menu di navigazione
- Contenuti: gestione di blocchi di contenuto riutilizzabili

### API

Utilizzare le API del modulo per integrare i contenuti CMS in altre parti dell'applicazione:

```php
use Modules\Cms\Models\Page;

// Ottenere tutte le pagine pubblicate
$pages = Page::published()->get();

// Ottenere una pagina specifica per slug
$page = Page::where('slug', 'chi-siamo')->first();
```

## Sviluppo

### Guidelines

Il modulo segue le convenzioni di Laravel e Filament, con alcune personalizzazioni:

- Utilizzare XotBaseResource per le risorse Filament
- Seguire le convenzioni PSR-12 per il codice
- Implementare tests per tutte le funzionalità

### Testing

Eseguire i test con:

```bash
php artisan test --filter=Cms
```
<<<<<<< HEAD
>>>>>>> feb96d7 (.)
=======

---

>>>>>>> f1c9277 (.)
