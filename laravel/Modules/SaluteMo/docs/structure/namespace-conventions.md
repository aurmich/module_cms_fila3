# Convenzioni dei Namespace in SaluteMo

## Struttura Corretta
Tutte le classi PHP devono seguire questa struttura di namespace:

```php
namespace Modules\SaluteMo\{Categoria};
```

### Esempi
- Controller: `namespace Modules\SaluteMo\Http\Controllers;`
- Provider: `namespace Modules\SaluteMo\Providers;`
- Models: `namespace Modules\SaluteMo\Models;`
- Filament: `namespace Modules\SaluteMo\Filament;`

## Errori Comuni da Evitare
- ❌ `namespace Modules\SaluteMo\App\{Categoria};` - Errato
- ✅ `namespace Modules\SaluteMo\{Categoria};` - Corretto

## Posizione dei File
Tutte le classi PHP devono essere collocate nella directory `app/` all'interno del modulo, seguendo gli standard di autoloading PSR-4:

```
Modules/
  SaluteMo/
    app/                # Tutto il codice dell'applicazione
      Actions/          # Classi Action
      Console/          # Comandi console
      Exceptions/       # Eccezioni personalizzate
      Filament/         # Risorse Filament, pagine, widget
      Http/             # Controller, Middleware, Request
      Models/           # Modelli Eloquent
      Policies/         # Policy di autorizzazione
      Providers/        # Service provider
      ...
```

## Motivazioni
1. Coerenza con la struttura standard di Laravel
2. Mantenimento della consistenza in tutto il progetto
3. Autoloading più prevedibile
4. Prevenzione di problemi di namespace e autoloading

## Verifica
Dopo aver spostato i file, verificare sempre:
1. Tutti i namespace sono corretti
2. Le rotte puntano alle posizioni corrette dei controller
3. Tutti i test funzionano correttamente

## Collegamenti Correlati
- [Struttura HTTP](./http-structure.md)
- [Convenzioni dei Filament](../filament/structure.md)
