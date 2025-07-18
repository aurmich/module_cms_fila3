<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Spatie\ModelStates\HasStates;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStatesContract;
use Spatie\Activitylog\Traits\LogsActivity;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Appointment Model for the SaluteOra Module.
 * 
 * Represents an appointment booked by a patient with a doctor in a studio.
 * Supports FullCalendar widgets with multi-tenancy and user type filtering.
 *
 * @property int $id
 * @property int $patient_id
 * @property AppointmentState $state
 * @property int $doctor_id
 * @property int $dentist_id Alias for doctor_id (legacy compatibility)
 * @property int $studio_id
 * @property int|null $tenant_id
 * @property string $title
 * @property \Carbon\Carbon $start_time
 * @property \Carbon\Carbon $end_time
 * @property \Carbon\Carbon|null $date Alias for start_time date
 * @property AppointmentTypeEnum $type
 * @property AppointmentStatusEnum $status
 * @property string|null $notes
 * @property string|null $treatment_plan
 * @property bool $emergency
 * @property bool $is_emergency Alias for emergency
 * @property bool $eligibility_confirmed
 * @property bool $reminder_sent
 * @property \Carbon\Carbon|null $reminder_sent_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Patient $patient
 * @property-read Doctor $doctor
 * @property-read Studio $studio
 * @property string $user_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $start_datetime
 * @property string|null $end_datetime
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read int $duration
 * @property-read string $formatted_title
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment emergency()
 * @method static \Modules\SaluteOra\Database\Factories\AppointmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment forDoctor(int $doctorId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment forPatient(int $patientId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment forStudio(int $studioId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment inDateRange(string $start, string $end)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDentistId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEmergency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEndDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStartDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStudioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereUserId($value)
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Appointment whereState($value)
 * @mixin \Eloquent
 */
class Appointment extends BaseModel implements HasStatesContract
{
    use LogsActivity;
    use HasStates;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'studio_id',
        //'tenant_id',
        'title',
        'start_time',
        'end_time',
        'type',
        'status',
        'notes',
        'treatment_plan',
        'emergency',
        'eligibility_confirmed',
        'reminder_sent',
        'reminder_sent_at',
        'state',
        'starts_at',
        'ends_at',
        'invoice',//fattura
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'type' => AppointmentTypeEnum::class,
            'status' => AppointmentStatusEnum::class,
            'state' => AppointmentState::class,
            'emergency' => 'boolean',
            'eligibility_confirmed' => 'boolean',
            'reminder_sent' => 'boolean',
            'reminder_sent_at' => 'datetime',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ]);
    }

    /**
     * Get the options for activity logging.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'patient_id',
                'doctor_id',
                'studio_id',
                'title',
                'starts_at',
                'ends_at',
                'notes',
                'state',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Get the patient that booked the appointment.
     *
     * @return BelongsTo<Patient, Appointment>
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor for the appointment.
     *
     * @return BelongsTo<Doctor, Appointment>
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the studio where the appointment takes place.
     *
     * @return BelongsTo<Studio, Appointment>
     */
    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function report(): HasOne
    {
        return $this->hasOne(Report::class);
    }


    public function hasReport(): bool
    {
        return $this->report()->exists();
    }

    /**
     * Get the formatted title for calendar display.
     *
     * @return string
     */
    public function getFormattedTitleAttribute(): string
    {
        if ($this->emergency) {
            return "🚨 {$this->title}";
        }

        return $this->title ?: $this->type->getLabel();
    }

    public function getTimeRangeAttribute(): string
    {
        return $this->starts_at?->format('H:i') . ' - ' . $this->ends_at?->format('H:i');
    }

    /**
     * Get the duration in minutes.
     *
     * @return int
     */
    public function getDurationAttribute(): int
    {
        return (int) $this->start_time->diffInMinutes($this->end_time);
    }

    /**
     * Check if the appointment is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    /**
     * Check if the appointment is completed.
     *
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === AppointmentStatusEnum::COMPLETED;
    }

    /**
     * Check if the appointment is cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->status === AppointmentStatusEnum::CANCELLED;
    }

    /**
     * Check if the appointment is an emergency.
     *
     * @return bool
     */
    public function isEmergency(): bool
    {
        return $this->emergency || $this->type === AppointmentTypeEnum::EMERGENCY;
    }

    /**
     * Scope to filter appointments by date range for FullCalendar.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $start
     * @param string $end
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInDateRange($query, string $start, string $end)
    {
        return $query->whereBetween('start_time', [$start, $end]);
    }

    /**
     * Scope to filter appointments by patient.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $patientId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForPatient($query, int $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    /**
     * Scope to filter appointments by doctor.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $doctorId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForDoctor($query, int $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope to filter appointments by studio.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $studioId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForStudio($query, int $studioId)
    {
        return $query->where('studio_id', $studioId);
    }

    /**
     * Scope to filter only active appointments.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', AppointmentStatusEnum::getActiveStatuses());
    }

    /**
     * Scope to filter emergency appointments.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmergency($query)
    {
        return $query->where(function ($q) {
            $q->where('emergency', true)
              ->orWhere('type', AppointmentTypeEnum::EMERGENCY);
        });
    }
}
