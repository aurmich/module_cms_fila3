# Pattern per l'Utilizzo degli Enum in Filament

## Errore

```
Call to undefined method Modules\SaluteOra\Enums\AppointmentType::getOptions()
```

## Descrizione

Questo errore si verifica quando si tenta di utilizzare un metodo `getOptions()` su un enum che non lo implementa. In Filament, ci sono due modi principali per utilizzare gli enum con i campi Select:

1. **Approccio 1**: Utilizzare direttamente la classe enum (se implementa `Filament\Support\Contracts\HasLabel`)
2. **Approccio 2**: Utilizzare un metodo che restituisce un array di opzioni

## Soluzione

### 1. Utilizzo diretto dell'enum (Approccio consigliato)

Se l'enum implementa `HasLabel`, puoi passare direttamente la classe enum al metodo `options()`:

```php
use Filament\Support\Contracts\HasLabel;

enum AppointmentType: string implements HasLabel
{
    case CHECKUP = 'checkup';
    // ... altri casi ...
    
    public function getLabel(): ?string
    {
        return match($this) {
            self::CHECKUP => 'Checkup',
            // ... altri casi ...
        };
    }
}

// Nel form
Select::make('appointment_type')
    ->options(AppointmentType::class)
    ->required()
    ->default(AppointmentType::CHECKUP->value),
```

### 2. Utilizzo con array di opzioni

Se preferisci utilizzare un metodo personalizzato, assicurati che esista e restituisca un array nel formato corretto:

```php
public static function getOptions(): array
{
    return collect(self::cases())
        ->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()])
        ->toArray();
}
```

## Best Practice

1. **Consistenza**: Scegli un approccio e usalo in modo coerente in tutta l'applicazione
2. **Documentazione**: Documenta il pattern scelto per il team
3. **Test**: Assicurati di testare il comportamento degli enum nei form
4. **Localizzazione**: Utilizza le traduzioni per le etichette quando appropriato

## Risoluzione Problemi

Se incontri ancora problemi:

1. Verifica che l'enum implementi correttamente `HasLabel`
2. Controlla che i valori di default siano validi per l'enum
3. Assicurati che tutte le dipendenze siano correttamente importate

## Riferimenti

- [Documentazione Ufficiale Filament - Enums](https://filamentphp.com/docs/3.x/forms/fields/select#enums)
- [Documentazione PHP sugli Enumerazioni](https://www.php.net/manual/en/language.enumerations.php)
