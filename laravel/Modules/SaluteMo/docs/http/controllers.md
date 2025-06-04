# Controller nel Modulo SaluteMo

## Struttura e Convenzioni

### Posizione Corretta
Tutti i controller devono essere posizionati nella directory:
```
Modules/SaluteMo/app/Http/Controllers/
```

### Namespace Corretto
```php
namespace Modules\SaluteMo\Http\Controllers;
```

### Errori Comuni
- ❌ `Modules/SaluteMo/Http/Controllers/` - Posizione errata
- ✅ `Modules/SaluteMo/app/Http/Controllers/` - Posizione corretta

- ❌ `namespace Modules\SaluteMo\App\Http\Controllers;` - Namespace errato
- ✅ `namespace Modules\SaluteMo\Http\Controllers;` - Namespace corretto

## Controller API Mobile

### Responsabilità
I controller del modulo SaluteMo sono specificamente progettati per gestire le richieste dalle applicazioni mobili. Questi controller devono:

1. Ottimizzare le risposte per dispositivi mobili
2. Gestire autenticazione con token
3. Supportare il caching lato client
4. Implementare versioning delle API

### Formati di Risposta
Tutte le risposte API devono seguire questa struttura:

```json
{
  "success": true|false,
  "data": {},
  "message": "Messaggio informativo o errore",
  "errors": {} // presente solo in caso di errore
}
```

## Convenzioni di Denominazione

### Nome dei Controller
- Suffisso `Controller` obbligatorio
- Nomi descrittivi della funzionalità
- Singolare per risorse singole, plurale per collezioni

### Nome dei Metodi
- `index()` - Lista risorse
- `show()` - Dettaglio singola risorsa
- `store()` - Creazione risorsa
- `update()` - Aggiornamento risorsa
- `destroy()` - Eliminazione risorsa
- Altri metodi con nomi descrittivi chiari

## Gestione Errori

### Codici HTTP
- 200: Successo
- 201: Creazione risorsa
- 204: Nessun contenuto (eliminazione)
- 400: Errore richiesta
- 401: Non autorizzato
- 403: Vietato
- 404: Non trovato
- 422: Errore validazione
- 500: Errore server

### Standardizzazione Errori
Ogni risposta di errore deve includere un messaggio chiaro e, quando applicabile, dettagli specifici sugli errori di validazione.

## Collegamenti Correlati
- [Struttura HTTP](./http-structure.md)
- [Middleware](./middleware.md)
- [Convenzioni di Namespace](../structure/namespace-conventions.md)
