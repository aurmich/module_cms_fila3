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
```

## Documentazione

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
