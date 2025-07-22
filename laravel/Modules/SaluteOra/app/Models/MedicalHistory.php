<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SaluteOra\Models\Patient;

/**
 * Modello per la storia clinica del paziente (MedicalHistory).
 * 
 * Rappresenta una voce di documentazione clinica associata a un utente/paziente.
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $date
 * @property string|null $type
 * @property string|null $description
 * @property string|null $attachments
 * @see User
 * @property int $patient_id
 * @property string $condition
 * @property string|null $diagnosis_date
 * @property string|null $treatment
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @property-read \Modules\SaluteOra\Models\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory whereDiagnosisDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory whereTreatment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalHistory withoutTrashed()
 * @mixin \Eloquent
 */
class MedicalHistory extends Model
{
    use LogsActivity, SoftDeletes;

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
    protected $table = 'medical_histories';

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'patient_id',
        'date',
        'type',
        'description',
        'attachments',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'attachments' => 'array',
    ];

    /**
     * Get the options for activity logging.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['user_id', 'date', 'type', 'description', 'attachments'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the user that owns the medical history.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the patient that owns the medical history.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
