# Namespace vs Struttura File nel Modulo Patient

## Panoramica
Questo documento chiarisce la differenza tra il namespace utilizzato nel codice e la struttura fisica dei file nel modulo Patient. Questa distinzione è fondamentale per evitare errori comuni nello sviluppo.

## Regola Fondamentale

**IMPORTANTE**: Nel progetto il progetto, il segmento `app` è presente nella struttura fisica dei file ma NON nel namespace.

### Esempio:

| Aspetto | Pattern | Esempio |
|---------|---------|---------|
| **Struttura File** | `/var/www/html/[progetto]/laravel/Modules/{ModuleName}/app/{Path}` | `/var/www/html/[progetto]/laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php` |
| **Namespace** | `Modules\{ModuleName}\{Path}` | `Modules\Patient\Filament\Resources\DoctorResource` |

## Casi Specifici

### Risorse Filament

✅ **Corretto**:
- File: `/var/www/html/[progetto]/laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php`
- Namespace: `Modules\Patient\Filament\Resources`

❌ **Errato**:
- File: `/var/www/html/[progetto]/laravel/Modules/Patient/Filament/Resources/DoctorResource.php`
- Namespace: `Modules\Patient\app\Filament\Resources`

### Modelli

✅ **Corretto**:
- File: `/var/www/html/[progetto]/laravel/Modules/Patient/app/Models/Doctor.php`
- Namespace: `Modules\Patient\Models`

❌ **Errato**:
- File: `/var/www/html/[progetto]/laravel/Modules/Patient/Models/Doctor.php`
- Namespace: `Modules\Patient\app\Models`

## Spiegazione Tecnica

Questa struttura è definita nel file `composer.json` del modulo, dove il PSR-4 autoloading è configurato come:

```json
"autoload": {
    "psr-4": {
        "Modules\\SaluteOra\\": "app/",
        "Modules\\SaluteOra\\Database\\Factories\\": "database/factories/",
        "Modules\\SaluteOra\\Database\\Seeders\\": "database/seeders/"
    }
}
```

