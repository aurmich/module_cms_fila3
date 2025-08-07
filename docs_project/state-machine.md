# State Machine e Transizioni Utente

## Regole e Best Practice

- Ogni transizione dichiarata in `UserState::config()` deve avere una classe dedicata in `/States/User/Transitions/`.
- Se una transizione ha parametri custom (es. `$message`), questi devono essere opzionali (`public ?string $message = ''`) per mantenere compatibilità con le chiamate automatiche di Spatie Model States.
- Documentare ogni errore e soluzione nella cartella docs del modulo coinvolto, con link bidirezionali alle regole generali in Xot.
- Aggiornare sempre `.mdc` in `.windsurf/rules` e `.cursor/rules` quando si introduce una nuova regola o si corregge un errore ricorrente.

## Gestione degli Errori di Signature

- **Errore tipico:** `ArgumentCountError` quando il costruttore di una transizione riceve meno parametri di quelli dichiarati.
- **Soluzione:** Rendere opzionali i parametri custom oppure assicurarsi che tutte le chiamate a `transitionTo` li passino.

## Collegamenti
- [../xot/docs/state-machine.md](../../xot/docs/state-machine.md)
- [../../.windsurf/rules/filament-state-transitions.mdc](../../.windsurf/rules/filament-state-transitions.mdc)
- [../../.cursor/rules/filament-state-transitions.mdc](../../.cursor/rules/filament-state-transitions.mdc)
