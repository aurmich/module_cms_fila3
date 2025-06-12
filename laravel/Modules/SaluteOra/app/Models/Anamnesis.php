<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;
use Modules\Xot\Models\XotBaseModel;

/**
 * 
 *
 * @property int $id
 * @property string $tenant_id
 * @property string $user_id
 * @property array<array-key, mixed>|null $allergies
 * @property array<array-key, mixed>|null $chronic_diseases
 * @property array<array-key, mixed>|null $medications
 * @property array<array-key, mixed>|null $family_history
 * @property array<array-key, mixed>|null $lifestyle
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Patient|null $patient
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis tenant(?int $tenantId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereAllergies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereChronicDiseases($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereFamilyHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereLifestyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereMedications($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Anamnesis withoutTrashed()
 * @mixin \Eloquent
 */
class Anamnesis extends XotBaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'patient_id',
        'allergies',
        'chronic_diseases',
        'medications',
        'family_history',
        'lifestyle',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'allergies' => 'array',
            'chronic_diseases' => 'array',
            'medications' => 'array',
            'family_history' => 'array',
            'lifestyle' => 'array',
        ]);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function hasAllergies(): bool
    {
        return !empty($this->allergies);
    }

    public function hasChronicDiseases(): bool
    {
        return !empty($this->chronic_diseases);
    }

    public function isOnMedications(): bool
    {
        return !empty($this->medications);
    }
}
