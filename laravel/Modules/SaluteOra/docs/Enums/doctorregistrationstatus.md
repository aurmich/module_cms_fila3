# Enum DoctorRegistrationStatus

## Panoramica

L'enum `DoctorRegistrationStatus` rappresenta i possibili stati del workflow di registrazione di un dottore nel sistema. Utilizza le funzionalità degli enum di PHP 8.1+ per garantire una gestione tipo-sicura degli stati.

## Definizione

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Enums;

enum DoctorRegistrationStatus: string
{
    case DRAFT = 'draft';
    case PENDING_MODERATION = 'pending_moderation';
    case MODERATION_APPROVED = 'moderation_approved';
    case MODERATION_REJECTED = 'moderation_rejected';
    case COMPLETED = 'completed';
    
    /**
     * Ottiene l'etichetta leggibile dello stato.
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
     * Determina se lo stato richiede moderazione.
     *
     * @return bool
     */
    public function requiresModeration(): bool
    {
        return $this === self::PENDING_MODERATION;
    }
    
    /**
     * Determina se il workflow è completato.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }
    
    /**
     * Ottiene il colore associato allo stato per l'UI.
     *
     * @return string
     */
    public function getColor(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::PENDING_MODERATION => 'warning',
            self::MODERATION_APPROVED => 'success',
            self::MODERATION_REJECTED => 'danger',
            self::COMPLETED => 'primary',
        };
    }
    
    /**
     * Determina se lo stato è terminale (non può più cambiare).
     *
     * @return bool
     */
    public function isTerminal(): bool
    {
        return in_array($this, [self::COMPLETED, self::MODERATION_REJECTED]);
    }
}
```

## Stati Disponibili

| Stato | Valore | Descrizione | Colore UI |
|-------|--------|-------------|-----------|
| `DRAFT` | `'draft'` | Lo stato iniziale quando il dottore inizia la registrazione ma non l'ha ancora completata | Grigio |
| `PENDING_MODERATION` | `'pending_moderation'` | Il dottore ha completato la registrazione e sta attendendo l'approvazione da parte di un moderatore | Giallo |
| `MODERATION_APPROVED` | `'moderation_approved'` | La registrazione è stata approvata dal moderatore | Verde |
| `MODERATION_REJECTED` | `'moderation_rejected'` | La registrazione è stata rifiutata dal moderatore | Rosso |
| `COMPLETED` | `'completed'` | Il processo di registrazione è stato completato con successo | Blu |

## Metodi Disponibili

### `getLabel()`

Restituisce un'etichetta leggibile per lo stato corrente.

```php
$status = DoctorRegistrationStatus::PENDING_MODERATION;
echo $status->getLabel(); // Output: "In attesa di moderazione"
```

### `requiresModeration()`

Determina se lo stato corrente richiede moderazione.

```php
$status = DoctorRegistrationStatus::PENDING_MODERATION;
if ($status->requiresModeration()) {
    // Notifica agli amministratori che c'è una registrazione da moderare
}
```

### `isCompleted()`

Determina se il workflow è stato completato.

```php
$status = DoctorRegistrationStatus::COMPLETED;
if ($status->isCompleted()) {
    // Esegui azioni post-completamento
}
```

### `getColor()`

Restituisce il colore associato allo stato per l'interfaccia utente.

```php
$status = DoctorRegistrationStatus::MODERATION_APPROVED;
$color = $status->getColor(); // Output: "success"
```

### `isTerminal()`

Determina se lo stato è terminale (non può più cambiare).

```php
$status = DoctorRegistrationStatus::MODERATION_REJECTED;
if ($status->isTerminal()) {
    // Non permettere ulteriori modifiche al workflow
}
```

## Utilizzo nell'Applicazione

### 1. Nel Modello DoctorRegistrationWorkflow

```php
use Modules\Patient\Enums\DoctorRegistrationStatus;

class DoctorRegistrationWorkflow extends Model
{
    protected $casts = [
        'status' => DoctorRegistrationStatus::class,
    ];
}
```

### 2. Nelle Transizioni di Stato

```php
public function approveRegistration(Doctor $doctor): void
{
    $workflow = $doctor->workflow;
    $workflow->status = DoctorRegistrationStatus::MODERATION_APPROVED;
    $workflow->save();
    
    // Invia notifica al dottore
    $doctor->notify(new DoctorRegistrationApprovedNotification());
}
```

### 3. Nei Controller

```php
public function index(Request $request)
{
    $pendingWorkflows = DoctorRegistrationWorkflow::query()
        ->where('status', DoctorRegistrationStatus::PENDING_MODERATION)
        ->get();
        
    return view('patient::admin.doctor-registrations.index', [
        'pendingWorkflows' => $pendingWorkflows,
    ]);
}
```

### 4. Nelle Viste

```php
<span class="badge badge-{{ $workflow->status->getColor() }}">
    {{ $workflow->status->getLabel() }}
</span>
```

## Best Practices

1. **Tipo-Sicurezza**: Utilizzare sempre l'enum anziché stringhe letterali per rappresentare lo stato
2. **Metodi Helper**: Aggiungere metodi all'enum per incapsulare la logica specifica dello stato
3. **Casting**: Utilizzare il casting automatico nel modello per convertire il valore del database nell'enum
4. **Validazione**: Validare gli input utilizzando le regole di enum di Laravel

```php
use Illuminate\Validation\Rules\Enum;

$request->validate([
    'status' => ['required', new Enum(DoctorRegistrationStatus::class)],
]);
```

## Collegamenti

- [Modello DoctorRegistrationWorkflow](../Models/DoctorRegistrationWorkflow.md)
- [Processo di Registrazione dei Dottori](../DOCTOR_REGISTRATION_PROCESS.md)
- [Documentazione PHP sugli Enum](https://www.php.net/manual/en/language.enumerations.php)
