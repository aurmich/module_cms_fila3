# Stati e Transizioni

## Struttura delle Directory
Gli stati e le transizioni devono essere organizzati secondo la seguente struttura:

```
app/States/
  ├── User/
  │   ├── Transitions/
  │   │   ├── PendingToActive.php
  │   │   ├── PendingToRejected.php
  │   │   └── ...
  │   ├── UserState.php
  │   ├── Pending.php
  │   ├── Active.php
  │   └── ...
```

## Convenzioni di Nomenclatura
- Le classi di stato devono essere nominate in modo descrittivo (es. `Pending`, `Active`, `Rejected`)
- Le classi di transizione devono seguire il pattern `FromStateToState` (es. `PendingToActive`)
- Tutte le classi devono essere nel namespace corretto: `Modules\SaluteOra\States\User`

## Implementazione delle Transizioni
Le classi di transizione devono:
1. Estendere la classe base `Transition` di Spatie
2. Implementare il costruttore che accetta lo stato di partenza
3. Implementare il metodo `canTransition()` per la logica di validazione
4. Implementare il metodo `handle()` per la logica di transizione

## Best Practices
- Utilizzare il trait `HasStates` nel modello
- Definire le transizioni consentite nel metodo `config()` della classe di stato
- Mantenere la logica di transizione semplice e atomica
- Documentare le condizioni di transizione nel metodo `canTransition()`

## Collegamenti
- [Documentazione Spatie Model States](https://spatie.be/docs/laravel-model-states)
- [Regole Generali Stati](../Xot/docs/STATES.md) 
