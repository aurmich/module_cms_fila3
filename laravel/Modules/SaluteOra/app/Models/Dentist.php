<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;

/**
 * Modello Dentist per la gestione dei dentisti.
 */
class Dentist extends BaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'last_name',
        'email',
        'phone',
        'specialization',
        'license_number',
        'address',
        'city',
        'notes',
        'is_active'
    ];

    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relazione con gli appuntamenti associati al dentista.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Restituisce il nome completo del dentista.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->last_name}";
    }

    /**
     * Filtra i dentisti attivi.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
