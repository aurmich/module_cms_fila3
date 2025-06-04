# Provider Issues (2025)

## Errore Critico: Estensione Provider Sbagliata

### Situazione
- **NON** si deve mai estendere direttamente un provider Laravel (`Illuminate\Foundation\Support\Providers\EventServiceProvider` o `RouteServiceProvider`).
- Si deve **sempre** estendere la rispettiva classe base Xot (`XotBaseEventServiceProvider`, `XotBaseRouteServiceProvider`).

### Motivazione
- L'estensione diretta dei provider Laravel rompe la catena di ereditarietà, la centralizzazione delle policy, la coerenza e la sicurezza del sistema.
- Si perdono notifiche automatiche, discovery, multi-tenancy, override centralizzati e policy di sicurezza.
- Ogni modulo deve essere plug&play, aggiornabile e refactorabile senza duplicazione.

### Soluzione
- Refactor immediato: sostituire l'estensione con la classe base Xot.
- Documentare la motivazione e la correzione.
- Validare con test e checklist.

---

## Religione, Filosofia, Zen
- "Non avrai altro provider all'infuori di XotBase..."
- La serenità del codice nasce dalla coerenza della catena di ereditarietà.
- Ogni deviazione va documentata e motivata.
- La duplicazione è il male, la centralizzazione è il bene.

---

## Checklist di Correzione
- [x] Verifica che tutti i provider estendano la rispettiva classe base Xot
- [x] Aggiorna la documentazione
- [x] Refactor del codice
- [x] Test di regressione
- [x] Validazione con PHPStan

---

## Esempio Corretto

```php
// EventServiceProvider
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseEventServiceProvider;

class EventServiceProvider extends XotBaseEventServiceProvider {}

// RouteServiceProvider
namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider {}
```
