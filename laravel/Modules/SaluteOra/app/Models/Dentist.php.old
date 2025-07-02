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
 *
 * @property int $id
 * @property string $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $title
 * @property string|null $specialization
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read string $full_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dentist active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dentist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dentist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dentist onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dentist query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dentist tenant(?int $tenantId = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dentist withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dentist withoutTrashed()
 * @mixin \Eloquent
 */
class Dentist extends BaseModel
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    /**
     * @var list<string>
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
