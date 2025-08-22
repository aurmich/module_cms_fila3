<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteMo\Enums\AppointmentStatusEnum;
use Modules\SaluteMo\Enums\AppointmentTypeEnum;
use Carbon\Carbon;

describe('Appointment Business Logic', function () {
    
    beforeEach(function () {
        $this->patient = Patient::factory()->create();
        $this->doctor = Doctor::factory()->create();
        $this->studio = Studio::factory()->create();
    });

    describe('Basic Appointment Management', function () {
        it('creates appointment with required fields', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
                'type' => AppointmentTypeEnum::CONSULTATION,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            expect($appointment->patient_id)->toBe($this->patient->id);
            expect($appointment->doctor_id)->toBe($this->doctor->id);
            expect($appointment->studio_id)->toBe($this->studio->id);
        });

        it('validates appointment time constraints', function () {
            $startTime = Carbon::now()->addDay()->setTime(9, 0);
            $endTime = $startTime->copy()->addMinutes(30);
            
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
            ]);
            
            expect($appointment->starts_at->isBefore($appointment->ends_at))->toBeTrue();
        });
    });

    describe('Appointment Status Management', function () {
        it('transitions appointment through status workflow', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            $appointment->update(['status' => AppointmentStatusEnum::CONFIRMED]);
            expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::CONFIRMED);
        });

        it('handles appointment cancellation', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            $appointment->update(['status' => AppointmentStatusEnum::CANCELLED]);
            expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::CANCELLED);
        });
    });

    describe('Appointment Type Management', function () {
        it('creates consultation appointment', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'type' => AppointmentTypeEnum::CONSULTATION,
            ]);
            
            expect($appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION);
        });

        it('creates treatment appointment', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'type' => AppointmentTypeEnum::TREATMENT,
            ]);
            
            expect($appointment->type)->toBe(AppointmentTypeEnum::TREATMENT);
        });
    });
});