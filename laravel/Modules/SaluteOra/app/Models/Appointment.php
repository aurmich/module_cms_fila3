<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\Enums\AppointmentType;

/**
 * Appointment Model for the SaluteOra Module.
 *
 * Represents an appointment booked by a patient with a doctor in a studio.
 * Supports FullCalendar widgets with multi-tenancy and user type filtering.
 *
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 * @property int $studio_id
 * @property string $title
 * @property \Carbon\Carbon $start_time
 * @property \Carbon\Carbon $end_time
 * @property AppointmentType $type
 * @property AppointmentStatus $status
 * @property string|null $notes
 * @property bool $emergency
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Patient $patient
 * @property-read Doctor $doctor
 * @property-read Studio $studio
 */
class Appointment extends BaseModel
{
    use LogsActivity;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'studio_id',
        'title',
        'start_time',
        'end_time',
        'type',
        'status',
        'notes',
        'emergency',
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
            'type' => AppointmentType::class,
            'status' => AppointmentStatus::class,
            'emergency' => 'boolean',
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
                'start_time',
                'end_time',
                'type',
                'status',
                'notes',
                'emergency'
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

    /**
     * Get the duration in minutes.
     *
     * @return int
     */
    public function getDurationAttribute(): int
    {
        return $this->start_time->diffInMinutes($this->end_time);
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
        return $this->status === AppointmentStatus::COMPLETED;
    }

    /**
     * Check if the appointment is cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->status === AppointmentStatus::CANCELLED;
    }

    /**
     * Check if the appointment is an emergency.
     *
     * @return bool
     */
    public function isEmergency(): bool
    {
        return $this->emergency || $this->type === AppointmentType::EMERGENCY;
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
        return $query->whereIn('status', AppointmentStatus::getActiveStatuses());
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
              ->orWhere('type', AppointmentType::EMERGENCY);
        });
    }
}
