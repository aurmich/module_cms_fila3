# Errore: Undefined Constant in Enum

## Descrizione dell'Errore

Si verifica il seguente errore quando si tenta di utilizzare una costante di enumerazione non definita:

```
Undefined constant Modules\SaluteOra\Enums\AppointmentType::CHECKUP
```

## Causa

L'errore si verifica perché:

1. Il codice tenta di utilizzare una costante `CHECKUP` nell'enum `AppointmentType`
2. Questa costante non è definita nell'enum
3. L'enum contiene costanti simili ma con nomi diversi (es. `CONSULTATION`, `CLEANING`, ecc.)

## Soluzione

### Opzione 1: Utilizzare una costante esistente

Se esiste una costante simile che può essere utilizzata come predefinita:

```php
// Sostituire
->default(AppointmentType::CHECKUP->value)

// Con una costante esistente, ad esempio:
->default(AppointmentType::CONSULTATION->value)
```

### Opzione 2: Aggiungere la costante mancante (se necessaria)

Se la costante `CHECKUP` è effettivamente necessaria, va aggiunta all'enum:

```php
enum AppointmentType: string implements HasLabel, HasIcon, HasColor
{
    // ... altre costanti ...
    case CHECKUP = 'checkup';
    
    public function getLabel(): ?string
    {
        return match ($this) {
            // ... altri casi ...
            self::CHECKUP => 'Visita di controllo',
        };
    }
    
    public function getIcon(): ?string
    {
        return match ($this) {
            // ... altri casi ...
            self::CHECKUP => 'heroicon-o-clipboard-document-check',
        };
    }
    
    public function getColor(): string | array | null
    {
        return match ($this) {
            // ... altri casi ...
            self::CHECKUP => 'info',
        };
    }
}
```

## Prevenzione

Per evitare questo tipo di errore in futuro:

1. **Verificare i valori esistenti**: Controllare sempre le costanti definite in un enum prima di utilizzarlo
2. **Utilizzare l'autocompletamento**: L'IDE mostrerà solo le costanti definite
3. **Documentare gli enum**: Aggiungere documentazione sulle costanti disponibili
4. **Utilizzare costanti anziché stringhe**: Questo permette di rilevare errori in fase di compilazione

## Best Practice

1. **Mantenere una mappa delle costanti**: Aggiungere un metodo statico che restituisca tutte le costanti disponibili
   ```php
   public static function values(): array
   {
       return array_column(self::cases(), 'value');
   }
   ```

2. **Validare i valori**: Aggiungere un metodo per verificare se un valore è valido
   ```php
   public static function isValid(string $value): bool
   {
       return in_array($value, self::values(), true);
   }
   ```

3. **Documentare ogni costante** con il suo scopo e utilizzo
