# Modulo Xot

### Versione HEAD

## Introduzione
Il modulo Xot è il modulo base che fornisce le classi e le funzionalità fondamentali per gli altri moduli. Gestisce l'integrazione con Filament, Livewire e Volt, fornendo una base solida per lo sviluppo di applicazioni modulari.

## Indice

### Architettura e Componenti Base
- [Architecture](./architecture.md) - Architettura del modulo
- [Base Classes](./base_classes.md) - Classi base
- [Service Providers](./service_providers.md) - Provider di servizi
- [Volt Folio Best Practices](./VOLT_FOLIO_BEST_PRACTICES.md) - Best practices per Volt e Folio
- [Volt Folio Best Practices](./VOLT_FOLIO_BEST_PRACTICES.md) - Best practices per Volt e Folio

- [Volt Folio Best Practices](./VOLT_FOLIO_BEST_PRACTICES.md) - Best practices per Volt e Folio
- [Volt Folio Best Practices](./VOLT_FOLIO_BEST_PRACTICES.md) - Best practices per Volt e Foliob6f667c (.)

- [Volt Folio Best Practices](./VOLT_FOLIO_BEST_PRACTICES.md) - Best practices per Volt e Folio
- [Volt Folio Best Practices](./VOLT_FOLIO_BEST_PRACTICES.md) - Best practices per Volt e Foliob6f667c (.)

### Filament
- [Filament Integration](./filament_integration.md) - Integrazione con Filament
- [Widgets](./widgets.md) - Sistema widget
- [Resources](./resources.md) - Gestione risorse

### Service Providers
- [Provider Structure](./provider_structure.md) - Struttura provider
- [Provider Traits](./provider_traits.md) - Trait per provider
- [Provider Best Practices](./provider_best_practices.md) - Best practices

### Testing e Quality
- [Testing](./testing.md) - Testing e quality assurance (usare Pest come test runner)
- [Best Practices](./BEST-PRACTICES.md) - Linee guida generali
- [Security](./security.md) - Sicurezza e hardening

### Documentazione Tecnica
- [Roadmap](./roadmap.md) - Piano di sviluppo futuro
- [Bottlenecks](./bottlenecks.md) - Analisi performance e ottimizzazioni
- [Module Structure](./MODULE_STRUCTURE.md) - Struttura moduli

