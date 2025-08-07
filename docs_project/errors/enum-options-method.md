# Errore: Call to undefined method [Enum]::getOptions()

## Descrizione dell'Errore

Si verifica il seguente errore quando si tenta di utilizzare un metodo inesistente su un enum:

```
Call to undefined method Modules\SaluteOra\Enums\AppointmentType::getOptions()
```

## Causa

L'errore si verifica perché:

1. Il codice tenta di chiamare un metodo `getOptions()` sull'enum `AppointmentType`
2. Questo metodo non è definito nella classe enum
3. In Filament, gli enum che implementano `HasLabel` possono essere utilizzati direttamente con `->options()`

## Soluzione

### Soluzione Corretta

Invece di usare `getOptions()`, passare direttamente la classe enum a `->options()`:

```php
// Errato
->options(AppointmentType::getOptions())

// Corretto
->options(AppointmentType::class)
```

### Perché Funziona

Filament è in grado di gestire automaticamente gli enum che implementano `HasLabel`:
1. Cerca il metodo `getLabel()` per il testo visualizzato
2. Cerca il metodo `getColor()` per il colore (se disponibile)
3. Cerca il metodo `getIcon()` per l'icona (se disponibile)

## Esempio Completo

```php
use Filament\Forms\Components\Select;
use Modules\SaluteOra\Enums\AppointmentType;

// Nel tuo form builder
Select::make('appointment_type')
    ->options(AppointmentType::class)  // Corretto
    ->required()
    ->default(AppointmentType::FOLLOWUP->value),
```

## Best Practice

1. **Non creare metodi `getOptions()`** personalizzati negli enum
2. Utilizzare sempre `->options(NomeEnum::class)`
3. Assicurarsi che l'enum implementi `Filament\Support\Contracts\HasLabel`
4. Definire correttamente i metodi `getLabel()`, `getColor()`, e `getIcon()`

## Riferimenti

- [Documentazione ufficiale di Filament sugli enum](https://filamentphp.com/docs/3.x/forms/fields/select#using-enums)
