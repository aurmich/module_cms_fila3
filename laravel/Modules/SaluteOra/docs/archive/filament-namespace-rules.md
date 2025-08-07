# Regole Namespace e Directory per Filament Resources

## ⚠️ CORREZIONE IMPORTANTE: Struttura Directory

La struttura corretta per i Filament Resources nel modulo Patient è:

```
laravel/Modules/Patient/
└── app/                    # CORRETTO: Tutti i file PHP vanno in app/
    └── Filament/          
        └── Resources/
            ├── DoctorResource.php
            └── DoctorResource/
                └── Pages/
                    ├── CreateDoctor.php
                    ├── EditDoctor.php
                    └── ListDoctors.php
```

❌ Struttura ERRATA (da non usare):
```
laravel/Modules/Patient/
└── Filament/             # ERRATO: Non mettere i file PHP direttamente qui
    └── Resources/
```

## Spiegazione dell'Errore

### Causa
L'errore deriva da una comprensione errata della struttura dei moduli Laravel. In un modulo:

1. **Tutti i file PHP** devono essere nella directory `app/`
2. La directory `app/` è la radice del namespace del modulo
3. Il namespace `Modules\Patient\Filament` si mappa a `app/Filament/` nel filesystem

### Impatto
Posizionare i file fuori dalla directory `app/` causa:
- Problemi di autoloading
- Namespace non corrispondenti al filesystem
- Potenziali conflitti con altri moduli
- Difficoltà nel mantenimento

## Regole Corrette

1. **Directory**
   - ✅ Usare: `app/Filament/Resources/`
   - ❌ Non usare: `Filament/Resources/`

2. **Namespace**
   ```php
   // ✅ CORRETTO
   namespace Modules\Patient\Filament\Resources;
   // Il namespace rimane lo stesso, ma i file vanno in app/Filament/Resources/
   ```

3. **Percorsi File**
   ```
   // ✅ CORRETTO
   /var/www/html/base_saluteora/laravel/Modules/Patient/app/Filament/Resources/DoctorResource.php
   
   // ❌ ERRATO
   /var/www/html/base_saluteora/laravel/Modules/Patient/Filament/Resources/DoctorResource.php
   ```

## Struttura Completa del Modulo

```
laravel/Modules/Patient/
├── app/                    # Tutti i file PHP vanno qui
│   ├── Filament/          # Resources Filament
│   ├── Http/              # Controllers, Middleware, etc.
│   ├── Models/            # Model classes
│   └── Providers/         # Service Providers
├── config/                # Configurazioni
├── database/              # Migrations, factories, etc.
├── resources/             # Views, lang, etc.
└── routes/                # File delle rotte
```

## Best Practices

1. **Organizzazione File**
   - Mantenere tutti i file PHP in `app/`
   - Seguire la struttura standard di Laravel
   - Rispettare le convenzioni PSR-4

2. **Namespace**
   - Il namespace base è `Modules\Patient`
   - I namespace riflettono la struttura in `app/`
   - Mantenere coerenza tra filesystem e namespace

3. **Autoloading**
   - Configurare correttamente composer.json
   - Rispettare la struttura PSR-4
   - Evitare percorsi personalizzati

## Checklist di Verifica

Prima di creare nuovi file Filament:
- [ ] Verificare che il percorso inizi con `app/`
- [ ] Controllare che il namespace corrisponda al percorso
- [ ] Assicurarsi che la struttura segua le convenzioni Laravel
- [ ] Verificare la configurazione dell'autoloading

## Collegamenti

- [Laravel Module Structure](../../../Xot/docs/module-structure.md)
- [PSR-4 Autoloading](../../../Xot/docs/psr4-autoloading.md)
- [Filament Best Practices](../../../Xot/docs/filament-best-practices.md)

# Errori Ricorrenti e Regola Vincolante

## Errore Tipico
- Creazione di cartelle come Enums, Actions, Models, Providers, View fuori da app/

## Causa
- Errata comprensione della struttura PSR-4 e delle regole Laravel Modules

## Impatto
- Namespace incoerenti, autoloading rotto, problemi di refactoring

## Regola
- Tutti i file PHP devono essere in app/
- Namespace base mappato su app/ tramite PSR-4

## Checklist
- [ ] Verifica sempre la posizione prima di creare file/cartelle
- [ ] Consulta le regole windsurf/cursor

## Collegamenti
- [namespace-vs-file-structure.md](./namespace-vs-file-structure.md)
- [WINDSURF_RULES.md](./WINDSURF_RULES.md)
- [CURSOR_RULES.md](./CURSOR_RULES.md)

## Widget Filament

### Struttura Directory Corretta
```
laravel/Modules/SaluteOra/
└── app/                    
    └── Filament/          
        └── Widgets/
            └── ClinicalStatsWidget.php
```

### Namespace Corretto
```php
namespace Modules\SaluteOra\Filament\Widgets;
```

### Import Corretti per Widget
```php
use Filament\Forms\Set;  // Per i componenti form
use Filament\Widgets\StatsOverview\Stat;  // Per le statistiche
```

### Regole Specifiche per Widget
1. I widget devono essere nella directory `app/Filament/Widgets/`
2. Il namespace deve essere `Modules\SaluteOra\Filament\Widgets`
3. Utilizzare sempre i namespace corretti per i componenti Filament
4. Le traduzioni vanno gestite tramite LangServiceProvider 
