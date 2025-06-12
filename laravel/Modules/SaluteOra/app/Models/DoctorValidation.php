<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * DoctorValidation Model for the Patient Module.
 * 
 * Represents the validation process for a doctor's registration.
 *
 * @property int $id
 * @property int $doctor_id
 * @property string $validation_status Stato della validazione
 * @property \Illuminate\Support\Carbon|null $validation_date Data di validazione
 * @property int|null $validator_id
 * @property string|null $validation_notes Note aggiuntive sulla validazione
 * @property string|null $document_path Percorso del documento di validazione
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Modules\SaluteOra\Models\Doctor|null $doctor
 * @property-read \Modules\SaluteOra\Models\User|null $validator
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereValidationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereValidationNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereValidationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DoctorValidation whereValidatorId($value)
 * @mixin \Eloquent
 */
class DoctorValidation extends Model
{
    use LogsActivity;

    /**
     * The connection to the database.
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doctor_validations';

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'doctor_id',
        'validation_status',
        'validation_date',
        'validator_id',
        'validation_notes',
        'document_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'validation_date' => 'datetime',
    ];

    /**
     * Get the options for activity logging.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['doctor_id', 'validation_status', 'validation_date', 'validator_id', 'validation_notes', 'document_path'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the doctor associated with the validation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the user who performed the validation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}
