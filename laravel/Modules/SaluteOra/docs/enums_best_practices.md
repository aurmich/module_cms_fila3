# Best Practices per l'Utilizzo degli Enum in PHP 8.2+

## Introduzione

Gli enum (enumerazioni) sono un tipo di dato introdotto in PHP 8.1 che permette di definire un insieme limitato di valori possibili. In questo modulo, utilizziamo gli enum per rappresentare stati, tipi e altre costanti del dominio.

## Definizione degli Enum

### Enum di Base

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Enums;

/**
 * Enum per gli stati del dottore.
 */
enum DoctorStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';
}
```

### Enum con Metodi

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Enums;

/**
 * Enum per gli stati del workflow di registrazione del dottore.
 */
enum DoctorRegistrationStatus: string
{
    /**
     * Bozza - Il processo di registrazione è stato iniziato ma non completato.
     */
    case DRAFT = 'draft';
    
    /**
     * In attesa di moderazione - Il dottore ha completato la registrazione e sta attendendo l'approvazione.
     */
    case PENDING_MODERATION = 'pending_moderation';
    
    /**
     * Approvato dalla moderazione - La registrazione del dottore è stata approvata.
     */
    case MODERATION_APPROVED = 'moderation_approved';
    
    /**
     * Rifiutato dalla moderazione - La registrazione del dottore è stata rifiutata.
     */
    case MODERATION_REJECTED = 'moderation_rejected';
    
    /**
     * Completato - Il processo di registrazione è stato completato con successo.
     */
    case COMPLETED = 'completed';
    
    /**
     * Restituisce una descrizione leggibile dello stato.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return match($this) {
            self::DRAFT => 'Bozza',
            self::PENDING_MODERATION => 'In attesa di moderazione',
            self::MODERATION_APPROVED => 'Approvato',
            self::MODERATION_REJECTED => 'Rifiutato',
            self::COMPLETED => 'Completato',
        };
    }
    
    /**
     * Verifica se lo stato corrente è un stato finale (approvato, rifiutato o completato).
     *
     * @return bool
     */
    public function isFinal(): bool
    {
        return in_array($this, [
            self::MODERATION_APPROVED,
            self::MODERATION_REJECTED,
            self::COMPLETED,
        ]);
    }
}
```

## Utilizzo degli Enum

### In Modelli Eloquent

```php
<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Patient\Enums\DoctorStatus;

class Doctor extends User
{
    // ...
    
    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'status' => DoctorStatus::class,
        ]);
    }
}
```

### In Migrazioni

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Patient\Enums\DoctorStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default(DoctorStatus::INACTIVE->value);
        });
    }
};
```

### In Condizioni

```php
public function isActive(): bool
{
    return $this->status === DoctorStatus::ACTIVE;
}

public function canBeApproved(): bool
{
    return !$this->status->isFinal();
}
```

### In Form Filament

```php
use Filament\Forms\Components\Select;
use Modules\Patient\Enums\DoctorStatus;

Select::make('status')
    ->options(collect(DoctorStatus::cases())->mapWithKeys(fn ($status) => [$status->value => $status->getLabel()]))
    ->required()
```

## Gestione Robusta degli Enum

### Verifica dell'Esistenza della Classe Enum

Quando si utilizza un enum che potrebbe non essere definito (ad esempio in un contesto di sviluppo o test), è importante verificare l'esistenza della classe:

```php
private function getDoctorRegistrationStatus(): string
{
    if (!class_exists(DoctorRegistrationStatus::class)) {
        return 'pending';
    }

    try {
        $cases = DoctorRegistrationStatus::cases();
        foreach ($cases as $case) {
            if (strtolower($case->name) === 'pending') {
                return $case->value;
            }
        }
        return 'pending';
    } catch (\Exception $e) {
        return 'pending';
    }
}
```

### Conversione da Stringa a Enum

```php
public static function fromString(string $value): ?DoctorStatus
{
    foreach (self::cases() as $case) {
        if ($case->value === $value) {
            return $case;
        }
    }
    
    return null;
}
```

### Enum con Valori Localizzati

```php
public function getLocalizedLabel(): string
{
    return match($this) {
        self::DRAFT => __('patient::doctor.status.draft'),
        self::PENDING_MODERATION => __('patient::doctor.status.pending_moderation'),
        self::MODERATION_APPROVED => __('patient::doctor.status.moderation_approved'),
        self::MODERATION_REJECTED => __('patient::doctor.status.moderation_rejected'),
        self::COMPLETED => __('patient::doctor.status.completed'),
    };
}
```

## Errori Comuni e Come Evitarli

### 1. Utilizzo di Stringhe Invece di Enum

```php
// ❌ ERRATO
$doctor->status = 'active';

