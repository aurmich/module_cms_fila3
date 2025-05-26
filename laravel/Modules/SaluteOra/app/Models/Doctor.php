<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;
use Parental\HasParent;

/**
 * Class Doctor
 *
 * Questa classe implementa il pattern Single Table Inheritance (STI)
 * estendendo la classe User e utilizzando il trait HasParent.
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $registration_number
 * @property string|null $specialization
 * @property array|null $certifications
 * @property array|null $availability
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Modules\SaluteOra\Models\DoctorRegistrationWorkflow|null $workflow
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Doctor query()
 * @mixin \Eloquent
 */
class Doctor extends User
{
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'registration_number',
        'specialization',
        'certifications',
        'availability',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'certifications' => 'array',
            'availability' => 'array',
        ]);
    }

    /**
     * Get the workflow for this doctor's registration.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workflow(): HasOne
    {
        return $this->hasOne(DoctorRegistrationWorkflow::class, 'doctor_id');
    }

    /**
     * Verifica se il dottore ha dati validi per la transizione di stato.
     *
     * @return bool
     */
    public function hasValidData(): bool
    {
        return parent::hasValidData() &&
            !empty($this->first_name) &&
            !empty($this->last_name) &&
            !empty($this->registration_number) &&
            !empty($this->specialization);
    }
}
