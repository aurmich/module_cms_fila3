<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Modello Pregnancy per la gestione dei dati relativi alla gravidanza.
 *
 * @property string $id
 * @property string $tenant_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $expected_delivery_date
 * @property int|null $weeks_pregnant
 * @property int|null $trimester
 * @property bool $high_risk
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $last_checkup_date
 * @property \Illuminate\Support\Carbon|null $next_checkup_date
 * @property string|null $healthcare_provider
 * @property string|null $healthcare_facility
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Patient|null $patient
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy tenant(?int $tenantId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereExpectedDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereHealthcareFacility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereHealthcareProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereHighRisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereLastCheckupDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereNextCheckupDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereTrimester($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy whereWeeksPregnant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pregnancy withoutTrashed()
 * @method static \Modules\SaluteOra\Database\Factories\PregnancyFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Pregnancy extends BaseModel
{
    

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'patient_id',
        'expected_delivery_date',
        'weeks_pregnant',
        'trimester',
        'high_risk',
        'notes',
        'last_checkup_date',
        'next_checkup_date',
        'healthcare_provider',
        'healthcare_facility',
    ];

    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expected_delivery_date' => 'date',
        'last_checkup_date' => 'date',
        'next_checkup_date' => 'date',
        'high_risk' => 'boolean',
        'weeks_pregnant' => 'integer',
    ];

    /**
     * Relazione con la paziente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Calcola il trimestre in base alle settimane di gravidanza.
     *
     * @return int
     */
    public function calculateTrimester(): int
    {
        if ($this->weeks_pregnant <= 13) {
            return 1;
        } elseif ($this->weeks_pregnant <= 26) {
            return 2;
        } else {
            return 3;
        }
    }

    /**
     * Aggiorna automaticamente il trimestre quando vengono aggiornate le settimane di gravidanza.
     *
     * @return void
     */
    public function updateTrimester(): void
    {
        $this->trimester = $this->calculateTrimester();
        $this->save();
    }

    /**
     * Verifica se la gravidanza è ad alto rischio.
     *
     * @return bool
     */
    public function isHighRisk(): bool
    {
        return $this->high_risk;
    }

    /**
     * Calcola i giorni rimanenti alla data prevista del parto.
     *
     * @return int
     */
    public function daysUntilDelivery(): int
    {
        return (int) now()->diffInDays($this->expected_delivery_date, false);
    }
}
