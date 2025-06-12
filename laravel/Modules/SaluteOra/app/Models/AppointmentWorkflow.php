<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;
use Carbon\Carbon;

/**
 * AppointmentWorkflow Model
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $patient_id
 * @property int|null $dentist_id
 * @property int|null $appointment_id
 * @property string $current_step
 * @property string $status
 * @property array|null $step_data
 * @property Carbon|null $started_at
 * @property Carbon|null $completed_at
 * @property Carbon|null $last_interaction_at
 * @property array|null $meta
 * @property int|null $created_by
 * @property string|null $session_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Modules\SaluteOra\Models\Appointment|null $appointment
 * @property-read \Modules\SaluteOra\Models\Patient $patient
 * @property-read \Modules\SaluteOra\Models\Dentist|null $dentist
 * @property string $user_id
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow tenant(?int $tenantId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereCurrentStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereDentistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereLastInteractionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereStepData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppointmentWorkflow withoutTrashed()
 * @mixin \Eloquent
 */
class AppointmentWorkflow extends BaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;
    
    /**
     * Gli stati possibili del workflow.
     */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PATIENT_INFO = 'patient_info_completed';
    public const STATUS_DENTIST_SELECTED = 'dentist_selected';
    public const STATUS_DATE_SELECTED = 'date_selected';
    public const STATUS_TREATMENT_DEFINED = 'treatment_defined';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';
    
    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'appointment_id',
        'patient_id',
        'dentist_id',
        'current_step',
        'status',
        'step_data',
        'started_at',
        'completed_at',
        'last_interaction_at',
        'meta',
        'created_by',
        'session_id',
    ];
    
    /**
     * Gli attributi che dovrebbero essere cast a tipi nativi.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'step_data' => 'array',
            'meta' => 'array',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'last_interaction_at' => 'datetime',
        ]);
    }
    
    /**
     * Relazione con l'appuntamento.
     *
     * @return BelongsTo<\Modules\SaluteOra\Models\Appointment, $this>
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
    
    /**
     * Relazione con il paziente.
     *
     * @return BelongsTo<\Modules\SaluteOra\Models\Patient, $this>
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(\Modules\SaluteOra\Models\Patient::class);
    }
    
    /**
     * Relazione con il dentista.
     *
     * @return BelongsTo<\Modules\SaluteOra\Models\Dentist, $this>
     */
    public function dentist(): BelongsTo
    {
        return $this->belongsTo(\Modules\SaluteOra\Models\Dentist::class);
    }
    
    /**
     * Controlla se questo workflow è completato.
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_CONFIRMED && $this->completed_at !== null;
    }
    
    /**
     * Controlla se questo workflow è in corso.
     */
    public function isInProgress(): bool
    {
        return !$this->isCompleted() && $this->status !== self::STATUS_CANCELLED;
    }
    
    /**
     * Controlla se questo workflow è cancellato.
     */
    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }
    
    /**
     * Ottiene l'elenco dei passi del workflow.
     *
     * @return array<string, string>
     */
    public static function getSteps(): array
    {
        return [
            'patient_info' => 'Informazioni Paziente',
            'eligibility_check' => 'Verifica Idoneità',
            'dentist_selection' => 'Selezione Dentista',
            'date_selection' => 'Selezione Data e Ora',
            'treatment_definition' => 'Definizione Trattamento',
            'confirmation' => 'Conferma Appuntamento',
        ];
    }
    
    /**
     * Ottiene l'indice numerico del passo corrente.
     */
    public function getCurrentStepIndex(): int
    {
        $steps = array_keys(self::getSteps());
        $index = array_search($this->current_step, $steps, true);
        return $index !== false ? $index : 0;
    }
    
    /**
     * Verifica se un determinato passo è completato.
     */
    public function isStepCompleted(string $step): bool
    {
        $stepsMap = [
            'patient_info' => self::STATUS_PATIENT_INFO,
            'eligibility_check' => self::STATUS_PATIENT_INFO, // Stato identico dopo verifica idoneità
            'dentist_selection' => self::STATUS_DENTIST_SELECTED,
            'date_selection' => self::STATUS_DATE_SELECTED,
            'treatment_definition' => self::STATUS_TREATMENT_DEFINED,
            'confirmation' => self::STATUS_CONFIRMED,
        ];
        
        if (!isset($stepsMap[$step])) {
            return false;
        }
        
        // Un passo è completato se lo stato del workflow è uguale o "successivo" allo stato mappato per il passo
        $statuses = [
            self::STATUS_DRAFT,
            self::STATUS_PATIENT_INFO,
            self::STATUS_DENTIST_SELECTED,
            self::STATUS_DATE_SELECTED,
            self::STATUS_TREATMENT_DEFINED,
            self::STATUS_CONFIRMED,
        ];
        
        $currentStatusIndex = array_search($this->status, $statuses, true);
        $stepStatusIndex = array_search($stepsMap[$step], $statuses, true);
        
        return $currentStatusIndex !== false && $stepStatusIndex !== false && $currentStatusIndex >= $stepStatusIndex;
    }
}
