# Gestione Indirizzi per il Modello Studio

## Introduzione

Per migliorare la coerenza dei dati e seguire il principio DRY (Don't Repeat Yourself), abbiamo implementato una relazione polimorfica tra il modello `Studio` e il modello `Address` del modulo Geo. Questo approccio elimina la duplicazione dei campi relativi all'indirizzo e fornisce una gestione più robusta e standardizzata degli indirizzi in tutto il sistema.

## Struttura della Relazione

### Modello Studio

```php
/**
 * Relazione morphMany verso Address (modulo Geo)
 * Lo studio può avere più indirizzi (es. sede legale, operativa, ecc.)
 */
public function addresses()
{
    return $this->morphMany(\Modules\Geo\Models\Address::class, 'model');
}
```

### Utilizzo della Relazione

Ogni studio può avere più indirizzi di tipo diverso (es. sede legale, sede operativa, ecc.), ciascuno gestito tramite il modello `Address` del modulo Geo. Gli indirizzi principali sono identificati dal flag `is_primary`.

```php
// Ottenere l'indirizzo principale di uno studio
$primaryAddress = $studio->addresses()->where('is_primary', true)->first();

// Ottenere tutti gli indirizzi di uno studio
$allAddresses = $studio->addresses;
```

## Modifiche Implementate

### 1. Migrazione della Tabella Studios

Abbiamo rimosso i campi relativi all'indirizzo dalla migrazione della tabella `studios`:

- ❌ `address` (rimosso)
- ❌ `city` (rimosso)
- ❌ `postal_code` (rimosso)

### 2. Risorsa Filament (StudioResource)

Abbiamo aggiornato la risorsa Filament per riflettere la nuova struttura:

- Rimossi i campi diretti per l'indirizzo
- Aggiunta una sezione dedicata per la gestione degli indirizzi tramite relazione
- Aggiornati i filtri e le colonne nella vista elenco

### 3. Interfaccia Utente

La nuova implementazione offre:

- Possibilità di aggiungere più indirizzi per uno studio
- Gestione dei tipi di indirizzo (sede legale, operativa, ecc.)
- Funzionalità per marcare un indirizzo come principale

## Vantaggi

1. **Standardizzazione**: Utilizzo di un unico modello per la gestione degli indirizzi in tutto il sistema
2. **Flessibilità**: Supporto per più indirizzi per ciascuna entità
3. **Manutenibilità**: Riduzione della duplicazione del codice
4. **Coerenza**: Interfaccia utente unificata per la gestione degli indirizzi
5. **Scalabilità**: Facilità di aggiungere nuove funzionalità relative agli indirizzi

## Riferimenti

- [Address Model](/var/www/html/_bases/base_saluteora/laravel/Modules/Geo/app/Models/Address.php)
- [Studio Model](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Models/Studio.php)
- [XotBaseMigration](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/database/migrations/XotBaseMigration.php)
- [Convenzione di Migrazioni in SaluteOra](/var/www/html/_bases/base_saluteora/laravel/Modules/Geo/docs/migration-naming-pattern.md)
