# Documentazione Modulo Xot

Il modulo Xot fornisce funzionalità di base per il framework Laraxot, incluse azioni, servizi, e componenti fondamentali.

## Struttura della Documentazione

### Core Features
- [Development Rules](development-rules.md) - Regole di sviluppo per il modulo
- [Code Quality](code_quality.md) - Standard di qualità del codice
- [Best Practices](best-practices.md) - Pratiche consigliate
- [Translation Rules](translation_rules.md) - Regole per file di traduzione
- [Xot Base Translation Update](xot_base_translation_update.md) - ⭐ **NUOVO** - Aggiornamento file traduzioni base

### Testing
- [Testing Guidelines](testing.md) - ⭐ **IMPORTANTE** - Regole per organizzazione test del modulo Xot
- Regola fondamentale: **TUTTI i test che verificano codice `Modules\Xot\*` DEVONO essere in `Modules/Xot/tests/`**
## Introduzione

Il modulo Xot è il core del sistema, fornisce funzionalità base e componenti riutilizzabili per tutti gli altri moduli. Implementa pattern architetturali, gestione degli errori, e componenti UI comuni.

## File Chiave
- [BaseUser.php](../User/app/Models/BaseUser.php)
- [User.php](../User/app/Models/User.php)
- [Doctor.php](../Patient/app/Models/Doctor.php)
- [DoctorResource.php](../Patient/app/Filament/Resources/DoctorResource.php)
- [RegisterAction.php](../Patient/app/Actions/RegisterAction.php)
- [RegistrationWidget.php](../User/app/Filament/Widgets/RegistrationWidget.php)

## Componenti Principali


### PHPStan e Qualità del Codice
- [PHPStan Level 10 Guide](phpstan_livello10_linee_guida.md) - Guida completa per PHPStan livello 10
- [PHPStan Level 9 Guide](phpstan-level9-guide.md) - Guida per PHPStan livello 9
- [PHPStan Generic Types](phpstan-generic-types.md) - Gestione tipi generici
- [PHPStan Collection Types](phpstan-collection-types.md) - ⭐ **NUOVO** - Gestione incompatibilità tipi Collection
- [PHPStan Fixes Gennaio 2025](phpstan-fixes-gennaio-2025.md) - ⭐ **COMPLETATO** - Log dettagliato correzioni PHPStan

### Exception Handling
- [Exception Handler Decorator](exceptions/handler-decorator.md) - Pattern decorator per gestione eccezioni
- [Exception Handler Types](exceptions/exception-handler-types.md) - ⭐ **NUOVO** - Tipizzazione corretta ExceptionHandler

### UI Components
- [Filament Integration](filament-integration.md) - Integrazione con Filament
- [Form Components](form-components.md) - Componenti per form
- [Blade Components](blade-components.md) - Componenti Blade personalizzati

### File Management
- [Asset Management](asset-management.md) - Gestione asset e risorse
- [Export System](export-system.md) - Sistema di esportazione dati

### Utilities
- [Helper Functions](helpers.md) - Funzioni di utilità
- [Data Transfer Objects](dtos.md) - Pattern DTO con Spatie Laravel Data
- [Actions](actions.md) - Azioni asincroni con Spatie QueueableAction

## Modifiche Recenti

### Gennaio 2025 - File di Traduzione Base ⭐ **NUOVO**

**Stato**: **COMPLETATO** - Aggiornamento e sistemazione file `xot_base.php`

**Modifiche principali**:
- ✅ Conversione da `array()` a sintassi `[]` moderna
- ✅ Aggiunta `declare(strict_types=1);` per tipizzazione rigorosa
- ✅ Rimozione duplicazioni e campi `helper_text` vuoti
- ✅ Risoluzione conflitti di merge non risolti
- ✅ Miglioramento struttura e coerenza traduzioni
- ✅ Validazione sintassi PHP con `php -l`

**Impatto**: Miglioramento qualità codice e conformità best practice Laraxot

Vedi [xot_base_translation_update.md](xot_base_translation_update.md) per dettagli completi.

### Gennaio 2025 - Testing Organization ⭐ **NUOVO**

