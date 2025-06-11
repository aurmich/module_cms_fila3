<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Enums\UserTypeEnum;
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

    /**
     * Boot method per impostare automaticamente il type per i Doctor.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($doctor) {
            // Imposta automaticamente il type se non è già impostato
            if (empty($doctor->type)) {
                $doctor->type = UserTypeEnum::DOCTOR;
            }
        });
    }

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
     * Relazione molti-a-molti con gli studi in cui il dottore lavora.
     *
     * IMPORTANTE: Questa è una relazione cross-database, dove:
     * - Doctor risiede nel database 'user'
     * - Studio risiede nel database 'salute_ora'
     * - doctor_studio (pivot) risiede nel database 'saluteora_data'
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function studios(): BelongsToMany
    {
        /*
        // Utilizziamo parametri espliciti per la relazione cross-database
        $pivot = \Modules\SaluteOra\Models\DoctorStudio::class;
        $pivotModel = app($pivot);

        // Definiamo esplicitamente le tabelle con le loro connessioni
        $studioTable = 'salute_ora.studios'; // Specifichiamo esplicitamente il database
        $pivotTable = $pivotModel->getConnection()->getDatabaseName() . '.' . $pivotModel->getTable();

        return $this->belongsToMany(
            \Modules\SaluteOra\Models\Studio::class,
            $pivotTable,
            'user_id',
            'studio_id',
            'id',
            'id',
            'studios'
        )
        ->using($pivot)
        ->withPivot(['is_primary', 'schedule'])
        ->withTimestamps();
        */
        return $this->belongsToManyX(Studio::class);
    }
    // Implementazione della relazione BelongsToMany con Studio completata
}
