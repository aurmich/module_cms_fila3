# Struttura di Ereditarietà dei Modelli

## Panoramica

In SaluteOra, i modelli seguono una precisa struttura di ereditarietà che permette di riutilizzare funzionalità comuni e mantenere il codice DRY (Don't Repeat Yourself). Questa documentazione illustra la gerarchia delle classi modello e i trait utilizzati.

## Gerarchia dei Modelli User e Doctor

```
Authenticatable (Laravel)
     ↑
BaseUser (Modules\User\Models)
     ↑
   User (Modules\SaluteOra\Models)
     ↑
 Doctor (Modules\SaluteOra\Models)
```

### BaseUser

La classe `BaseUser` è la base per tutti i modelli utente nell'applicazione. Include i seguenti trait:

- `HasApiTokens` - Per l'autenticazione API
- `HasFactory` - Per la creazione di factory
- `HasRoles` - Per la gestione dei ruoli (Spatie Permission)
- `HasUuids` - Per l'utilizzo di UUID come chiavi primarie
- `Notifiable` - Per l'invio di notifiche
- `RelationX` - Per funzionalità di relazione estese
- `HasAuthenticationLogTrait` - Per il logging dell'autenticazione
- `HasTenants` - Per il supporto multi-tenant
- `HasTeams` - Per la gestione dei team
- `HasChildren` - Per il supporto dell'ereditarietà Single Table Inheritance (STI)

### User (SaluteOra)

La classe `User` estende `BaseUser` e può aggiungere funzionalità specifiche per il modulo SaluteOra.

### Doctor

La classe `Doctor` estende `User` e utilizza il pattern Single Table Inheritance (STI) attraverso:

- `HasParent` - Indica che questo modello è figlio di un altro modello nella stessa tabella

## Linee Guida per l'Estensione

1. **Non duplicare i trait**: Quando estendi un modello, non includere trait che sono già presenti nelle classi genitori.
2. **Consulta la gerarchia**: Prima di aggiungere un trait, verifica che non sia già disponibile nella catena di ereditarietà.
3. **Metodi specializzati**: Sovrascrivi i metodi solo quando è necessario un comportamento specifico.
4. **Usa metodi parent**: Quando sovrascrivi un metodo, considera l'utilizzo di `parent::metodo()` per mantenere il comportamento di base.

## Esempio Corretto

```php
<?php

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Parental\HasParent;

class Doctor extends User
{
    use HasParent; // Solo i trait non presenti nella catena di ereditarietà

    // Metodi specifici del dottore...
}
```

## Gestione delle Relazioni

Per le relazioni many-to-many, utilizza il metodo `belongsToManyX` fornito dal trait `RelationX`:

```php
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}
```

Questo garantisce una gestione coerente delle relazioni in tutto il sistema.