### Link Esterni
- [Laravel Framework](https://laravel.com/docs/12.x)
- [Filament Documentation](https://filamentphp.com/docs)
- [Livewire Documentation](https://livewire.laravel.com/docs)

## Note Importanti

### Estensione Classi
- Non estendere mai direttamente le classi di Filament
- Utilizzare sempre le classi base di Xot con prefisso XotBase
- Seguire le convenzioni di naming del modulo

### Trait e Service Provider
- I trait per i provider devono essere in `Providers/Traits/`
- Seguire la struttura esistente per nuovi trait
- Documentare sempre l'uso dei trait

### Traduzioni
- Utilizzare il LangServiceProvider per le traduzioni
- Non usare ->label() direttamente
- Struttura corretta: 'source' => ['label'=>'Sorgente']

## Esempi

### Service Provider
```php
use Xot\XotBaseServiceProvider;

class CustomServiceProvider extends XotBaseServiceProvider
{
    // Implementazione
}
```

### Widget Base
```php
use Xot\Filament\Widgets\XotBaseWidget;

class CustomWidget extends XotBaseWidget
{
    // Implementazione
}
```

## Dipendenze
- Laravel Framework
- Filament
- Livewire
- Volt
- Folio

## Utilizzo
Il modulo Xot fornisce funzionalità base attraverso:
- Classi base estensibili
- Service provider modulari
- Integrazione Filament
- Sistema widget
- Gestione risorse

## Panoramica
Il modulo Xot è il cuore dell'architettura dell'applicazione. Fornisce le classi base, i trait e le interfacce fondamentali utilizzate da tutti gli altri moduli.

### Versione HEAD


### Versione Incoming

##> **Collegamenti correlati**
> - [README.md documentazione generale](../../docs/README.md)
> - [README.md toolkit bashscripts](../../bashscripts/docs/README.md)
> - [README.md modulo GDPR](../Gdpr/docs/README.md)
> - [README.md modulo User](../User/docs/README.md)
> - [README.md modulo Lang](../Lang/docs/README.md)
> - [README.md modulo CMS](../../laravel/Modules/Cms/docs/README.md) <!-- TODO: documento non presente -->
> - [README.md modulo Reporting](../../laravel/Modules/Reporting/docs/README.md) <!-- TODO: documento non presente -->
> - [README.md modulo Chart](../../laravel/Modules/Chart/docs/README.md) <!-- TODO: documento non presente -->
> - [README.md modulo UI](../UI/docs/README.md)
> - [README.md modulo Xot](../Xot/docs/README.md)
> - [Collegamenti documentazione centrale](../../docs/collegamenti-documentazione.md)


---

## Collegamenti Principali

### Documentazione Core
- [Struttura del Modulo](./structure.md)
- [Base Classes](./base-classes.md)
- [Service Provider](./SERVICE-PROVIDER-BEST-PRACTICES.md)
- [Filament Integration](./FILAMENT_BEST_PRACTICES.md)
- [Module Structure](./MODULE_STRUCTURE.md)

### Integrazioni
- [Integrazione con User](../User/docs/README.md)
- [Integrazione con Lang](../Lang/docs/README.md)
- [Integrazione con UI](../UI/docs/README.md)

### Best Practices
- [Best Practices Generali](./BEST-PRACTICES.md)
- [Convenzioni Namespace](./namespace-conventions.md)
- [PHPStan Fixes](./phpstan-fixes.md)
- [Risoluzione Conflitti](./RISOLUZIONE_CONFLITTI_MERGE.md)

### Testing e Qualità
- [PHPStan Level 9](./PHPSTAN_LEVEL9_FIXES.md)
- [PHPStan Level 10](./PHPSTAN_LEVEL10_FIXES.md)
- [Testing Best Practices](./testing-best-practices.md)

## Struttura del Modulo

```
Modules/Xot/
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
4. Esegui i test con Pest:
   ```bash
   pest
   ```

> Tutti i nuovi test devono essere scritti con [Pest](https://pestphp.com/). Non usare più PHPUnit direttamente.

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
### Versione HEAD


### Versione Incoming
# Modulo Xot - Documentazione Core

## Introduzione
Il modulo Xot è il cuore dell'architettura modulare del sistema. Fornisce le funzionalità di base e le convenzioni utilizzate da tutti gli altri moduli.

## Indice

### Architettura
- [Struttura del Modulo](./MODULE-STRUCTURE.md)
- [Convenzioni dei Namespace](./NAMESPACE-CONVENTIONS.md)
- [Convenzioni di Naming](./NAMING-CONVENTIONS.md)
- [Struttura delle Directory](./DIRECTORY-STRUCTURE-GUIDE.md)

### Sviluppo
- [Guida PHPStan](./phpstan/README.md)
- [Gestione Traduzioni](./TRANSLATIONS-BEST-PRACTICES.md)
- [Gestione Conflitti](./conflicts/README.md)
- [Filament Tables](./FILAMENT-TABLES.md)

### Integrazione
- [Service Provider](./provider.md)
- [Route Service Provider](./ROUTE-SERVICE-PROVIDER.md)
- [Assets](./assets.md)
- [Configurazione](./config.md)

### Best Practices
- [Documentazione](./DOCUMENTATION-GUIDELINES.md)
- [Code Standards](./CODE-STANDARDS.md)
- [Gestione Pacchetti](./packages.md)

## Collegamenti alla Documentazione Root
- [Roadmap Generale](/docs/roadmap.md)
- [Architettura Generale](/docs/ARCHITECTURE.md)
- [Documentazione Tecnica](/docs/TECHNICAL.md)

## Panoramica
Il modulo Xot fornisce le funzionalità base e le utilities utilizzate da tutti gli altri moduli dell'applicazione.

## Componenti Principali

### XotBaseResource
Classe base per tutte le risorse Filament. Gestisce:
- Navigazione automatica
- Traduzioni
- Permessi base
- Configurazioni comuni

### XotBasePage
Classe base per tutte le pagine Filament. Fornisce:
- Layout standard
- Gestione permessi
- Integrazione con il sistema di traduzioni
- Funzionalità comuni

### XotBaseModel
Modello base con funzionalità comuni:
- Soft delete
- Timestamp automatici
- Relazioni standard
- Metodi utility

## Servizi

### LangService
Gestisce le traduzioni dell'applicazione:
- Caricamento automatico
- Fallback configurabile
- Cache delle traduzioni
- Supporto per più lingue

### PermissionService
Gestisce i permessi dell'applicazione:
- Controllo accessi
- Ruoli e capacità
- Cache dei permessi
- Integrazione con Gate

## Traits

### HasPermissions
Trait per la gestione dei permessi nei modelli:
- Verifica permessi
- Assegnazione ruoli
- Sincronizzazione permessi

### HasTranslations
Trait per la gestione delle traduzioni nei modelli:
- Campi traducibili
- Fallback automatico
- Cache delle traduzioni

## Configurazione
Il modulo è configurabile tramite:
- `config/xot.php`
- Environment variables
- Service providers

## Best Practices
1. Estendere sempre le classi base appropriate
2. Utilizzare i traits forniti
3. Seguire le convenzioni di naming
4. Mantenere la documentazione aggiornata

## Directory Principali
- `Abstracts/`: Classi base e interfacce
- `Helpers/`: Utility globali
- `Http/`: Middleware e controller base
- `config/`: Configurazioni condivise

## Funzionalità Chiave
1. **Helper Globali**
   - Manipolazione stringhe/array
   - Utility date e tempi
   - Helper database
   - Funzioni sicurezza

2. **Astrazioni Base**
   - Interfacce comuni
   - Classi base per modelli/controller
   - Trait riutilizzabili

3. **Quality Assurance**
   - PHP Insights
   - PHPStan
   - PHPMD
   - Psalm
   - Rector
   - PHP CS Fixer

## Utilizzo
1. Estendere le classi base per nuovi modelli/controller
2. Utilizzare gli helper per funzionalità comuni
3. Seguire gli standard di codice definiti

## Documentazione Dettagliata
- `/docs/filament/`: Integrazione Filament
- `/docs/model/`: Gestione modelli
- `/docs/service/`: Servizi disponibili
- `/docs/activity/`: Sistema di logging

## Documentazione PHPStan

- [Linee Guida PHPStan Livello 10](./PHPStan/LEVEL10_LINEE_GUIDA.md) - Linee guida dettagliate per rispettare le regole di PHPStan a livello 10

## Documentazione Filament

- [Linee Guida per getInfolistSchema](./filament/INFOLIST_SCHEMA_GUIDELINES.md) - Guida completa per l'implementazione corretta del metodo getInfolistSchema, con focus sull'uso delle chiavi stringa negli array 

---

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

## Regole Generali: Eventi e Spatie Laravel Data

- **Pattern consigliato**: Passare agli eventi oggetti che estendono [Spatie Laravel Data](https://spatie.be/docs/laravel-data/v4/introduction) invece di array o primitive.
- **Motivazione**: Garantisce type safety, validazione automatica, serializzazione robusta e coerenza tra eventi, actions, projectors e aggregates.
- **Esempio**:
  ```php
  use Modules\Predict\Datas\BetPlacedData;
  use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

  class BetPlaced extends ShouldBeStored
  {
      public function __construct(
          public BetPlacedData $data
      ) {}
  }
  ```
- **Anti-pattern**: Passare array associativi o primitive agli eventi (es: `new BetPlaced(['user_id' => 1, ...])`).
- **Collegamento**: Vedi anche la sezione corrispondente in Predict: [Pattern e Anti-pattern: Eventi e Spatie Laravel Data](../../Predict/docs/README.md#pattern-e-anti-pattern-eventi-e-spatie-laravel-data)

## Regole Generali: Struttura Cartelle, Aggregates, Projectors, Namespace

- **Tutte le classi di dominio di un modulo vanno sempre in `app/`**. Non usare mai `Domain/` né `App/` nel namespace.
- **Aggregates**: sempre in `app/Aggregates/`.
- **Projectors**: sempre in `app/Projectors/`.
- **Listeners**: NON vanno usati se si usano gli Aggregates di Spatie Event Sourcing.
- **Mai creare la cartella `Domain` nei moduli**.
- **Il namespace corretto è sempre `Modules\<NomeModulo>\<Sottocartella>`**.
- **Pattern e anti-pattern**: documentare sempre pattern corretti e errori comuni, sia qui che nella docs del modulo coinvolto.
- **Ogni bugfix va documentato**:
  - Contesto (versione, ambiente, condizioni di trigger)
  - Test di regressione
  - Commit message standardizzato (es: `fix(predict): descrizione breve`)
  - Categorizzazione per area problematica
- **Collegamento bidirezionale**: vedi anche la sezione [Pattern e Anti-pattern: Struttura Cartelle, Aggregates, Projectors](../../Predict/docs/README.md#pattern-e-anti-pattern-struttura-cartelle-aggregates-projectors) nella docs di Predict.
- **Per la gestione dei dati negli eventi, vedi anche la sezione [Regole Generali: Eventi e Spatie Laravel Data](#regole-generali-eventi-e-spatie-laravel-data)**

## Requisiti

- PHP 8.2+
- Laravel 12.x
- Estensioni PHP: PDO, JSON, cURL
- Database: MySQL 8.0+ o PostgreSQL 13+

## Regole generali per i moduli

- Estendere sempre le classi XotBase per Filament, mai direttamente le classi Filament
- Namespace corretto: Modules\<NomeModulo>\Filament
- Tutte le label, placeholder, help, tooltip, description devono essere gestite tramite i file di traduzione del modulo, mai tramite ->label()
- Consulta anche:
  - [Regole traduzioni Filament](../../Lang/docs/filament-translations.md)
  - [docs SaluteOra](../../SaluteOra/docs/README.md)

## Regole generali per risorse Filament nei moduli

- Tutte le risorse Filament dei moduli devono usare il namespace `Modules\\<NomeModulo>\\Filament\\Resources`.
- Non devono mai dichiarare metodi come `getTableFilters`, `getBulkActions`, `getTableColumns` se estendono XotBaseResource.
- Esempio di applicazione e correzione: vedi [README SaluteOra](../SaluteOra/docs/README.md)

## Errori comuni: path e namespace

- Tutti i file PHP dei moduli devono essere in `app/` (mai nella root modulo)
- Il namespace non deve mai contenere `App` (es: `Modules\<NomeModulo>\Enums\UserType`)
- La struttura fisica e quella logica devono essere coerenti, ma la root del codice è sempre `app/`
- Se trovi file o namespace errati, correggi subito e aggiorna la doc
- Esempio pratico e checklist: vedi [README SaluteOra](../SaluteOra/docs/README.md)

## Regola generale: Icone SVG custom per navigation.icon nei moduli
- Ogni modulo può salvare SVG custom animati in `resources/svg/`, con nome `<modulo>-<icona>.svg` (es. `saluteora-doctor.svg`).
- Nei file di traduzione, la chiave navigation.icon deve essere l'identificatore `<modulo>-<icona>` (es. `'icon' => 'saluteora-doctor'`).
- Gli array vanno sempre in short syntax (`[]`).
- Tutti i file PHP devono iniziare con `declare(strict_types=1);`.
- Esempio:
```php
<?php
declare(strict_types=1);
return [
    'navigation' => [
        'icon' => 'saluteora-doctor',
        // ...
    ],
];
```
- Esempio pratico e doc: vedi [README SaluteOra](../SaluteOra/docs/README.md)

## Regola generale: Stati e workflow con Spatie Model States
- Tutti i campi che rappresentano uno stato (es. user.state, moderation.state) devono usare [spatie/laravel-model-states](https://github.com/spatie/laravel-model-states), **non** enum PHP native.
- Le enum PHP sono ammesse solo per tipi statici (es. UserType), **mai** per workflow, moderazione, pubblicazione, ecc.

### Motivazione
- Gestione delle transizioni tra stati (solo quelle consentite)
- Logica custom per ogni stato (side effect, permessi, validazione)
- Integrazione con Eloquent (cast automatico, query, observer)
- Eventi sulle transizioni
- Best practice per workflow e moderazione

### Esempio pratico
```php
// ERRATO
use Modules\SaluteOra\Enums\UserStateEnum;
protected $casts = [ 'state' => UserState::class ];

// CORRETTO
use Modules\SaluteOra\States\UserState;
protected $casts = [ 'state' => UserState::class ];

// State class
class UserState extends State { ... }
```

### Checklist
- [ ] Nessun campo di stato usa enum PHP
- [ ] Tutti i campi di stato usano Spatie Model States
- [ ] Modelli, risorse, form, policy aggiornati
- [ ] Doc aggiornata

### Errori comuni
- Usare enum PHP per i campi di stato
- Dimenticare di configurare le transizioni
- Non aggiornare la doc

### Link doc
- [README SaluteOra](../../laravel/Modules/SaluteOra/docs/README.md)
- [Spatie Model States](https://github.com/spatie/laravel-model-states)

# Debug Model States (Spatie)

## Esempio di errore reale
```
Undefined array key "Modules\SaluteOra\States\User\Pending"
```
- Stack trace: Spatie\ModelStates\StateCaster::get
- Tipico durante login o istanziazione User

## Checklist di debug
- [ ] Verifica che nessun campo di stato usi enum PHP
- [ ] Tutte le classi di stato esistano e siano nel namespace corretto
- [ ] La mappatura degli stati sia completa
- [ ] I valori nel database corrispondano alle chiavi mappate
- [ ] Doc aggiornata

## Link utili
- [README SaluteOra](../../laravel/Modules/SaluteOra/docs/README.md)
- [Spatie Model States](https://github.com/spatie/laravel-model-states)