**Stato**: **IMPLEMENTATO** - Sistema di organizzazione test modularizzato

**Regola chiave**: 
- ✅ Test del modulo Xot SOLO in `Modules/Xot/tests/`
- ❌ MAI test del modulo Xot in `/tests/` (cartella root)

**Motivazione**: Prevenire sovrascritture durante aggiornamenti Laravel

**Test esistenti nel modulo**:
- ✅ `MetatagDataTest.php` - Test per `Modules\Xot\Datas\MetatagData`
- ✅ `HasXotTableTest.php` - Test per trait `HasXotTable`

### Gennaio 2025 - PHPStan Level 9 Compliance ✅

**Stato**: **COMPLETATO** - Tutti gli errori PHPStan livello 9 del modulo Xot sono stati risolti

**Errori risolti**: 9 errori principali
- ✅ ExceptionHandler::handles() - Missing return type
- ✅ Collection type incompatibility in Export actions
- ✅ PathHelper::getModules() - Array type inference
- ✅ DownloadZipByPathsDiskAction - Missing return type e null handling
- ✅ GetViewByClassAction - view-string type compliance
- ✅ SendMailByRecordAction - Model property/method safety
- ✅ PdfByHtmlAction - Syntax errors e return type
- ✅ MetatagData::getThemeColors() - Array type mismatch

**Files modificati**: 6 files core + documentazione aggiornata
**PHPStan status**: `[OK] No errors` per tutto il modulo Xot

Vedi [phpstan-fixes-gennaio-2025.md](phpstan-fixes-gennaio-2025.md) per dettagli completi.

## Guide di Riferimento

### Sviluppo
- [Coding Standards](coding-standards.md) - Standard di codifica del modulo
- [Testing Guidelines](testing.md) - Linee guida per i test
- [Deployment](deployment.md) - Procedure di deployment

### Troubleshooting
- [Common Issues](troubleshooting.md) - Problemi comuni e soluzioni
- [Debug Guide](debug-guide.md) - Guida al debugging

## Links Utili

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [PHPStan Documentation](https://phpstan.org/user-guide)
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data)

*Ultimo aggiornamento: Gennaio 2025* 
### 3. Interfaces
- `RepositoryInterface`: Contratto base per i repository
- `ServiceInterface`: Contratto base per i service
- `ActionInterface`: Contratto base per le actions

### 4. Exceptions
- `BaseException`: Classe base per le eccezioni
- `ValidationException`: Gestione errori di validazione
- `NotFoundException`: Gestione risorse non trovate
- `AuthorizationException`: Gestione errori di autorizzazione

## Best Practices

### 1. Ereditarietà
- Estendere sempre le classi base appropriate
- Implementare le interfacce richieste
- Usare i trait forniti quando necessario

### 2. Error Handling
- Usare le eccezioni custom fornite
- Implementare logging appropriato
- Gestire gli errori in modo consistente

### 3. Validation
- Usare le regole di validazione base
- Estendere le regole quando necessario
- Mantenere la validazione consistente

## Dependencies
- Laravel Framework
- Filament
- Parental
- Laravel Modules

## Struttura
```
Xot/
├── app/
│   ├── Models/
│   │   └── XotBaseModel.php
│   ├── Providers/
│   │   ├── XotBaseServiceProvider.php
│   │   └── XotServiceProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── XotBaseResource.php
│   │   ├── Widgets/
│   │   │   └── XotBaseWidget.php
│   │   └── Pages/
│   │       └── XotBasePage.php
│   └── Http/
│       └── Controllers/
│           └── XotBaseController.php
├── config/
│   └── xot.php
└── resources/
    └── views/
        └── components/
            └── xot/
```

## Classi Base

### 1. XotBaseModel
```php
namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Model;

abstract class XotBaseModel extends Model
{
    // Implementazione base per tutti i modelli
}
```

### 2. XotBaseServiceProvider
```php
namespace Modules\Xot\Providers;

use Illuminate\Support\ServiceProvider;

abstract class XotBaseServiceProvider extends ServiceProvider
{
    // Implementazione base per tutti i service provider
}
```

