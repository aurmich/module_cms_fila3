# Problemi Strutturali nel Modulo SaluteMo

Questo documento identifica i principali problemi strutturali nel modulo SaluteMo che devono essere corretti per mantenere la coerenza con le convenzioni del progetto.

## 1. Mancanza della Cartella Filament

### Problema
Il modulo SaluteMo non ha la cartella `Filament` nella directory `app/`:
```
/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteMo/app/Filament/ - NON ESISTE
```

### Impatto
- Impossibilità di implementare componenti Filament per l'interfaccia amministrativa
- Incoerenza con la struttura degli altri moduli
- Violazione delle convenzioni di progetto per le interfacce Filament

### Soluzione
Creare la struttura di directory appropriata:
```bash
mkdir -p /var/www/html/_bases/base_saluteora/laravel/Modules/SaluteMo/app/Filament/{Pages,Resources,Widgets}
```

### Convenzioni da Seguire
Tutte le classi Filament devono essere collocate nella directory `app/Filament/` con il namespace `Modules\SaluteMo\Filament\` e devono estendere le controparti XotBase, non le classi Filament native.

## 2. Estensione Errata del ServiceProvider

### Problema
`SaluteMoServiceProvider.php` estende direttamente `Illuminate\Support\ServiceProvider` invece di `XotBaseServiceProvider`:

```php
// ERRATO
namespace Modules\SaluteMo\Providers;

use Illuminate\Support\ServiceProvider;

class SaluteMoServiceProvider extends ServiceProvider
```

### Impatto
- Violazione della regola fondamentale di non estendere mai direttamente le classi Laravel/Filament
- Mancata coerenza con gli altri moduli che utilizzano XotBaseServiceProvider
- Impossibilità di utilizzare funzionalità specifiche fornite da XotBaseServiceProvider

### Soluzione
Modificare la classe per estendere XotBaseServiceProvider:

```php
// CORRETTO
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class SaluteMoServiceProvider extends XotBaseServiceProvider
```

### Convenzioni da Seguire
Mai estendere direttamente classi Laravel/Filament, ma utilizzare sempre le classi base con prefisso XotBase dal modulo Xot.

## 3. Potenziali Ulteriori Problemi

### Classe HTTP in Posizione Errata
Verificare se esistono classi HTTP posizionate direttamente in `Modules/SaluteMo/Http/` anziché in `Modules/SaluteMo/app/Http/`.

### Namespace Errati
Verificare se ci sono classi che utilizzano il namespace `Modules\SaluteMo\App\` anziché il corretto `Modules\SaluteMo\`.

### File di Vista per Widget
Verificare se eventuali file di vista per widget seguono la convenzione `modulename::filament.widgets.view-name`.

## Collegamenti Correlati
- [Convenzioni dei Namespace](../structure/namespace-conventions.md)
- [Service Provider](../providers/service-provider.md)
- [Struttura HTTP](../structure/http-structure.md)
