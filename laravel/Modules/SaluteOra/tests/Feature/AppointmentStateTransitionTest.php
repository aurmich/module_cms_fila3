<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Carbon\Carbon;

describe('Appointment State Transition', function () {
    
    beforeEach(function () {
        $this->patient = Patient::factory()->create();
        $this->doctor = Doctor::factory()->create();
        $this->studio = Studio::factory()->create();
    });

    describe('Basic Status Transitions', function () {
        it('creates appointment in scheduled state', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            expect($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
        });

        it('transitions from scheduled to confirmed', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            $appointment->update(['status' => AppointmentStatusEnum::CONFIRMED]);
            
            expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::CONFIRMED);
        });

        it('transitions from confirmed to completed', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::CONFIRMED,
            ]);
            
            $appointment->update(['status' => AppointmentStatusEnum::COMPLETED]);
            
            expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::COMPLETED);
        });
    });

    describe('Cancellation and No-Show', function () {
        it('allows cancellation of scheduled appointment', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            $appointment->update(['status' => AppointmentStatusEnum::CANCELLED]);
            
            expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::CANCELLED);
        });

        it('marks appointment as no-show', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::CONFIRMED,
            ]);
            
            $appointment->update(['status' => AppointmentStatusEnum::NO_SHOW]);
            
            expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::NO_SHOW);
        });
    });

    describe('Time-Based Transitions', function () {
        it('handles past appointments correctly', function () {
            $pastAppointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::CONFIRMED,
                'starts_at' => Carbon::now()->subHour(),
                'ends_at' => Carbon::now()->subMinutes(30),
            ]);
            
            expect($pastAppointment->starts_at->isPast())->toBeTrue();
        });

        it('handles future appointments correctly', function () {
            $futureAppointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
            ]);
            
            expect($futureAppointment->starts_at->isFuture())->toBeTrue();
        });
    });
});