Questo significa che il namespace `Modules\Patient\` corrisponde alla directory fisica `app/` all'interno del modulo.

## Best Practices

1. **Verifica sempre la struttura fisica** prima di creare nuovi file
2. **Non assumere** che il namespace rifletta esattamente la struttura delle directory
3. **Utilizza gli strumenti di generazione** forniti da Laravel Modules quando possibile
4. **Consulta i file esistenti** come riferimento per la struttura corretta

## Collegamenti Bidirezionali

- [README del Modulo](./README.md) - Panoramica del modulo Patient
- [Convenzioni](./conventions.md) - Convenzioni di codice del modulo
- [Struttura del Progetto](../../Xot/docs/architecture/struttura-progetto.md) - Documentazione generale sulla struttura del progetto
- [Namespace Conventions](../../Xot/docs/namespace-conventions.md) - Convenzioni di namespace nel progetto

# ATTENZIONE: Errore Critico di Struttura Directory

**Non creare mai directory come Enums, Actions, Models, Providers, View direttamente sotto Modules/SaluteOra/**

Tutte le classi PHP devono essere in `app/` per rispettare PSR-4, autoload Composer e le convenzioni Laravel Modules.

- ❌ Sbagliato: `Modules/SaluteOra/Enums/UserType.php`
- ✅ Corretto: `Modules/SaluteOra/app/Enums/UserType.php`

**Motivazione:**
- L'autoload PSR-4 mappa `Modules/SaluteOra/app/` su `Modules\SaluteOra\`
- Se la classe è fuori da `app/`, non viene caricata correttamente, genera errori di namespace, problemi con artisan, test, IDE, refactoring, CI/CD, e strumenti come PHPStan.
- Tutti i generatori di codice, strumenti di analisi, e best practice Laravel/Nwidart si aspettano la struttura standard.

**Regola:**
- Prima di committare, verifica che tutte le classi siano in `app/`
- Consulta sempre [MIGLIORAMENTI_E_CORREZIONI.md](./MIGLIORAMENTI_E_CORREZIONI.md), [CURSOR_RULES.md](./CURSOR_RULES.md), [WINDSURF_RULES.md](./WINDSURF_RULES.md)

# Errore Critico: Struttura Cartelle fuori da app/

## Descrizione dell'Errore

È stato riscontrato un errore ricorrente: la creazione di cartelle come `Enums`, `Actions`, `Models`, `Providers`, `View` direttamente nella root del modulo anziché in `app/`.

### Esempi di path ERRATI:
- `Modules/SaluteOra/Enums/UserType.php`
- `Modules/SaluteOra/Actions/Doctor/RegisterAction.php`
- `Modules/SaluteOra/Models/Doctor.php`
- `Modules/SaluteOra/Providers/ReportingServiceProvider.php`
- `Modules/SaluteOra/View/Components/ReportingChartAssets.php`

### Esempi di path CORRETTI:
- `Modules/SaluteOra/app/Enums/UserType.php`
- `Modules/SaluteOra/app/Actions/Doctor/RegisterAction.php`
- `Modules/SaluteOra/app/Models/Doctor.php`
- `Modules/SaluteOra/app/Providers/ReportingServiceProvider.php`
- `Modules/SaluteOra/app/View/Components/ReportingChartAssets.php`

## Causa
- Errata comprensione della mappatura PSR-4 e della struttura Laravel Modules
- Mancata consultazione delle regole di progetto e delle best practice

## Impatto
- Autoloading rotto
- Namespace incoerenti
- Problemi di refactoring, test, CI/CD
- Difficoltà di manutenzione e onboarding

## Regola Vincolante
- **Tutti i file PHP devono essere in app/**
- Il namespace base del modulo è mappato su app/ tramite PSR-4
- MAI creare cartelle PHP fuori da app/

## Checklist Anti-Errore
- [ ] Prima di creare una cartella/file, verifica che sia sotto app/
- [ ] Controlla sempre la configurazione PSR-4 in composer.json
- [ ] Consulta questa regola e le best practice windsurf/cursor

## Collegamenti
- [filament-namespace-rules.md](./filament-namespace-rules.md)
- [naming-conventions.md](./naming-conventions.md)
- [ENUMS_BEST_PRACTICES.md](./ENUMS_BEST_PRACTICES.md)
- [WINDSURF_RULES.md](./WINDSURF_RULES.md)
- [CURSOR_RULES.md](./CURSOR_RULES.md)

> **Warning:** Ogni errore di struttura va immediatamente corretto e documentato qui e nei file .mdc di regola.

## FAQ/Warning: Namespace errato nei Provider

### Errore tipico

```
Class "Modules\SaluteOra\app\Providers\SaluteOraServiceProvider" not found
```

**Motivo:**
- Namespace dichiarato come `Modules\SaluteOra\app\Providers` invece di `Modules\SaluteOra\Providers`.
- L'autoload PSR-4 mappa `app/` su `Modules\SaluteOra\`.

**Soluzione:**
- Il file deve essere in `app/Providers/SaluteOraServiceProvider.php`
- Il namespace deve essere:
  ```php
  namespace Modules\SaluteOra\Providers;
  ```
- Tutti i riferimenti (config/app.php, moduli, test) devono puntare a `Modules\SaluteOra\Providers\SaluteOraServiceProvider::class`
- Esegui sempre `composer dump-autoload` dopo ogni modifica ai namespace.

**Consulta anche:**
- [MIGLIORAMENTI_E_CORREZIONI.md](./MIGLIORAMENTI_E_CORREZIONI.md)
- [naming-conventions.md](./naming-conventions.md)

## Errori Comuni e Come Evitarli

### 1. File fuori da app/

❌ **ERRATO**:
```
Modules/SaluteOra/Enums/UserType.php
Modules/SaluteOra/Filament/Resources/UserResource.php
```

✅ **CORRETTO**:
```
Modules/SaluteOra/app/Enums/UserType.php
Modules/SaluteOra/app/Filament/Resources/UserResource.php
```

### 2. Namespace errato

❌ **ERRATO**:
```php
namespace Modules\SaluteOra\app\Enums;
namespace Modules\SaluteOra\app\Filament\Resources;
```

✅ **CORRETTO**:
```php
namespace Modules\SaluteOra\Enums;
namespace Modules\SaluteOra\Filament\Resources;
```

### Checklist Anti-Errore

Prima di creare nuovi file o spostare file esistenti:

1. [ ] Verifica che il file sia sotto la directory `app/`
2. [ ] Controlla che il namespace non contenga `app\`
3. [ ] Esegui `composer dump-autoload` dopo ogni modifica
4. [ ] Verifica che l'IDE riconosca correttamente il file
5. [ ] Controlla che i test passino

### Strumenti di Verifica

Per verificare la struttura corretta:

```bash

# Verifica la struttura delle directory
find laravel/Modules/SaluteOra -type f -name "*.php" | grep -v "app/"

# Verifica i namespace
grep -r "namespace Modules\\SaluteOra\\app" laravel/Modules/SaluteOra
```
