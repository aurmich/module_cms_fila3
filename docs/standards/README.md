# Standard CMS

Questo documento contiene gli standard specifici per il modulo CMS.

## Gestione Contenuti

### Nomenclatura
- Nome in PascalCase
- Prefisso `XotBase` per le classi base
- Suffisso `Content` per i modelli di contenuto
- Suffisso `Block` per i blocchi di contenuto

### Struttura Modelli
```php
namespace Modules\Cms\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class XotBaseContent extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => ContentStatus::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(ContentBlock::class);
    }
}
```

### Blocchi di Contenuto
- Componenti riutilizzabili
- Configurazione flessibile
- Versionamento
- Cache intelligente

## Frontend

### Nomenclatura
- Nome in PascalCase
- Prefisso `XotBase` per le classi base
- Suffisso `Page` per le pagine
- Suffisso `Layout` per i layout

### Struttura Pagine
```php
namespace Modules\Cms\app\View\Pages;

use Illuminate\View\View;
use Modules\Cms\app\Models\Content;

class XotBaseContentPage
{
    public function __construct(
        protected Content $content
    ) {}

    public function render(): View
    {
        return view('cms::pages.content', [
            'content' => $this->content,
            'blocks' => $this->content->blocks,
        ]);
    }
}
```

### SEO
- Meta tags dinamici
- Sitemap XML
- Robots.txt
- Structured data

## Performance

### Caching
- Cache a più livelli
- Cache invalidation
- Cache per tenant
- Cache per lingua

### Ottimizzazioni
- Lazy loading immagini
- Minificazione assets
- CDN per media
- Compressione

## Sicurezza

### Contenuti
- Sanitizzazione input
- Validazione output
- Protezione XSS
- Protezione CSRF

### Accesso
- Controlli permessi
- Audit log
- Versionamento
- Backup

## Multilingua

### Traduzioni
- File di traduzione
- Fallback chain
- Pluralizzazione
- Formattazione

### Contenuti
- Traduzioni gestite
- Fallback content
- RTL support
- Date/Time format

## Media

### Gestione
- Upload sicuro
- Ottimizzazione immagini
- CDN integration
- Backup media

### Tipi Supportati
- Immagini
- Documenti
- Video
- Audio

## API

### REST
- Versionamento
- Documentazione
- Rate limiting
- Authentication

### GraphQL
- Schema definition
- Resolvers
- Caching
- Error handling 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/project_docs/README.md)
* [README.md](bashscripts/project_docs/it/README.md)
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
* [README.md](laravel/vendor/mockery/mockery/project_docs/README.md)
* [README.md](laravel/Modules/Chart/project_docs/README.md)
* [README.md](laravel/Modules/Reporting/project_docs/README.md)
* [README.md](laravel/Modules/Gdpr/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/project_docs/README.md)
* [README.md](laravel/Modules/Notify/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/project_docs/README.md)
* [README.md](laravel/Modules/Xot/project_docs/filament/README.md)
* [README.md](laravel/Modules/Xot/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/project_docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/project_docs/README.md)
* [README.md](laravel/Modules/Xot/project_docs/standards/README.md)
* [README.md](laravel/Modules/Xot/project_docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/project_docs/development/README.md)
* [README.md](laravel/Modules/Dental/project_docs/README.md)
* [README.md](laravel/Modules/User/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/User/project_docs/README.md)
* [README.md](laravel/Modules/User/resources/views/project_docs/README.md)
* [README.md](laravel/Modules/UI/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/project_docs/README.md)
* [README.md](laravel/Modules/UI/project_docs/standards/README.md)
* [README.md](laravel/Modules/UI/project_docs/themes/README.md)
* [README.md](laravel/Modules/UI/project_docs/components/README.md)
* [README.md](laravel/Modules/Lang/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/project_docs/README.md)
* [README.md](laravel/Modules/Job/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/project_docs/README.md)
* [README.md](laravel/Modules/Media/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/project_docs/README.md)
* [README.md](laravel/Modules/Tenant/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/project_docs/README.md)
* [README.md](laravel/Modules/Activity/project_docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/project_docs/README.md)
* [README.md](laravel/Modules/Patient/project_docs/README.md)
* [README.md](laravel/Modules/Patient/project_docs/standards/README.md)
* [README.md](laravel/Modules/Patient/project_docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/project_docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/project_docs/README.md)
* [README.md](laravel/Modules/Cms/project_docs/standards/README.md)
* [README.md](laravel/Modules/Cms/project_docs/content/README.md)
* [README.md](laravel/Modules/Cms/project_docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/project_docs/components/README.md)
* [README.md](laravel/Themes/Two/project_docs/README.md)
* [README.md](laravel/Themes/One/project_docs/README.md)

