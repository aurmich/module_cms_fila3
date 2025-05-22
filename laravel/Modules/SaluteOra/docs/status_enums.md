# Enum di Stato nel Modulo Patient

## Panoramica

Il modulo Patient utilizza enum PHP 8.1+ per gestire gli stati dei diversi modelli. Questi enum forniscono un modo type-safe per rappresentare stati predefiniti e garantiscono coerenza in tutto il codice.

## Enum Disponibili

### PatientStatus

```php
namespace Modules\Patient\Enums;

enum PatientStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
```

Questo enum rappresenta i possibili stati di un paziente nel sistema:

- `PENDING`: Il paziente è in attesa di approvazione
- `APPROVED`: Il paziente è stato approvato e può accedere al sistema
- `REJECTED`: La registrazione del paziente è stata rifiutata

### DoctorStatus

```php
namespace Modules\Patient\Enums;

enum DoctorStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
```

Questo enum rappresenta i possibili stati di un dottore nel sistema:

- `PENDING`: Il dottore è in attesa di approvazione da parte dell'amministratore
- `APPROVED`: Il dottore è stato approvato e può accedere al sistema
- `REJECTED`: La registrazione del dottore è stata rifiutata

## Utilizzo negli Actions

Gli enum di stato vengono utilizzati nelle azioni di registrazione per impostare lo stato iniziale dell'utente:

### RegisterAction per Pazienti

```php
namespace Modules\Patient\Actions\Patient;

use Modules\Patient\Enums\PatientStatus;

class RegisterAction
{
    public function execute(array $data): Patient
    {
        // Imposta lo stato su APPROVED per i pazienti (approvazione automatica)
        $data['status'] = PatientStatus::APPROVED->value;
        
        // Creazione del paziente
        $patient = Patient::create($data);
        
        // ...
    }
}
```

### RegisterAction per Dottori

```php
namespace Modules\Patient\Actions\Doctor;

use Modules\Patient\Enums\DoctorStatus;

class RegisterAction
{
    public function execute(array $data): Doctor
    {
        // Imposta lo stato su PENDING per i dottori (richiedono moderazione)
        $data['status'] = DoctorStatus::PENDING->value;
        
        // Creazione del dottore
        $doctor = Doctor::create($data);
        
        // ...
    }
}
```

## Vantaggi dell'Utilizzo degli Enum

1. **Type Safety**: Il compilatore PHP può verificare che vengano utilizzati solo valori validi
2. **Autocompletamento**: Gli IDE possono suggerire i valori disponibili
3. **Refactoring Sicuro**: Rinominare un caso enum aggiorna automaticamente tutti i riferimenti
4. **Documentazione Integrata**: Il codice stesso documenta i valori possibili
5. **Evita Magic Strings**: Nessuna stringa hardcoded nel codice

## Best Practices

1. Utilizzare sempre gli enum per rappresentare stati predefiniti invece di stringhe o costanti
2. Accedere al valore dell'enum con `->value` quando necessario per il database
3. Utilizzare l'enum completo per confronti (`if ($status === PatientStatus::APPROVED)`)
4. Non utilizzare mai stringhe hardcoded per gli stati nei controller o nelle viste

## Integrazione con Filament

Per visualizzare correttamente gli stati nelle risorse Filament, utilizzare:

```php
Tables\Columns\TextColumn::make('status')
    ->badge()
    ->formatStateUsing(fn (string $state): string => PatientStatus::from($state)->name)
    ->colors([
        'danger' => 'REJECTED',
        'warning' => 'PENDING',
        'success' => 'APPROVED',
    ]);
```

## Documentazione Correlata

- [Guida agli Enum in PHP 8.1+](/docs/php-enums-guide.md)
- [Filament Form Builder](/docs/filament-form-builder.md)
- [Processo di Registrazione](/docs/registration-widget.md)
