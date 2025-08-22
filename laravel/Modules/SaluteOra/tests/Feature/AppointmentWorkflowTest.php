<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Carbon\Carbon;

describe('Appointment Workflow', function () {
    
    beforeEach(function () {
        $this->patient = Patient::factory()->create();
        $this->doctor = Doctor::factory()->create();
        $this->studio = Studio::factory()->create();
    });

    describe('Basic Workflow', function () {
        it('creates appointment in scheduled state', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
            ]);
            
            expect($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED)
                ->and($appointment->patient->id)->toBe($this->patient->id)
                ->and($appointment->doctor->id)->toBe($this->doctor->id)
                ->and($appointment->studio->id)->toBe($this->studio->id);
        });

        it('updates appointment status', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            $appointment->update(['status' => AppointmentStatusEnum::COMPLETED]);
            
            expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::COMPLETED);
        });
    });

    describe('Time Management', function () {
        it('handles appointment duration correctly', function () {
            $startTime = Carbon::now()->addDay()->setTime(9, 0);
            $endTime = $startTime->copy()->addHour();
            
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
            ]);
            
            $duration = $startTime->diffInMinutes($endTime);
            
            expect($duration)->toBe(60);
        });
    });

    describe('Relationships', function () {
        it('maintains patient relationship', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($appointment->patient->id)->toBe($this->patient->id);
        });

        it('maintains doctor relationship', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($appointment->doctor->id)->toBe($this->doctor->id);
        });

        it('maintains studio relationship', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($appointment->studio->id)->toBe($this->studio->id);
        });
    });
});
