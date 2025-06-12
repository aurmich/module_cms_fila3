<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Enums\UserStateEnum;
use Parental\HasParent;

/**
 * Doctor model for the SaluteOra module.
 * Extends the User model to provide doctor-specific functionality.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property UserTypeEnum $type
 * @property UserStateEnum $state
 * @property string|null $continuation_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Studio> $studios
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Appointment> $appointments
 * @property-read DoctorRegistrationWorkflow|null $registrationWorkflow
 *
 * @see \Modules\SaluteOra\Models\User
 */
class Doctor extends User
{
    use HasParent;

   
    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
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

    protected $appends = [
        //'health_card',
        //'identity_document',
        //'isee_certificate',
        //'pregnancy_certificate',
    ];

    public static array $attachments = [
        'health_card',
        'identity_document',
        'isee_certificate',
        'pregnancy_certificate',
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
