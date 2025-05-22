# Modello DoctorRegistrationWorkflow

## Panoramica

Il modello `DoctorRegistrationWorkflow` gestisce il processo di registrazione dei dottori nel sistema. Tiene traccia dello stato corrente del workflow, del passo attuale, dei dati inseriti in ogni passo e di altre informazioni rilevanti come i timestamp e le note di moderazione.

## Struttura del Modello

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Patient\Enums\DoctorRegistrationStatus;

class DoctorRegistrationWorkflow extends Model
{
    use HasUuids;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'doctor_id',
        'current_step',
        'status',
        'started_at',
        'last_interaction_at',
        'completed_at',
        'session_id',
        'moderation_notes',
    ];

    /**
     * Gli attributi che devono essere convertiti in tipi nativi.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'last_interaction_at' => 'datetime',
            'completed_at' => 'datetime',
            'status' => DoctorRegistrationStatus::class,
        ];
    }

    /**
     * Relazione con il dottore.
     *
     * @return BelongsTo
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
```

## Utilizzo dell'Enum DoctorRegistrationStatus

Invece di utilizzare costanti per gli stati del workflow, il modello utilizza l'enum `DoctorRegistrationStatus` per una gestione più robusta e tipo-sicura degli stati:

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
}
```

L'utilizzo dell'enum offre diversi vantaggi:

1. **Tipo-sicurezza**: Il compilatore PHP verifica che vengano utilizzati solo valori validi
2. **Autocompletamento**: Gli IDE possono suggerire i valori disponibili
3. **Refactoring**: Rinominare un caso dell'enum aggiorna automaticamente tutti i riferimenti
4. **Metodi**: Possibilità di aggiungere metodi utili come `getLabel()`

## Campi Principali

I campi principali del modello sono:

| Campo | Tipo | Descrizione |
|-------|------|-------------|
| `id` | UUID | Identificatore univoco del workflow |
| `doctor_id` | UUID | ID del dottore associato al workflow |
| `current_step` | string | Passo corrente del workflow (es. 'personal-info', 'documents', ecc.) |
| `status` | DoctorRegistrationStatus | Stato attuale del workflow |
| `started_at` | datetime | Data e ora di inizio del workflow |
| `last_interaction_at` | datetime | Data e ora dell'ultima interazione |
| `completed_at` | datetime | Data e ora di completamento del workflow (nullable) |
| `session_id` | string | ID della sessione (nullable) |
| `moderation_notes` | text | Note di moderazione (nullable) |
- **last_interaction_at**: Data e ora dell'ultima interazione
- **moderation_notes**: Note di moderazione
- **moderated_at**: Data e ora della moderazione
- **moderated_by**: ID dell'utente che ha moderato il workflow
- **session_id**: ID della sessione

### Metodo `casts()`

Il modello utilizza il metodo `casts()` invece della proprietà `$casts` deprecata per definire i cast degli attributi:

```php
public function casts(): array
{
    return [
        'step_data' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_interaction_at' => 'datetime',
        'moderated_at' => 'datetime',
    ];
}
```

## Relazioni

### Relazione con il Dottore

```php
public function doctor(): BelongsTo
{
    return $this->belongsTo(Doctor::class);
}
```

### Relazione con il Moderatore

```php
public function moderator(): BelongsTo
{
    return $this->belongsTo(\Modules\User\Models\User::class, 'moderated_by');
}
```

## Metodi Helper

Il modello include diversi metodi helper per verificare lo stato del workflow:

```php
public function isCompleted(): bool
public function isPendingModeration(): bool
public function isApproved(): bool
public function isRejected(): bool
```

## Step del Workflow

Nello step `personal_info` del workflow vengono salvati i seguenti campi:
- **first_name**: Nome del dottore
- **last_name**: Cognome del dottore
- **email**: Email del dottore
- **certification**: Certificazione professionale

Il campo `full_name` è stato rimosso per favorire la normalizzazione dei dati e l'invio email immediato.

## Motivazione
- **Normalizzazione**: Separare nome e cognome migliora la qualità e la ricerca dei dati.
- **Invio email**: L'email è ora raccolta subito per poter inviare notifiche e link di continuazione.

## Impatto
- Tutte le logiche che leggono dallo step `personal_info` devono ora aspettarsi i nuovi campi.
- La creazione del modello Doctor e l'invio email sono allineati a questa struttura.

## Collegamenti
- [DoctorResource: Step Informazioni Personali](../filament/resources/doctor-resource.md)
- [DoctorResource.php](../../app/Filament/Resources/DoctorResource.php) 
