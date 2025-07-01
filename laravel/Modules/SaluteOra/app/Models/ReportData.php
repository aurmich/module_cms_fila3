<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ReportData model per i dati dettagliati dei report.
 *
 * @property int $id
 * @property int $report_id
 * @property string $key
 * @property mixed $value
 * @property string $data_type
 * @property string|null $description
 * @property int $order
 * @property string|null $group
 * @property array|null $metadata
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Report $report
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Modules\SaluteOra\Database\Factories\ReportDataFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData inGroup(string $group)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData ofDataType(string $dataType)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData ordered()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereDataType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportData whereValue($value)
 * @mixin \Eloquent
 */
class ReportData extends BaseModel
{
    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'report_id',
        'key',
        'value',
        'data_type',
        'description',
        'order',
        'group',
        'metadata',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'json',
        'metadata' => 'array',
        'order' => 'integer',
    ];

    /**
     * Relazione con il report principale.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Scope per filtrare i dati per gruppo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $group
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope per filtrare i dati per tipo di dato.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $dataType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDataType($query, string $dataType)
    {
        return $query->where('data_type', $dataType);
    }

    /**
     * Scope per ordinare i dati in base al campo order.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Ottiene il valore tipizzato in base al data_type.
     *
     * @return mixed
     */
    public function getTypedValue(): mixed
    {
        return match ($this->data_type) {
            'integer' => (int) $this->value,
            'float' => (float) $this->value,
            'boolean' => (bool) $this->value,
            'date' => new \DateTime($this->value),
            'array', 'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }
}
