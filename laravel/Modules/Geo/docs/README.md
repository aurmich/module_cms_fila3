# Geo Module Documentation

## Overview
Il modulo Geo gestisce tutte le informazioni geografiche necessarie per l'applicazione SaluteOra, inclusi gli indirizzi, le localizzazioni e le coordinate geografiche.

## Contenuti
- [Modelli](#modelli)
- [Implementazione](#implementazione)
- [Risorse Filament](#risorse-filament)
- [Servizi](#servizi)

## Modelli
- [Address](models/address.md) - Modello per la gestione degli indirizzi con supporto Schema.org
- [Struttura Indirizzi Italiani](models/address-italian-structure.md) - Specifiche per indirizzi italiani
- [Gestione Regioni e Province](models/regions-provinces.md) - Relazioni geografiche per l'Italia

## Implementazione
- [Trait HasAddresses](traits/has-addresses.md) - Aggiungere funzionalità indirizzi ai modelli
- [Geocoding](services/geocoding.md) - Servizi di geocoding per trasformare indirizzi in coordinate

## Risorse Filament
- [Address Resource](resources/address-resource.md) - Gestione indirizzi nell'admin panel

## Servizi
- [Servizio di Validazione Indirizzi](services/address-validation.md) - Validazione formato indirizzi
- [Integrazione GIS](services/gis-integration.md) - Interazione con sistemi GIS

## Filosofia: Perché estendere BaseModel invece di Model?

Tutti i modelli del modulo Geo **devono** estendere `\Modules\Geo\Models\BaseModel` e **non** direttamente `Illuminate\Database\Eloquent\Model`.

### Motivazioni (Zen, Politica, Religione, Filosofia):
- **Centralizzazione**: BaseModel permette di centralizzare comportamenti comuni (es. fillable, casts, connection, perPage, hidden, ecc.) e policy di sicurezza.
- **Override connection**: imposta la connection `geo` per separare i dati geografici dal resto dell'applicazione (multi-db ready, multi-tenant, backup separati, restore selettivo).
- **DRY**: evita duplicazione di logica e configurazione tra modelli.
- **Estensioni future**: BaseModel può essere esteso con trait (es. caching, search, audit, versioning) senza dover modificare ogni modello.
- **Policy multi-modulo**: garantisce che tutti i modelli Geo siano coerenti e facilmente integrabili con altri moduli (es. Xot, Cms, SaluteOra).
- **Audit e sicurezza**: BaseModel può integrare facilmente logiche di audit trail, soft delete, access control, ecc.
- **Manutenibilità**: ogni modifica a policy, fillable, hidden, connection, ecc. si propaga a tutti i modelli Geo in modo sicuro e tracciabile.

> **Religione**: "Un solo punto di verità per la logica di base dei modelli geografici."
> **Politica**: "Separare i dati geografici dagli altri dati per motivi di sicurezza, performance, backup e governance."
> **Zen**: "La semplicità e la coerenza portano chiarezza e riducono il debito tecnico."

**Regola**: _Se un modello del modulo Geo estende direttamente Model, è un errore critico di architettura._
