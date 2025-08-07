# PSR-4 Autoloading Best Practices

## Regole di Base

1. **Struttura Namespace e Directory**
   - Il namespace deve corrispondere esattamente alla struttura delle directory
   - Base namespace: `Modules\NomeModulo\`
   - Directory base: `./Modules/NomeModulo/`

2. **Posizionamento File**
   - Livewire components: `app/Http/Livewire/`
   - Actions: `app/Actions/`
   - Database factories: `database/factories/`
   - Database seeders: `database/seeders/`

## Esempi Corretti

```php
// File: ./Modules/SaluteOra/app/Http/Livewire/Calendar.php
namespace Modules\SaluteOra\Http\Livewire;

// File: ./Modules/SaluteOra/app/Actions/Calendar/GetCalendarConfigAction.php
namespace Modules\SaluteOra\Actions\Calendar;

// File: ./Modules/Tenant/database/factories/DomainFactory.php
namespace Modules\Tenant\Database\Factories;

// File: ./Modules/Tenant/database/seeders/TenantDatabaseSeeder.php
namespace Modules\Tenant\Database\Seeders;
```

## Errori Comuni e Correzioni

1. **Errore**: File nella directory sbagliata
   ```php
   // ERRATO
   // File: ./Modules/SaluteOra/app/Actions/Calendar/Calendar.php
   namespace Modules\SaluteOra\Http\Livewire;
   
   // CORRETTO
   // File: ./Modules/SaluteOra/app/Http/Livewire/Calendar.php
   namespace Modules\SaluteOra\Http\Livewire;
   ```

2. **Errore**: Directory con maiuscole errate
   ```
   // ERRATO
   ./Modules/Tenant/database/Factories_/
   ./Modules/Tenant/database/Seeders_/
   
   // CORRETTO
   ./Modules/Tenant/database/factories/
   ./Modules/Tenant/database/seeders/
   ```

## Checklist di Verifica

- [ ] Il namespace corrisponde al percorso del file
- [ ] Le directory seguono la convenzione dei nomi corretta (lowercase per factories e seeders)
- [ ] I file sono nella directory corretta in base al loro namespace
- [ ] Non ci sono caratteri speciali o underscore nelle directory standard

## Link Correlati

- [PSR-4 Autoloader Standard](https://www.php-fig.org/psr/psr-4/)
- [Laravel Module Documentation](../README.md)
- [Filament Best Practices](../filament/README.md) 
