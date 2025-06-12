<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Pregnancy;
use Modules\Tenant\Traits\BelongsToTenant;

/**
 * Modello Treatment per la gestione dei trattamenti odontoiatrici.
 *
 * @property int $id
 * @property int|null $tenant_id
 * @property int $patient_id
 * @property int|null $dentist_id
 * @property int|null $appointment_id
 * @property string $type
 * @property string|null $description
 * @property string|null $notes
 * @property string $status
 * @property \Carbon\Carbon|null $start_date
 * @property \Carbon\Carbon|null $end_date
 * @property float|null $cost
 * @property bool $is_covered
 * @property bool $is_pregnancy_safe
 * @property array|null $teeth_involved
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read Patient $patient
 * @property-read Dentist|null $dentist
 * @property-read Appointment|null $appointment
 * @property string $user_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment completed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment covered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment inProgress()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment safeForPregnancy()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment tenant(?int $tenantId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereDentistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereIsCovered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereIsPregnancySafe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereTeethInvolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Treatment withoutTrashed()
 * @mixin \Eloquent
 */
class Treatment extends BaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'patient_id',
        'dentist_id',
        'appointment_id',
        'type',
        'description',
        'notes',
        'status',
        'start_date',
        'end_date',
        'cost',
        'is_covered',
        'is_pregnancy_safe',
        'teeth_involved',
    ];

    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'cost' => 'decimal:2',
        'is_covered' => 'boolean',
        'is_pregnancy_safe' => 'boolean',
        'teeth_involved' => 'array',
    ];

    /**
     * Relazione con il paziente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relazione con il dentista.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dentist(): BelongsTo
    {
        return $this->belongsTo(Dentist::class);
    }

    /**
     * Relazione con l'appuntamento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Verifica se il trattamento è completato.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Verifica se il trattamento è in corso.
     *
     * @return bool
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Verifica se il trattamento è coperto dal progetto.
     *
     * @return bool
     */
    public function isCovered(): bool
    {
        return $this->is_covered;
    }

    /**
     * Scope per filtrare i trattamenti completati.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope per filtrare i trattamenti in corso.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope per filtrare i trattamenti coperti dal progetto.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCovered($query)
    {
        return $query->where('is_covered', true);
    }
    
    /**
     * Verifica se il trattamento è sicuro per pazienti in gravidanza.
     *
     * @return bool
     */
    public function isSafeForPregnancy(): bool
    {
        // Lista di tipi di trattamenti sicuri per la gravidanza
        $safeTypes = [
            'check-up',
            'cleaning',
            'emergency',
            'consultation',
            'preventive',
        ];
        
        return in_array($this->type, $safeTypes);
    }
    
    /**
     * Verifica se il paziente associato è in gravidanza.
     *
     * @return bool
     */
    public function hasPregnantPatient(): bool
    {
        if (!$this->patient_id) {
            return false;
        }
        
        return Pregnancy::where('patient_id', $this->patient_id)
            ->whereNull('deleted_at')
            ->exists();
    }
    
    /**
     * Scope per filtrare i trattamenti sicuri per la gravidanza.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSafeForPregnancy($query)
    {
        return $query->whereIn('type', [
            'check-up',
            'cleaning',
            'emergency',
            'consultation',
            'preventive',
        ]);
    }
}