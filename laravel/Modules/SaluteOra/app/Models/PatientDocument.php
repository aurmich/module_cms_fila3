<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * PatientDocument Model for the Patient Module.
 * 
 * Represents a document uploaded by or for a patient, such as clinical documentation.
 *
 * @property int $id
 * @property int $patient_id
 * @property string $document_type
 * @property string $document_path
 * @property \Illuminate\Support\Carbon $upload_date
 * @property string|null $description
 * @property int|null $uploaded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Modules\SaluteOra\Models\Patient|null $patient
 * @property-read \Modules\SaluteOra\Models\User|null $uploader
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument whereUploadDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PatientDocument whereUploadedBy($value)
 * @mixin \Eloquent
 */
class PatientDocument extends Model
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
    protected $table = 'patient_documents';

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'patient_id',
        'document_type',
        'document_path',
        'upload_date',
        'description',
        'uploaded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'upload_date' => 'datetime',
    ];

    /**
     * Get the options for activity logging.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['patient_id', 'document_type', 'document_path', 'upload_date', 'description', 'uploaded_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the patient associated with the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the user who uploaded the document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
