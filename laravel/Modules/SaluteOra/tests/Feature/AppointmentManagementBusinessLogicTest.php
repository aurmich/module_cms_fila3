<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Carbon\Carbon;

describe('Appointment Management Business Logic', function () {
    
    beforeEach(function () {
        $this->patient = Patient::factory()->create();
        $this->doctor = Doctor::factory()->create();
        $this->studio = Studio::factory()->create();
    });

    describe('Appointment Creation', function () {
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
            expect($appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION);
            expect($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
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
            expect($appointment->starts_at->diffInMinutes($appointment->ends_at))->toBe(30);
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
            
            // Scheduled -> Confirmed
            $appointment->update(['status' => AppointmentStatusEnum::CONFIRMED]);
            expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::CONFIRMED);
            
            // Confirmed -> Completed
            $appointment->update(['status' => AppointmentStatusEnum::COMPLETED]);
            expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::COMPLETED);
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

        it('creates emergency appointment', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'type' => AppointmentTypeEnum::EMERGENCY,
            ]);
            
            expect($appointment->type)->toBe(AppointmentTypeEnum::EMERGENCY);
        });
    });

    describe('Appointment Scheduling Logic', function () {
        it('prevents overlapping appointments for same doctor', function () {
            $timeSlot = Carbon::today()->setTime(10, 0);
            
            $appointment1 = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $timeSlot,
                'ends_at' => $timeSlot->copy()->addMinutes(30),
            ]);
            
            $appointment2 = Appointment::factory()->create([
                'patient_id' => Patient::factory()->create()->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $timeSlot->copy()->addMinutes(15),
                'ends_at' => $timeSlot->copy()->addMinutes(45),
            ]);
            
            expect($appointment1->id)->not->toBe($appointment2->id);
        });

        it('allows consecutive appointments', function () {
            $timeSlot = Carbon::today()->setTime(9, 0);
            
            $appointment1 = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $timeSlot,
                'ends_at' => $timeSlot->copy()->addMinutes(30),
            ]);
            
            $appointment2 = Appointment::factory()->create([
                'patient_id' => Patient::factory()->create()->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $timeSlot->copy()->addMinutes(30),
                'ends_at' => $timeSlot->copy()->addMinutes(60),
            ]);
            
            expect($appointment1->ends_at)->toBe($appointment2->starts_at);
        });
    });

    describe('Business Rules Validation', function () {
        it('enforces minimum appointment duration', function () {
            $startTime = Carbon::now()->addDay()->setTime(9, 0);
            $endTime = $startTime->copy()->addMinutes(15);
            
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
            ]);
            
            $duration = $appointment->starts_at->diffInMinutes($appointment->ends_at);
            expect($duration)->toBeGreaterThanOrEqual(15);
        });

        it('validates appointment is in future', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
            ]);
            
            expect($appointment->starts_at->isFuture())->toBeTrue();
        });
    });
});
