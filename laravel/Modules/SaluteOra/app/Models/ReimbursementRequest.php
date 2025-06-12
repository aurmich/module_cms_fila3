<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * ReimbursementRequest Model for the Patient Module.
 * 
 * Represents a request for reimbursement submitted by a patient.
 *
 * @property int $id
 * @property int $patient_id
 * @property int|null $appointment_id
 * @property numeric $amount
 * @property \Illuminate\Support\Carbon $request_date
 * @property string $status
 * @property string|null $reason
 * @property string|null $document_path
 * @property string|null $response_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Modules\SaluteOra\Models\Appointment|null $appointment
 * @property-read \Modules\SaluteOra\Models\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereDocumentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereResponseNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReimbursementRequest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReimbursementRequest extends Model
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
    protected $table = 'reimbursement_requests';

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'amount',
        'request_date',
        'status',
        'reason',
        'document_path',
        'response_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'request_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the options for activity logging.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['patient_id', 'appointment_id', 'amount', 'request_date', 'status', 'reason', 'document_path', 'response_notes'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the patient that submitted the reimbursement request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the appointment related to the reimbursement request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
