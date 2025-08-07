# Relazione tra Studio e Address

## Problema identificato

Nel modello `Studio` attuale, gli indirizzi sono gestiti come campi diretti nella tabella (`address`, `city`, `postal_code`). Questo approccio è limitante e non consente una gestione avanzata delle informazioni geografiche.

## Soluzione implementata

Abbiamo deciso di utilizzare il modello `Address` dal modulo `Geo` per la gestione degli indirizzi. Questo modello implementa una relazione polimorfica che può essere collegata a qualsiasi altro modello del sistema.

## Vantaggi

- **Standardizzazione**: Utilizzo di un modello comune per tutti gli indirizzi nel sistema
- **Geocodifica**: Accesso a funzionalità avanzate come coordinate geografiche
- **Flessibilità**: Possibilità di associare più indirizzi a uno stesso studio (es. sede principale, filiali)
- **Consistenza**: Struttura uniforme per la rappresentazione degli indirizzi

## Implementazione

### Migrazione Studio

La migrazione di `studios` è stata modificata per rimuovere i campi diretti relativi all'indirizzo:
- Rimossi: `address`, `city`, `postal_code`

Gli indirizzi sono ora gestiti tramite la tabella `addresses` con una relazione polimorfica.

### Modello Studio

> **Nota:** Il modello Studio deve sempre estendere `BaseModel` del modulo SaluteOra (`Modules\SaluteOra\Models\BaseModel`), **mai** direttamente `Illuminate\Database\Eloquent\Model`.
> 
> **Motivazione:**
> - Centralizzazione della logica comune (connessione, cast, factory, ecc.)
> - Coerenza architetturale tra tutti i moduli
> - Facilità di override e personalizzazione
> - DRY: nessuna duplicazione di logica tra modelli
> - Zen: "Un solo BaseModel per domarli tutti"

Il modello `Studio` è stato aggiornato per implementare:

1. Una relazione `morphMany` con il modello `Address`
2. Metodi di utilità per la gestione degli indirizzi
3. Rimozione dei campi diretti relativi all'indirizzo dai `$fillable`

### Utilizzo in Filament

Le risorse Filament sono state aggiornate per:
1. Rimuovere i campi di indirizzo diretti dal form
2. Aggiungere un componente per la gestione della relazione con gli indirizzi
3. Aggiornare le colonne e i filtri nelle tabelle

## Esempi di codice

### Relazione nel modello Studio

```php
/**
 * Ottiene gli indirizzi associati allo studio.
 */
public function addresses(): MorphMany
{
    return $this->morphMany(Address::class, 'model');
}

/**
 * Ottiene l'indirizzo principale dello studio.
 */
public function primaryAddress(): ?Address
{
    return $this->addresses()->where('is_primary', true)->first();
}

/**
 * Ottiene l'indirizzo formattato principale.
 */
public function getFullAddress(): ?string
{
    $address = $this->primaryAddress();
    return $address ? $address->getFormattedAddress() : null;
}
```

## Riferimenti

- [Address Model](/laravel/Modules/Geo/docs/models/address.md)
- [Relazioni Polimorfe](/laravel/docs/polymorphic-relations.md)
- [Geo Module Overview](/laravel/Modules/Geo/docs/README.md)
