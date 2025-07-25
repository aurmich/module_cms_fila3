# Modulo Media

## Panoramica
Il modulo Media gestisce tutti i file multimediali dell'applicazione, fornendo un sistema centralizzato per l'upload, la gestione e la distribuzione di immagini, video, documenti e altri file. Si integra con tutti gli altri moduli per garantire una gestione efficiente dei media.

### Versione HEAD


### Versione Incoming

## Collegamenti correlati
- [README.md documentazione generale](../../../docs/README.md)
- [README.md toolkit bashscripts](../../../bashscripts/docs/README.md)
- [README.md modulo GDPR](../Gdpr/docs/README.md)
- [README.md modulo User](../User/docs/README.md)
- [README.md modulo Lang](../Lang/docs/README.md)
- [README.md modulo Media](../Media/docs/README.md)
- [README.md modulo Notify](../Notify/docs/README.md)
- [README.md modulo Tenant](../Tenant/docs/README.md)
- [README.md modulo UI](../UI/docs/README.md)
- [README.md modulo Xot](../Xot/docs/README.md)
- [Collegamenti documentazione centrale](../../../docs/collegamenti-documentazione.md)


---

## Collegamenti Principali

### Documentazione Core
- [Struttura del Modulo](./structure.md)
- [Gestione File](./files.md)
- [Conversioni](./conversions.md)
- [Storage](./storage.md)
- [Best Practices](./BEST-PRACTICES.md)

### Integrazioni
- [Integrazione con User](../User/docs/README.md)
- [Integrazione con Xot](../Xot/docs/README.md)
- [Integrazione con Lang](../Lang/docs/README.md)

### Best Practices
- [Convenzioni Media](./media-conventions.md)
- [Gestione Storage](./storage-management.md)
- [PHPStan Fixes](./phpstan-fixes.md)

### Testing e Qualità
- [PHPStan Level 9](./PHPSTAN_LEVEL9_FIXES.md)
- [PHPStan Level 10](./PHPSTAN_LEVEL10_FIXES.md)
- [Testing Best Practices](./testing-best-practices.md)

## Struttura del Modulo

```
Modules/Media/
├── app/
│   ├── Models/
│   │   ├── Media.php
│   │   └── MediaConversion.php
│   ├── Providers/
│   │   ├── MediaServiceProvider.php
│   │   └── MediaBaseServiceProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── MediaResource.php
│   │   ├── Widgets/
│   │   │   └── MediaStatsWidget.php
│   │   └── Pages/
│   │       └── MediaManager.php
│   └── Http/
│       └── Controllers/
│           └── MediaController.php
├── config/
│   └── media.php
├── database/
│   └── migrations/
│       ├── create_media_table.php
│       └── create_media_conversions_table.php
└── resources/
    └── views/
        └── media/
            ├── upload.blade.php
            └── manager.blade.php
```

## Gestione Media

### 1. Modello Media
```php
// app/Models/Media.php
namespace App\Models;

use Modules\Media\Models\XotBaseMedia;
use Modules\Lang\Facades\Lang;

class Media extends XotBaseMedia
{
    protected $fillable = [
        'name',
        'file_name',
        'mime_type',
        'size',
        'disk',
        'conversions'
    ];

    protected $casts = [
        'conversions' => 'array'
    ];

    public function getDisplayNameAttribute(): string
    {
        return Lang::get('media.name', ['name' => $this->name]);
    }
}
```

### 2. Trait HasMedia
```php
// ❌ NON FARE QUESTO
class User extends Model
{
    public function avatar()
    {
        return $this->hasOne(Media::class);
    }
}

// ✅ FARE QUESTO
use Modules\Media\Traits\HasMedia;

class User extends XotBaseModel
{
    use HasMedia;

    protected $fillable = [
        'name',
        'email'
    ];
}
```

### 3. Utilizzo in Filament
```php
// ❌ NON FARE QUESTO
use Filament\Forms\Components\FileUpload;

FileUpload::make('avatar')
    ->label('Avatar')

// ✅ FARE QUESTO
use Modules\Media\Filament\Components\XotBaseFileUpload;

XotBaseFileUpload::make('avatar')
    ->label(['label' => 'Avatar'])
```

## Best Practices

### 1. Upload
- Validare i file
- Generare nomi unici
- Gestire le conversioni
- Ottimizzare le immagini

### 2. Storage
```php
// ❌ NON FARE QUESTO
Storage::disk('public')->put($path, $file);

// ✅ FARE QUESTO
Media::upload($file, [
    'disk' => 'public',
    'conversions' => [
        'thumb' => [
            'width' => 100,
            'height' => 100
        ]
    ]
]);
```

### 3. Conversioni
```php
// ❌ NON FARE QUESTO
$image->resize(100, 100);

// ✅ FARE QUESTO
$media->convert('thumb', [
    'width' => 100,
    'height' => 100,
    'fit' => 'crop'
]);
```

## Dipendenze Principali

### Moduli
- **User**: Media utente
- **Xot**: Media base
- **Lang**: Traduzioni media

### Pacchetti
- Laravel Framework
- Filament
- Livewire
- Spatie Media Library

## Roadmap

### Prossime Feature
1. Nuovi tipi media
2. Miglioramento conversioni
3. Ottimizzazione storage

### Miglioramenti Pianificati
1. Refactoring media
2. Miglioramento UI
3. Ottimizzazione performance

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
1. Upload fallito
2. Conversioni non funzionanti
3. Errori storage

### Soluzioni
1. Verifica configurazione
2. Controlla log
3. Consulta documentazione

## Riferimenti

### Documentazione
- [Laravel Storage](https://laravel.com/docs/12.x/filesystem)
- [Filament](https://filamentphp.com/docs)
- [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary)

### Collegamenti Interni
- [User Module](../User/docs/README.md)
- [Xot Module](../Xot/docs/README.md)
- [Lang Module](../Lang/docs/README.md)

## Changelog

### [1.0.0] - 2024-03-20
#### Added
- Implementazione iniziale
- Sistema media
- Conversioni base
- Storage manager

#### Changed
- Miglioramento performance
- Ottimizzazione storage
- Refactoring codice

#### Fixed
- Bug upload
- Problemi conversioni
### Versione HEAD

- Errori storage 

### Versione Incoming

- Errori storage 
## Collegamenti
- [Modulo Xot](../../Xot/docs/README.md)
- [Modulo Cms](../../Cms/docs/README.md)
- [Modulo Lang](../../Lang/docs/README.md) 
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


---

## Server MCP consigliati per Media

Per il modulo Media, si consiglia di utilizzare i seguenti server MCP:

- **sequential-thinking**: per orchestrare workflow di gestione media, automazione di processi di upload/download e revisione di asset multimediali.
- **memory**: per mantenere una knowledge base di file, immagini, video e storico delle operazioni media.
- **filesystem**: per esportare/importare file, immagini, video o gestire backup di asset multimediali.
- **postgres**: se il modulo utilizza un database PostgreSQL per archiviare metadati, log o riferimenti a file media.
- **puppeteer**: per automatizzare scraping di immagini/video da web, generazione di thumbnail, esportazione PDF o test di visualizzazione media.

**Nota:**
- Usa solo server MCP Node.js disponibili su npm e avviabili con `npx`.
- Configura sempre gli argomenti obbligatori (es. directory per filesystem, stringa di connessione per postgres).
- Non usare fetch, mysql o redis se non attivo.

Per dettagli e best practice consulta la guida generale MCP nel workspace.

