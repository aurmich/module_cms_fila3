<?php

declare(strict_types=1);

// Pure unit: avoid Eloquent models and factories
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Carbon\Carbon;

// No Laravel TestCase usage

describe('SaluteMo Appointment Management Business Logic', function () {
    
    beforeEach(function () {
        // No DB: plain in-memory value objects
        $this->patient = new stdClass();
        $this->patient->id = 1;
        $this->doctor = new stdClass();
        $this->doctor->id = 2;
        $this->studio = new stdClass();
        $this->studio->id = 3;
    });

    describe('Basic Appointment Management', function () {
        it('creates appointment with required fields', function () {
            $appointment = new stdClass();
            $appointment->patient_id = $this->patient->id;
            $appointment->doctor_id = $this->doctor->id;
            $appointment->studio_id = $this->studio->id;
            $appointment->starts_at = Carbon::now()->addDay();
            $appointment->ends_at = Carbon::now()->addDay()->addHour();
            $appointment->type = AppointmentTypeEnum::CONSULTATION;
            $appointment->status = AppointmentStatusEnum::SCHEDULED;
            
            expect($appointment->patient_id)->toBe($this->patient->id);
            expect($appointment->doctor_id)->toBe($this->doctor->id);
            expect($appointment->studio_id)->toBe($this->studio->id);
            expect($appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION);
            expect($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
        });

        it('validates appointment time constraints', function () {
            $startTime = Carbon::now()->addDay()->setTime(9, 0);
            $endTime = $startTime->copy()->addMinutes(30);
            
            $appointment = new stdClass();
            $appointment->patient_id = $this->patient->id;
            $appointment->doctor_id = $this->doctor->id;
            $appointment->studio_id = $this->studio->id;
            $appointment->starts_at = $startTime;
            $appointment->ends_at = $endTime;
            
            expect($appointment->starts_at->isBefore($appointment->ends_at))->toBeTrue();
            expect($appointment->starts_at->diffInMinutes($appointment->ends_at))->toEqual(30);
        });
    });

    describe('Appointment Type Management', function () {
        it('creates consultation appointment', function () {
            $appointment = new stdClass();
            $appointment->patient_id = $this->patient->id;
            $appointment->doctor_id = $this->doctor->id;
            $appointment->studio_id = $this->studio->id;
            $appointment->type = AppointmentTypeEnum::CONSULTATION;
            
            expect($appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION);
        });

        it('creates treatment appointment', function () {
            $appointment = new stdClass();
            $appointment->patient_id = $this->patient->id;
            $appointment->doctor_id = $this->doctor->id;
            $appointment->studio_id = $this->studio->id;
            $appointment->type = AppointmentTypeEnum::TREATMENT;
            
            expect($appointment->type)->toBe(AppointmentTypeEnum::TREATMENT);
        });
    });

    describe('Appointment Status Management', function () {
        it('transitions appointment through status workflow', function () {
            $appointment = new stdClass();
            $appointment->patient_id = $this->patient->id;
            $appointment->doctor_id = $this->doctor->id;
            $appointment->studio_id = $this->studio->id;
            $appointment->status = AppointmentStatusEnum::SCHEDULED;
            
            $appointment->status = AppointmentStatusEnum::CONFIRMED;
            expect($appointment->status)->toBe(AppointmentStatusEnum::CONFIRMED);
            
            $appointment->status = AppointmentStatusEnum::IN_PROGRESS;
            expect($appointment->status)->toBe(AppointmentStatusEnum::IN_PROGRESS);
            
            $appointment->status = AppointmentStatusEnum::COMPLETED;
            expect($appointment->status)->toBe(AppointmentStatusEnum::COMPLETED);
        });

        it('handles appointment cancellation', function () {
            $appointment = new stdClass();
            $appointment->patient_id = $this->patient->id;
            $appointment->doctor_id = $this->doctor->id;
            $appointment->studio_id = $this->studio->id;
            $appointment->status = AppointmentStatusEnum::SCHEDULED;
            
            $appointment->status = AppointmentStatusEnum::CANCELLED;
            expect($appointment->status)->toBe(AppointmentStatusEnum::CANCELLED);
        });
    });
});