### 3. XotBaseResource
```php
namespace Modules\Xot\Filament\Resources;

use Filament\Resources\Resource;

abstract class XotBaseResource extends Resource
{
    // Implementazione base per tutte le risorse Filament
}
```

### 4. XotBaseWidget
```php
namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\Widget;

abstract class XotBaseWidget extends Widget
{
    // Implementazione base per tutti i widget Filament
}
```

## Best Practices

### 1. Estensione delle Classi
```php
// ❌ NON FARE QUESTO
use Filament\Resources\Resource;
class UserResource extends Resource { ... }

// ✅ FARE QUESTO
use Modules\Xot\Filament\Resources\XotBaseResource;
class UserResource extends XotBaseResource { ... }
```

### 2. Service Provider
```php
// ❌ NON FARE QUESTO
use Illuminate\Support\ServiceProvider;
class UserServiceProvider extends ServiceProvider { ... }

// ✅ FARE QUESTO
use Modules\Xot\Providers\XotBaseServiceProvider;
class UserServiceProvider extends XotBaseServiceProvider { ... }
```

### 3. Modelli
```php
// ❌ NON FARE QUESTO
use Illuminate\Database\Eloquent\Model;
class User extends Model { ... }

// ✅ FARE QUESTO
use Modules\Xot\Models\XotBaseModel;
class User extends XotBaseModel { ... }
```

## Dipendenze Principali

### Moduli
- **User**: Gestione utenti e autenticazione
- **Lang**: Gestione traduzioni
- **UI**: Componenti interfaccia utente

### Pacchetti
- Laravel Framework
- Filament
- Livewire
- Volt

## Roadmap

### Prossime Feature
1. Miglioramento delle classi base
2. Ottimizzazione delle performance
3. Nuovi trait e interfacce

### Miglioramenti Pianificati
1. Refactoring del codice base
2. Miglioramento della documentazione
3. Ottimizzazione delle query

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
1. Conflitti di estensione
2. Problemi di performance
3. Errori di configurazione

### Soluzioni
1. Verifica la configurazione
2. Controlla i log
3. Consulta la documentazione

## Riferimenti