// ✅ CORRETTO
$doctor->status = DoctorStatus::ACTIVE;
```

### 2. Confronto Errato

```php
// ❌ ERRATO
if ($doctor->status == 'active') { ... }

// ✅ CORRETTO
if ($doctor->status === DoctorStatus::ACTIVE) { ... }
```

### 3. Mancanza di Gestione degli Errori

```php
// ❌ ERRATO
$status = DoctorStatus::from($statusString);

// ✅ CORRETTO
try {
    $status = DoctorStatus::from($statusString);
} catch (\ValueError $e) {
    $status = DoctorStatus::INACTIVE;
}

// Oppure, ancora meglio:
$status = DoctorStatus::tryFrom($statusString) ?? DoctorStatus::INACTIVE;
```

### 4. Mancanza di Documentazione

```php
// ❌ ERRATO
enum DoctorStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}

// ✅ CORRETTO
/**
 * Enum per gli stati del dottore.
 * 
 * @method string getLabel() Restituisce una descrizione leggibile dello stato.
 */
enum DoctorStatus: string
{
    /**
     * Dottore attivo e abilitato a operare.
     */
    case ACTIVE = 'active';
    
    /**
     * Dottore inattivo, non può operare.
     */
    case INACTIVE = 'inactive';
    
    // ...
}
```

## Migrazione da Costanti a Enum

Se stai migrando da costanti a enum, segui questi passaggi:

1. Crea l'enum con gli stessi valori delle costanti
2. Aggiorna il cast nel modello
3. Aggiorna tutte le occorrenze delle costanti con l'enum
4. Aggiorna le migrazioni per utilizzare i valori dell'enum

```php
// Prima
class Doctor extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    
    // ...
}

// Dopo
enum DoctorStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    
    // ...
}

class Doctor extends Model
{
    // ...
    
    protected function casts(): array
    {
        return [
            'status' => DoctorStatus::class,
        ];
    }
}
```

## Conclusione

Gli enum sono uno strumento potente per rappresentare stati e tipi in modo tipo-sicuro. Utilizzandoli correttamente, puoi rendere il tuo codice più robusto, leggibile e manutenibile. Segui le best practices descritte in questo documento per evitare errori comuni e sfruttare al meglio gli enum.

# Best Practice Enum (UserType, Status, ...)

## Obiettivo
Utilizzare SEMPRE enum PHP 8.1+ per tutti i campi "tipo" e "stato" (es. UserType, DoctorStatus, PatientStatus, ecc.), MAI costanti stringa o integer.

## Regole Generali
- Ogni campo che rappresenta uno stato o tipo DEVE essere un enum PHP
- Implementare sempre HasLabel (e HasColor/HasIcon se serve) per compatibilità Filament
- Usare l'enum come cast Eloquent:
  ```php
  protected $casts = [
      'type' => UserType::class,
      'status' => DoctorStatus::class,
  ];
  ```
- In Filament:
  - Usare l'enum direttamente in Select, Radio, CheckboxList, Table/Badge
  - Le label e i colori sono gestiti automaticamente se l'enum implementa HasLabel/HasColor
- MAI usare costanti tipo `public const TYPE_ADMIN = 'admin'` (deprecato)
- Documentare sempre l'uso dell'enum in ogni modulo

## Esempio UserType
```php
use Filament\Support\Contracts\HasLabel;

enum UserType: string implements HasLabel
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';

    public function getLabel(): string
    {
        return match($this) {
            self::ADMIN => 'Amministratore',
            self::DOCTOR => 'Dottore',
            self::PATIENT => 'Paziente',
        };
    }
}
```

## Esempio in Filament
```php
Select::make('type')->options(UserType::class)
TextColumn::make('type')->badge()->color(fn($state) => $state->getColor())
```

## Collegamenti
- [Filament Enums Docs](https://filamentphp.com/docs/3.x/support/enums)
- [ENUM_USER_TYPE.mdc](./Enums/ENUM_USER_TYPE.mdc)
- [SINGLE_TABLE_INHERITANCE.md](./SINGLE_TABLE_INHERITANCE.md)

---
**Questa regola è OBBLIGATORIA per tutti i moduli che gestiscono tipi o stati.**
