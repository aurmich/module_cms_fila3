<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Modello Isee per la gestione dei dati relativi all'ISEE delle pazienti.
 *
 * @property string $id
 * @property string $tenant_id
 * @property string $user_id
 * @property string|null $isee_code
 * @property numeric|null $isee_value
 * @property \Illuminate\Support\Carbon|null $isee_expiry_date
 * @property \Illuminate\Support\Carbon|null $isee_issue_date
 * @property string|null $isee_type
 * @property string|null $isee_document_path
 * @property bool $is_valid
 * @property string|null $notes
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee eligibleForProject()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee tenant(?int $tenantId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereIsValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereIseeCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereIseeDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereIseeExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereIseeIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereIseeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereIseeValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isee withoutTrashed()
 * @mixin \Eloquent
 */
class Isee extends BaseModel
{
    

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tenant_id',
        'patient_id',
        'isee_code',
        'isee_value',
        'isee_expiry_date',
        'isee_issue_date',
        'isee_type',
        'isee_document_path',
        'is_valid',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'isee_value' => 'decimal:2',
            'isee_expiry_date' => 'date',
            'isee_issue_date' => 'date',
            'is_valid' => 'boolean',
        ];
    }

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
     * Verifica se l'ISEE è scaduto.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->isee_expiry_date && $this->isee_expiry_date->isPast();
    }

    /**
     * Verifica se l'ISEE è valido per il progetto (sotto i 20.000 euro).
     *
     * @return bool
     */
    public function isEligibleForProject(): bool
    {
        return $this->isee_value <= 20000 && !$this->isExpired();
    }

    /**
     * Calcola i giorni rimanenti alla scadenza dell'ISEE.
     *
     * @return int
     */
    public function daysUntilExpiry(): int
    {
        return (int) now()->diffInDays($this->isee_expiry_date, false);
    }

    /**
     * Scope per filtrare gli ISEE validi per il progetto (sotto i 20.000 euro).
     *
     * @param \Illuminate\Database\Eloquent\Builder<static> $query
     * @return \Illuminate\Database\Eloquent\Builder<static>
     */
    public function scopeEligibleForProject($query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('isee_value', '<=', 20000)
                     ->where('isee_expiry_date', '>', now());
    }
}