### Documentazione
- [Laravel](https://laravel.com/docs)
- [Filament](https://filamentphp.com/docs)
- [Livewire](https://livewire.laravel.com/docs)
- [Volt](https://livewire.laravel.com/docs/volt)

### Collegamenti Interni
- [User Module](../User/docs/README.md)
- [Lang Module](../Lang/docs/README.md)
- [UI Module](../UI/docs/README.md)

## Changelog

### [1.0.0] - 2024-03-20
#### Added
- Implementazione iniziale
- Classi base
- Service provider base
- Integrazione Filament

#### Changed
- Miglioramento performance
- Ottimizzazione query
- Refactoring codice

#### Fixed
- Bug estensione classi
- Problemi di configurazione
- Errori di integrazione

## Best Practices XotBaseResource

> **Regola vincolante:** Se una risorsa estende `XotBaseResource`, NON deve mai dichiarare:
> - `protected static ?string $navigationGroup`
> - `protected static ?string $navigationLabel`
> - `public static function table(Table $table): Table`

La configurazione di navigazione e la definizione della tabella sono centralizzate nella classe base o nei provider.

**Checklist:**
- [ ] Nessuna dichiarazione di navigationGroup/navigationLabel/table() nelle risorse che estendono XotBaseResource
- [ ] Configurazione centralizzata e DRY

**Vedi anche:**
- [filament-xotbase-resource-best-practices.mdc](../../../.cursor/rules/filament-xotbase-resource-best-practices.mdc)

## Documentazione Filament

- [Linee Guida per getInfolistSchema](./filament/INFOLIST_SCHEMA_GUIDELINES.md) - Guida completa per l'implementazione corretta del metodo getInfolistSchema, con focus sull'uso delle chiavi stringa negli array 

## Documentazione Service Provider
- [Best Practices nei Service Provider](./providers/service_provider_best_practices.md) - Linee guida sull'utilizzo di GetModulePathByGeneratorAction per una gestione robusta dei percorsi

## Documentazione PHPStan
- [Linee Guida PHPStan Livello 10](./PHPStan/LEVEL10_LINEE_GUIDA.md) - Linee guida dettagliate per rispettare le regole di PHPStan a livello 10

## Documentazione Filament
- [Linee Guida per getInfolistSchema](./filament/INFOLIST_SCHEMA_GUIDELINES.md) - Guida completa per l'implementazione corretta del metodo getInfolistSchema, con focus sull'uso delle chiavi stringa negli array 

## Politica, Filosofia, Religione, Etica, Zen

- **Politica**: Il modulo Xot promuove collaborazione, trasparenza e inclusività, senza discriminazioni.
- **Filosofia**: Minimalismo, chiarezza, miglioramento continuo.
- **Religione**: Laicità, rispetto di tutte le fedi, libertà di pensiero.
- **Etica**: Onestà, rispetto, responsabilità, attenzione all'impatto sociale e ambientale.
- **Zen**: Semplicità, concentrazione sul presente, armonia e serenità nello sviluppo.b6f667c (.)


## Service Provider: Decisione Architetturale (2025-05-13)

Il provider `XotBaseServiceProvider` è progettato per:
- Centralizzare la registrazione di views, config, traduzioni, componenti Blade e Livewire
- Utilizzare actions dedicate (es. `GetModulePathByGeneratorAction`) per garantire robustezza e coerenza
- Gestire fallback e validazioni in modo sicuro
- Favorire l'estendibilità e la coerenza cross-modulo

### Punti di forza
- Coerenza architetturale
- Robustezza nella gestione dei path
- Facilità di estensione per i moduli custom

### Criticità e miglioramenti
- Logging degli errori nei fallback (oggi spesso silenziosi)
- Maggiore chiarezza nei commenti e PHPDoc
- Promuovere l'iniezione delle actions per testabilità

Consulta le [best practices aggiornate](./providers/service_provider_best_practices.md) per dettagli, motivazioni e consigli operativi.

## Backlink
- [Collegamento a docs/links.md della root](../../../../docs/links.md)
- **Zen**: Semplicità, concentrazione sul presente, armonia e serenità nello sviluppo.

## Proprietà fondamentali del ServiceProvider (Laraxot/PTVX)

Tutti i provider dei moduli che estendono XotBaseServiceProvider **devono** dichiarare:
- `protected string $module_dir = __DIR__;`
- `protected string $module_ns = __NAMESPACE__;`
- `public string $name = 'Xot';`

Queste proprietà sono necessarie per:
- La risoluzione automatica dei path delle risorse
- Il corretto namespace per autoloading e publish
- L'identificazione del modulo nelle operazioni di asset publish

### Esempio
```php
class XotServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    public string $name = 'Xot';
}
```

**Motivazione:**  
- Se mancano queste proprietà, alcune risorse potrebbero non essere caricate correttamente.
- La dichiarazione esplicita garantisce portabilità, manutenibilità e coerenza tra tutti i moduli.

**Approfondimenti:**  
- Vedi anche [../../../../docs/provider_overview.md](../../../../docs/provider_overview.md)
- Vedi anche [model_base_rules.md](model_base_rules.md)

## Regola per i file .sh (script shell)

Tutti i file `.sh` (script shell) devono essere posizionati esclusivamente in una sottocartella dedicata chiamata `bashscripts` (ad esempio `docs/bashscripts/`).
Non devono mai trovarsi direttamente nella root di `docs/` o in altre sottocartelle generiche.

**Motivazione:**
- Ordine e reperibilità: tutti gli script shell sono facilmente individuabili e gestibili.
- Sicurezza: si evita l'esecuzione accidentale di script non previsti.
- Coerenza cross-modulo e tra root/moduli.

**Esempio di struttura corretta:**
```
docs/
└── bashscripts/
    ├── deploy.sh
    ├── clear_cache.sh
    └── backup_db.sh
```

**Checklist aggiornata:**
- [x] Nessun file .sh fuori da bashscripts/
- [x] Documentazione aggiornata
- [x] Struttura coerente in tutti i moduli
