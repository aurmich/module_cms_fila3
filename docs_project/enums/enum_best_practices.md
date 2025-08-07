# Best Practices per l'Utilizzo delle Enum in PHP 8.1+

## Collegamenti correlati
- [Indice documentazione Patient](/laravel/Modules/Patient/docs/INDEX.md)
- [Documentazione DoctorStatus](/laravel/Modules/Patient/docs/Enums/DoctorStatus.md)
- [Documentazione DoctorRegistrationStatus](/laravel/Modules/Patient/docs/Enums/DoctorRegistrationStatus.md)
- [Workflow registrazione dottori](/laravel/Modules/Patient/docs/Models/DoctorRegistrationWorkflow.md)
- [Regole per le traduzioni](/laravel/Modules/Patient/docs/TRANSLATIONS.md)
- [Regola UserType Enum](/laravel/Modules/Patient/docs/Enums/ENUM_USER_TYPE.mdc)
- [Filament Enums Docs](https://filamentphp.com/docs/3.x/support/enums)

## Regola Fondamentale per i Tipi Utente

**È vietato usare costanti stringa per rappresentare i tipi utente (admin, doctor, patient, ecc).**
Utilizzare sempre una enum PHP 8.1+ denominata `UserType` (backed string) e implementare almeno `HasLabel` di Filament.

### Esempio

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

### Checklist
- [ ] Nessuna costante stringa per i tipi utente
- [ ] Enum UserType usata ovunque (model, policy, form, table, ecc)
- [ ] Implementata HasLabel (e HasColor/HasIcon se serve)
- [ ] Cast automatico nel model: `protected $casts = ['type' => UserType::class]`
- [ ] Documentazione aggiornata

---

## Introduzione

Questo documento descrive le best practices per l'utilizzo delle enum in PHP 8.1+ nel modulo Patient. Le enum (enumerazioni) sono un tipo di dato che consente di definire un insieme di costanti con nome, migliorando la leggibilità e la manutenibilità del codice.

## Vantaggi delle Enum in PHP 8.1+

1. **Type Safety**: Le enum forniscono un controllo di tipo a compile-time, riducendo gli errori di runtime
2. **Autocompletamento**: Gli IDE possono fornire suggerimenti per i casi enum
3. **Refactoring Semplificato**: Modificare un'enum aggiorna automaticamente tutti i riferimenti
4. **Documentazione Intrinseca**: Le enum documentano i valori possibili direttamente nel codice
5. **Metodi Helper**: Le enum possono includere metodi per operazioni specifiche sui valori

## Tipi di Enum

### 1. Enum Pure

Le enum pure definiscono un insieme di casi senza valori associati:

```php
enum DoctorType
{
    case GENERAL;
    case SPECIALIST;
    case CONSULTANT;
}
```

### 2. Enum Backed

Le enum backed associano un valore a ciascun caso, utile per l'interazione con database o API:

```php
enum DoctorStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
```

## Implementazione delle Enum

### Definizione

Le enum dovrebbero essere definite in un file dedicato nella directory `Modules/Patient/Enums`:

```php
<?php

namespace Modules\Patient\Enums;

enum DoctorStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
```

### Metodi Helper

Aggiungere metodi helper alle enum per incapsulare la logica specifica:

```php
enum DoctorStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    
    /**
     * Ottiene l'etichetta localizzata per lo stato
     */
    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => __('patient::enums.doctor_status.pending'),
            self::APPROVED => __('patient::enums.doctor_status.approved'),
            self::REJECTED => __('patient::enums.doctor_status.rejected'),
        };
    }
    
    /**
     * Verifica se lo stato consente la modifica dei dati
     */
    public function canEdit(): bool
    {
        return match($this) {
            self::PENDING => true,
            self::APPROVED, self::REJECTED => false,
        };
    }
    
    /**
     * Ottiene il colore associato allo stato per l'UI
     */
    public function getColor(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
        };
    }
    
    /**
     * Ottiene l'icona associata allo stato per l'UI
     */
    public function getIcon(): string
    {
        return match($this) {
            self::PENDING => 'heroicon-o-clock',
            self::APPROVED => 'heroicon-o-check-circle',
            self::REJECTED => 'heroicon-o-x-circle',
        };
    }
}
```

### Metodi Statici

Aggiungere metodi statici per operazioni comuni:

```php
enum DoctorStatus: string
{
    // ... casi enum ...
    
    /**
     * Ottiene tutti i casi come array per select, ecc.
     */
    public static function toArray(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->getLabel(), self::cases())
        );
    }
    
    /**
     * Ottiene tutti i casi come array per Filament select
     */
    public static function toSelectArray(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = [
                'label' => $case->getLabel(),
                'icon' => $case->getIcon(),
                'color' => $case->getColor(),
            ];
        }
        return $result;
    }
}
```

## Utilizzo delle Enum nei Modelli

### Casting Automatico

Utilizzare il casting automatico nei modelli per convertire automaticamente i valori del database in istanze enum:

```php
class Doctor extends User
{
    use HasParent;
    use SoftDeletes;
    
    protected $casts = [
        'status' => DoctorStatus::class,
        // Altri cast...
    ];
}
```

### Utilizzo nei Metodi

Utilizzare le enum nei metodi del modello:

```php
public function isApproved(): bool
{
    return $this->status === DoctorStatus::APPROVED;
}

public function canEditProfile(): bool
{
    return $this->status->canEdit();
}

public function getStatusLabelAttribute(): string
{
    return $this->status->getLabel();
}
```

## Utilizzo delle Enum nelle Migrazioni

Nelle migrazioni, utilizzare i valori delle enum per definire i valori predefiniti:

```php
Schema::table('doctors', function (Blueprint $table) {
    $table->string('status')->default(DoctorStatus::PENDING->value);
});
```

## Utilizzo delle Enum nei Form Filament

### Select con Enum

Utilizzare le enum per popolare i select in Filament:

```php
use Filament\Forms\Components\Select;

Select::make('status')
    ->options(DoctorStatus::toArray())
    ->enum(DoctorStatus::class)
```

### Select Avanzato con Icone e Colori

```php
use Filament\Forms\Components\Select;

Select::make('status')
    ->options(function() {
        $options = [];
        foreach (DoctorStatus::cases() as $status) {
            $options[$status->value] = $status->getLabel();
        }
        return $options;
    })
    ->enum(DoctorStatus::class)
    ->iconPosition('before')
    ->icons(function() {
        $icons = [];
        foreach (DoctorStatus::cases() as $status) {
            $icons[$status->value] = $status->getIcon();
        }
        return $icons;
    })
```

## Utilizzo delle Enum nelle Tabelle Filament

```php
use Filament\Tables\Columns\BadgeColumn;

BadgeColumn::make('status')
    ->formatStateUsing(fn ($state) => $state->getLabel())
    ->colors(fn ($state) => [
        'warning' => $state === DoctorStatus::PENDING,
        'success' => $state === DoctorStatus::APPROVED,
        'danger' => $state === DoctorStatus::REJECTED,
    ])
    ->icons(fn ($state) => [
        'heroicon-o-clock' => $state === DoctorStatus::PENDING,
        'heroicon-o-check-circle' => $state === DoctorStatus::APPROVED,
        'heroicon-o-x-circle' => $state === DoctorStatus::REJECTED,
    ])
```

## Traduzioni per le Enum

Le traduzioni per le enum dovrebbero seguire la convenzione:

```
patient::enums.{enum_name}.{case_value}
```

Esempio di file di traduzione:

```php
// resources/lang/it/patient/enums.php
return [
    'doctor_status' => [
        'pending' => 'In attesa',
        'approved' => 'Approvato',
        'rejected' => 'Rifiutato',
    ],
    'doctor_registration_status' => [
        'draft' => 'Bozza',
        'pending_moderation' => 'In attesa di moderazione',
        'moderation_approved' => 'Moderazione approvata',
        'moderation_rejected' => 'Moderazione rifiutata',
        'completed' => 'Completato',
    ],
];
```

Per maggiori dettagli sulle regole di traduzione, consultare la [documentazione delle traduzioni](/laravel/Modules/Patient/docs/TRANSLATIONS.md).

## Esempi di Enum nel Modulo Patient

### DoctorStatus

L'enum `DoctorStatus` definisce gli stati possibili per un dottore:

```php
enum DoctorStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
```

Per maggiori dettagli, consultare la [documentazione di DoctorStatus](/laravel/Modules/Patient/docs/Enums/DoctorStatus.md).

### DoctorRegistrationStatus

L'enum `DoctorRegistrationStatus` definisce gli stati possibili per il workflow di registrazione di un dottore:

```php
enum DoctorRegistrationStatus: string
{
    case DRAFT = 'draft';
    case PENDING_MODERATION = 'pending_moderation';
    case MODERATION_APPROVED = 'moderation_approved';
    case MODERATION_REJECTED = 'moderation_rejected';
    case COMPLETED = 'completed';
}
```

Per maggiori dettagli, consultare la [documentazione di DoctorRegistrationStatus](/laravel/Modules/Patient/docs/Enums/DoctorRegistrationStatus.md).

## Best Practices

### 1. Utilizzare Enum Backed per Interazione con Database

Utilizzare sempre enum backed (con valori associati) quando si interagisce con database o API:

```php
enum DoctorStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
```

### 2. Incapsulare la Logica negli Enum

Incapsulare la logica specifica dello stato all'interno dell'enum:

```php
public function canTransitionTo(self $newStatus): bool
{
    return match($this) {
        self::PENDING => $newStatus === self::APPROVED || $newStatus === self::REJECTED,
        self::APPROVED, self::REJECTED => false,
    };
}
```

### 3. Utilizzare il Casting Automatico

Utilizzare sempre il casting automatico nei modelli:

```php
protected $casts = [
    'status' => DoctorStatus::class,
];
```

### 4. Documentare le Enum

Documentare chiaramente ogni caso enum e i suoi metodi:

```php
/**
 * Rappresenta lo stato di un dottore nel sistema.
 */
enum DoctorStatus: string
{
    /**
     * Il dottore è in attesa di approvazione.
     */
    case PENDING = 'pending';
    
    /**
     * Il dottore è stato approvato e può accedere al sistema.
     */
    case APPROVED = 'approved';
    
    /**
     * La registrazione del dottore è stata rifiutata.
     */
    case REJECTED = 'rejected';
    
    /**
     * Verifica se lo stato consente la transizione a un nuovo stato.
     */
    public function canTransitionTo(self $newStatus): bool
    {
        // Implementazione...
    }
}
```

### 5. Utilizzare Metodi Helper per l'UI

Aggiungere metodi helper per l'UI:

```php
public function getBadgeColor(): string
{
    return match($this) {
        self::PENDING => 'warning',
        self::APPROVED => 'success',
        self::REJECTED => 'danger',
    };
}
```

## Errori Comuni da Evitare

### 1. Comparazione di Stringhe invece di Enum

**NO**:
```php
if ($doctor->status === 'approved') {
    // ...
}
```

**SÌ**:
```php
if ($doctor->status === DoctorStatus::APPROVED) {
    // ...
}
```

### 2. Mancato Utilizzo del Casting

**NO**:
```php
// Senza casting, $doctor->status è una stringa
$status = $doctor->status;
if ($status === 'approved') {
    // ...
}
```

**SÌ**:
```php
// Con casting, $doctor->status è un'istanza di DoctorStatus
protected $casts = [
    'status' => DoctorStatus::class,
];

if ($doctor->status === DoctorStatus::APPROVED) {
    // ...
}
```

### 3. Logica di Stato Duplicata

**NO**:
```php
// In Controller1.php
if ($doctor->status === DoctorStatus::APPROVED) {
    $canEdit = false;
}

// In Controller2.php
if ($doctor->status === DoctorStatus::APPROVED) {
    $canEdit = false;
}
```

**SÌ**:
```php
// In DoctorStatus.php
public function canEdit(): bool
{
    return match($this) {
        self::PENDING => true,
        self::APPROVED, self::REJECTED => false,
    };
}

// In Controller1.php e Controller2.php
$canEdit = $doctor->status->canEdit();
```

## Conclusione

Le enum in PHP 8.1+ offrono un modo potente e type-safe per gestire stati e valori predefiniti nel codice. Seguendo le best practices descritte in questo documento, è possibile sfruttare appieno i vantaggi delle enum per migliorare la qualità e la manutenibilità del codice nel modulo Patient.

Per ulteriori informazioni sulle enum in PHP 8.1+, consultare la [documentazione ufficiale di PHP](https://www.php.net/manual/en/language.enumerations.php).
