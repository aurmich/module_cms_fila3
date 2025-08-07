# Enum DoctorStatus

## Panoramica

L'enum `DoctorStatus` rappresenta i possibili stati di un dottore nel sistema. Utilizza le funzionalità degli enum di PHP 8.1+ per garantire una gestione tipo-sicura degli stati e fornisce metodi utili per la presentazione e la logica di business.

## Definizione

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Enums;

enum DoctorStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    
    /**
     * Ottiene l'etichetta leggibile dello stato.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return match($this) {
            self::PENDING => 'In attesa',
            self::APPROVED => 'Approvato',
            self::REJECTED => 'Rifiutato',
        };
    }
    
    /**
     * Ottiene il colore associato allo stato per l'UI.
     *
     * @return string
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
     * Determina se il dottore può accedere al sistema.
     *
     * @return bool
     */
    public function canAccess(): bool
    {
        return $this === self::APPROVED;
    }
    
    /**
     * Determina se il dottore è in attesa di approvazione.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this === self::PENDING;
    }
    
    /**
     * Determina se il dottore è stato rifiutato.
     *
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this === self::REJECTED;
    }
}
```

## Stati Disponibili

| Stato | Valore | Descrizione | Colore UI |
|-------|--------|-------------|-----------|
| `PENDING` | `'pending'` | Il dottore è registrato ma in attesa di approvazione | Giallo |
| `APPROVED` | `'approved'` | Il dottore è stato approvato e può accedere al sistema | Verde |
| `REJECTED` | `'rejected'` | La registrazione del dottore è stata rifiutata | Rosso |

## Metodi Disponibili

### `getLabel()`

Restituisce un'etichetta leggibile per lo stato corrente.

```php
$status = DoctorStatus::PENDING;
echo $status->getLabel(); // Output: "In attesa"
```

### `getColor()`

Restituisce il colore associato allo stato per l'interfaccia utente.

```php
$status = DoctorStatus::APPROVED;
$color = $status->getColor(); // Output: "success"
```

### `canAccess()`

Determina se il dottore può accedere al sistema.

```php
$status = DoctorStatus::APPROVED;
if ($status->canAccess()) {
    // Permetti l'accesso al sistema
}
```

### `isPending()`

Determina se il dottore è in attesa di approvazione.

```php
$status = DoctorStatus::PENDING;
if ($status->isPending()) {
    // Mostra messaggio di attesa
}
```

### `isRejected()`

Determina se il dottore è stato rifiutato.

```php
$status = DoctorStatus::REJECTED;
if ($status->isRejected()) {
    // Mostra messaggio di rifiuto
}
```

## Utilizzo nell'Applicazione

### 1. Nel Modello Doctor

```php
use Modules\Patient\Enums\DoctorStatus;

class Doctor extends User
{
    protected $casts = [
        'status' => DoctorStatus::class,
    ];
}
```

### 2. Nelle Policy

```php
public function view(User $user, Doctor $doctor): bool
{
    // Solo i dottori approvati possono essere visualizzati
    return $doctor->status === DoctorStatus::APPROVED;
}
```

### 3. Nei Controller

```php
public function index(Request $request)
{
    $pendingDoctors = Doctor::query()
        ->where('status', DoctorStatus::PENDING)
        ->get();
        
    return view('patient::admin.doctors.index', [
        'pendingDoctors' => $pendingDoctors,
    ]);
}
```

### 4. Nelle Viste

```php
<span class="badge badge-{{ $doctor->status->getColor() }}">
    {{ $doctor->status->getLabel() }}
</span>
```

### 5. Nelle Azioni

```php
public function approveDoctorRegistration(Doctor $doctor): Doctor
{
    $doctor->status = DoctorStatus::APPROVED;
    $doctor->save();
    
    return $doctor;
}
```

## Integrazione con DoctorRegistrationStatus

L'enum `DoctorStatus` è strettamente correlato all'enum `DoctorRegistrationStatus`. Quando lo stato del workflow di registrazione cambia, lo stato del dottore dovrebbe essere aggiornato di conseguenza:

```php
public function updateDoctorStatus(Doctor $doctor, DoctorRegistrationStatus $workflowStatus): void
{
    $doctor->status = match($workflowStatus) {
        DoctorRegistrationStatus::MODERATION_APPROVED => DoctorStatus::APPROVED,
        DoctorRegistrationStatus::MODERATION_REJECTED => DoctorStatus::REJECTED,
        default => DoctorStatus::PENDING,
    };
    
    $doctor->save();
}
```

## Best Practices

1. **Tipo-Sicurezza**: Utilizzare sempre l'enum anziché stringhe letterali per rappresentare lo stato
2. **Metodi Helper**: Aggiungere metodi all'enum per incapsulare la logica specifica dello stato
3. **Casting**: Utilizzare il casting automatico nel modello per convertire il valore del database nell'enum
4. **Validazione**: Validare gli input utilizzando le regole di enum di Laravel

```php
use Illuminate\Validation\Rules\Enum;

$request->validate([
    'status' => ['required', new Enum(DoctorStatus::class)],
]);
```

## Collegamenti

- [Modello Doctor](../Models/Doctor.md)
- [Enum DoctorRegistrationStatus](./DoctorRegistrationStatus.md)
- [Processo di Registrazione dei Dottori](../DOCTOR_REGISTRATION_PROCESS.md)
