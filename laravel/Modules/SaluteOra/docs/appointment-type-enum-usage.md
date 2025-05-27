# Gestione degli Enum in FindDoctorAndAppointmentWidget

## Errore

```
Undefined constant Modules\SaluteOra\Enums\AppointmentType::CHECKUP
```

## Descrizione

L'errore si verifica quando si tenta di utilizzare una costante `CHECKUP` dall'enum `AppointmentType` che non è stata definita. Questo accade nel widget `FindDoctorAndAppointmentWidget` quando si imposta il valore predefinito per il campo `appointment_type`.

## Soluzione

### 1. Verificare l'enum AppointmentType

Assicurarsi che l'enum `AppointmentType` sia definito correttamente in `Modules/SaluteOra/Enums/AppointmentType.php` e che contenga la costante `CHECKUP`.

### 2. Implementazione corretta dell'enum

L'enum dovrebbe essere strutturato come segue:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Enums;

use Filament\Support\Contracts\HasLabel;

enum AppointmentType: string implements HasLabel
{
    case CHECKUP = 'checkup';
    case HYGIENE = 'hygiene';
    case TREATMENT = 'treatment';
    case EMERGENCY = 'emergency';
    case CONSULTATION = 'consultation';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CHECKUP => __('appointment.types.checkup'),
            self::HYGIENE => __('appointment.types.hygiene'),
            self::TREATMENT => __('appointment.types.treatment'),
            self::EMERGENCY => __('appointment.types.emergency'),
            self::CONSULTATION => __('appointment.types.consultation'),
        };
    }
}
```

### 3. Utilizzo corretto nel widget

Nel widget, assicurarsi di utilizzare l'enum in questo modo:

```php
use Modules\SaluteOra\Enums\AppointmentType;

// ...

Select::make('appointment_type')
    ->options(AppointmentType::class)
    ->required()
    ->default(AppointmentType::CHECKUP->value),
```

## Prevenzione

Per prevenire questo tipo di errori in futuro:

1. **Documentare gli enum**: Assicurarsi che tutti gli enum siano documentati e che il loro utilizzo sia chiaro.
2. **Testare gli enum**: Implementare test che verifichino la presenza di tutte le costanti necessarie.
3. **Utilizzare tipi forti**: Utilizzare sempre il tipo enum invece di stringhe letterali per evitare errori di battitura.

## Risorse Correlate

- [Documentazione Ufficiale PHP sugli Enumerazioni](https://www.php.net/manual/en/language.enumerations.php)
- [Documentazione Filament sugli Enums](https://filamentphp.com/docs/3.x/forms/advanced#enums)
