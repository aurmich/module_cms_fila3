<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\User;
use Modules\Tenant\Models\Tenant;

/**
 * Report model per la gestione dei report statistici e analitici.
 * 
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property \Carbon\Carbon $period_start
 * @property \Carbon\Carbon $period_end
 * @property string $status
 * @property int $created_by
 * @property int|null $tenant_id
 * @property array|null $parameters
 * @property \Carbon\Carbon|null $last_generated_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ReportData> $reportData
 * @property-read User $creator
 * @property-read Tenant|null $tenant
 */
class Report extends BaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'period_start',
        'period_end',
        'status',
        'created_by',
        'tenant_id',
        'parameters',
        'last_generated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'period_start' => 'datetime',
            'period_end' => 'datetime',
            'parameters' => 'array',
            'last_generated_at' => 'datetime',
        ]);
    }

    /**
     * Relazione con i dati dettagliati del report.
     *
     * @return HasMany<ReportData>
     */
    public function reportData(): HasMany
    {
        return $this->hasMany(ReportData::class);
    }

    /**
     * Relazione con l'utente che ha creato il report.
     *
     * @return BelongsTo<User, static>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relazione con il tenant.
     *
     * @return BelongsTo<Tenant, static>
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Scope per filtrare i report per tipo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope per filtrare i report per periodo.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInPeriod($query, string $startDate, string $endDate)
    {
        return $query->where('period_start', '>=', $startDate)
                     ->where('period_end', '<=', $endDate);
    }

    /**
     * Scope per filtrare i report per stato.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
