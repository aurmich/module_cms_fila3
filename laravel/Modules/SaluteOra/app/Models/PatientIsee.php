<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

/**
 * PatientIsee Model - wrapper per Isee con mapping campi specifici pazienti.
 *
 * @property int $id
 * @property int $patient_id
 * @property float|null $value
 * @property float|null $isee_value Alias for value
 * @property \Carbon\Carbon|null $valid_until
 * @property \Carbon\Carbon|null $isee_expiry_date Alias for valid_until
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Patient $patient
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIsee eligibleForProject()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIsee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIsee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIsee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIsee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIsee tenant(?int $tenantId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIsee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientIsee withoutTrashed()
 * @mixin \Eloquent
 */
class PatientIsee extends Isee
{
    /**
     * Mapping dei campi per compatibilità.
     * 
     * @var array<string, string>
     */
    protected $fieldMapping = [
        'value' => 'isee_value',
        'valid_until' => 'isee_expiry_date',
        'verified' => 'is_valid',
        'verification_date' => 'isee_issue_date',
    ];

    /**
     * Override getAttribute per mappare i campi legacy.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (isset($this->fieldMapping[$key])) {
            return parent::getAttribute($this->fieldMapping[$key]);
        }

        return parent::getAttribute($key);
    }

    /**
     * Override setAttribute per mappare i campi legacy.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($key, $value): static
    {
        if (isset($this->fieldMapping[$key])) {
            parent::setAttribute($this->fieldMapping[$key], $value);
            return $this;
        }

        parent::setAttribute($key, $value);
        return $this;
    }
} 