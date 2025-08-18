# Utilizzo del Trait HasAddress

## Panoramica

Il trait `HasAddress` è un'implementazione del pattern di progettazione Trait per gestire le relazioni con gli indirizzi nei modelli Eloquent. Questo documento descrive come utilizzare il trait nel modulo SaluteOra, con particolare attenzione al modello `Studio`.

## Integrazione del Trait

Il modello `Studio` è stato aggiornato per utilizzare il trait `HasAddress` del modulo Geo. Questo permette di gestire gli indirizzi in modo standardizzato e coerente in tutta l'applicazione.

```php
use Modules\Geo\Models\Traits\HasAddress;

class Studio extends Model
{
    use HasAddress;
    
    // Altri trait e proprietà...
}
```

## Vantaggi dell'Utilizzo del Trait

L'utilizzo del trait `HasAddress` porta numerosi vantaggi:

1. **Riutilizzo del codice**: Elimina la duplicazione di codice tra diversi modelli
2. **Coerenza**: Garantisce un'implementazione uniforme delle relazioni con gli indirizzi
3. **Manutenibilità**: Centralizza la logica degli indirizzi, rendendo più facile aggiornare o correggere il codice
4. **Estensibilità**: Fornisce un'interfaccia standard che può essere facilmente estesa per casi d'uso specifici

## Funzionalità Disponibili

Il trait `HasAddress` fornisce le seguenti funzionalità:

### Relazioni

```php
// Accesso a tutti gli indirizzi
$studio->addresses()->get();

// Accesso all'indirizzo principale
$primaryAddress = $studio->primaryAddress();
```

### Metodi di Utilità

```php
// Ottenere l'indirizzo completo formattato
$formattedAddress = $studio->getFullAddress();

// Ottenere la città dell'indirizzo principale
$city = $studio->getCity();

// Ottenere il CAP dell'indirizzo principale
$postalCode = $studio->getPostalCode();

// Ottenere la provincia dell'indirizzo principale
$province = $studio->getProvince();

// Ottenere la regione dell'indirizzo principale
$region = $studio->getRegion();
```

### Manipolazione degli Indirizzi

```php
// Aggiungere un nuovo indirizzo
$address = $studio->addAddress([
    'route' => 'Via Roma',
    'street_number' => '123',
    'locality' => 'Milano',
    'postal_code' => '20100',
    'is_primary' => true,
]);

// Impostare un indirizzo esistente come principale
$studio->setAsPrimaryAddress($address);

// Aggiornare l'indirizzo principale
$studio->updatePrimaryAddress([
    'route' => 'Via Garibaldi',
    'street_number' => '456',
]);
```

### Query Scope

```php
// Filtrare studi per città
$studiosInMilan = Studio::inCity('Milano')->get();

// Filtrare studi per provincia
$studiosInMilanProvince = Studio::inProvince('Milano')->get();

// Filtrare studi per regione
$studiosInLombardy = Studio::inRegion('Lombardia')->get();

// Filtrare studi per CAP
$studiosInPostalCode = Studio::inPostalCode('20100')->get();
```

## Utilizzo in Filament

Nel contesto delle risorse Filament, il trait `HasAddress` semplifica la gestione dei form e delle viste:

```php
// In StudioResource.php
public static function getFormSchema(): array
{
    return [
        // ... altri campi
        
        'addresses' => Forms\Components\Repeater::make('addresses')
            ->relationship('addresses')
            ->schema([
                'route' => Forms\Components\TextInput::make('route')
                    ->required(),
                'street_number' => Forms\Components\TextInput::make('street_number'),
                'locality' => Forms\Components\TextInput::make('locality')
                    ->required(),
                'postal_code' => Forms\Components\TextInput::make('postal_code'),
                'is_primary' => Forms\Components\Toggle::make('is_primary'),
            ]),
    ];
}
```

## Migrazione dai Metodi Precedenti

Il modello `Studio` precedentemente utilizzava metodi personalizzati per la gestione degli indirizzi:

```php
// Metodi rimossi e sostituiti dal trait HasAddress
public function addresses(): MorphMany
{
    return $this->morphMany(Address::class, 'model');
}

public function primaryAddress(): ?Address
{
    return $this->addresses()->where('is_primary', true)->first();
}

public function getFullAddress(): ?string
{
    $address = $this->primaryAddress();
    return $address ? $address->getFormattedAddress() : null;
}
```

Questi metodi sono stati sostituiti dal trait `HasAddress`, che fornisce una soluzione più completa e standardizzata.

## Considerazioni sulla Performance

- L'utilizzo del trait non comporta alcun degrado delle performance rispetto all'implementazione precedente
- Il trait utilizza relazioni eager loading quando appropriato per ottimizzare le query
- Per carichi di lavoro intensivi, considerare l'utilizzo di caching o altre tecniche di ottimizzazione

## Estensibilità

Il trait `HasAddress` può essere facilmente esteso in casi d'uso specifici:

```php
class Studio extends Model
{
    use HasAddress;
    
    // Estensione con metodi specifici
    public function getAddressesInSameCity(Studio $otherStudio): bool
    {
        return $this->getCity() === $otherStudio->getCity();
    }
}
```

## Riferimenti

- [Trait HasAddress nel modulo Geo](../../../Geo/docs/traits/hasaddress-implementation.md)
- [Modello Address](../../../Geo/docs/models/address.md)
- [Pattern Relazioni Polimorfe](../../../Geo/docs/morphs-relationship-patterns.md)
- [Documentazione Laravel Traits](https://laravel.com/docs/10.x/eloquent-relationships#polymorphic-relationships)