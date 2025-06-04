# Specifica Tecnica Providers (Aggiornamento 2025)

## Filosofia, Politica, Religione, Zen

- **Filosofia**: Centralizzazione, coerenza, automazione. Ogni modulo eredita comportamenti e policy dal core Xot, riducendo la duplicazione e garantendo evoluzione uniforme.
- **Politica**: Tutti i provider DEVONO estendere la rispettiva classe base Xot (`XotBaseServiceProvider`, `XotBaseEventServiceProvider`, `XotBaseRouteServiceProvider`). Vietato estendere direttamente provider Laravel. Ogni deviazione va documentata e motivata.
- **Religione**: "Non avrai altro provider all'infuori di XotBase...". La catena di ereditarietà è sacra: solo override motivati e documentati.
- **Zen**: Un solo punto di verità, nessuna duplicazione, serenità del codice, refactoring sicuro, onboarding immediato.

---

## 1. EventServiceProvider

### Struttura File
```
/app/Providers/EventServiceProvider.php
```

### Requisiti
```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseEventServiceProvider;

class EventServiceProvider extends XotBaseEventServiceProvider
{
    // Implementazione specifica del modulo
}
```

### Best Practices
- Estendere **SEMPRE** `XotBaseEventServiceProvider`
- **MAI** estendere `Illuminate\Foundation\Support\Providers\EventServiceProvider`
- Registrare tutti gli eventi del modulo
- Documentare eventi e listener
- Coerenza con altri moduli

### Motivazione
- Ereditarietà centralizzata: tutte le policy di discovery, mapping, override sono gestite dal core
- Facilità di refactoring e aggiornamento
- Riduzione errori e duplicazione

---

## 2. RouteServiceProvider

### Struttura File
```
/app/Providers/RouteServiceProvider.php
```

### Requisiti
```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    // Implementazione specifica del modulo
}
```

### Best Practices
- Estendere **SEMPRE** `XotBaseRouteServiceProvider`
- **MAI** estendere `Illuminate\Foundation\Support\Providers\RouteServiceProvider`
- Configurare correttamente i namespace
- Gestire i middleware
- Documentare le route

### Motivazione
- Gestione centralizzata di namespace, prefissi, middleware, discovery
- Notifiche automatiche in caso di errori di configurazione
- Policy di sicurezza e multi-tenancy

---

## 3. SaluteMoServiceProvider

### Struttura File
```
/app/Providers/SaluteMoServiceProvider.php
```

### Requisiti
```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class SaluteMoServiceProvider extends XotBaseServiceProvider
{
    // Implementazione specifica del modulo
}
```

### Best Practices
- Estendere **SEMPRE** `XotBaseServiceProvider`
- Implementare solo override motivati
- Gestire configurazioni, viste, traduzioni, migrazioni tramite metodi base
- Documentare ogni personalizzazione

---

## Checklist Provider
- [x] Estensione della classe base Xot corretta
- [x] Nessuna estensione diretta di provider Laravel
- [x] Documentazione aggiornata e motivata
- [x] Override solo se necessario e documentato
- [x] Coerenza con altri moduli

---

## Esempi

### EventServiceProvider
```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseEventServiceProvider;

class EventServiceProvider extends XotBaseEventServiceProvider
{
    // Eventi e listener specifici
}
```

### RouteServiceProvider
```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    // Configurazioni specifiche
}
```

### SaluteMoServiceProvider
```php
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class SaluteMoServiceProvider extends XotBaseServiceProvider
{
    // Configurazioni e override specifici
}
```

---

## Note Finali
- Ogni provider deve essere testato e documentato
- Ogni deviazione dalla regola va motivata e linkata in doc
- La serenità del codice nasce dalla coerenza della catena di ereditarietà
