# Best Practice: Alias per Import di Classi Base di Framework

## Regola
Quando si importa una classe base di un framework (es. Filament, Laravel) che ha lo stesso nome di una classe locale o che si intende estendere, **usare sempre un alias esplicito** che ne indichi la provenienza.

## Motivazione
- **Chiarezza**: È subito evidente che si tratta della classe originale del framework.
- **Prevenzione conflitti**: Evita ambiguità tra namespace e possibili errori di override.
- **Manutenibilità**: Facilita il refactoring e l’onboarding di nuovi sviluppatori.
- **Uniformità**: Rende la codebase coerente tra tutti i moduli.

## Esempio
```php
use Filament\Pages\Dashboard as FilamentDashboard;

class Dashboard extends FilamentDashboard
{
    // ...
}
```

## Politica di Progetto
- Tutte le classi base di framework esterne vanno importate con alias esplicito se:
  - Si estende/override una classe con lo stesso nome
  - Si vuole evitare ambiguità tra namespace
  - Si vuole rendere il codice autoesplicativo

## Religione e Zen
- "Non avrai altro Dashboard all’infuori di FilamentDashboard quando usi la base del framework."
- La chiarezza nel codice porta serenità, previene bug e facilita la collaborazione.

## Checklist
- [x] Import delle classi base di framework sempre con alias esplicito
- [x] Documentazione aggiornata in docs/
- [x] Correzione dei file che non rispettano questa regola

## Collegamenti
- [laravel12] Regole di naming e clean code
- [filament-best-practices] Uniformità tra moduli
