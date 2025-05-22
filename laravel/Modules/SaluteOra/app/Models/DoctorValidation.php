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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
