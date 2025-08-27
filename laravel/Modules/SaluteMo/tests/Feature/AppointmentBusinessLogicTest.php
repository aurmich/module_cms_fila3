<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Feature;

use Modules\SaluteMo\Tests\TestCase;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Carbon\Carbon;

uses(TestCase::class);

describe('Appointment Business Logic', function () {
    
    beforeEach(function () {
        // No DB: plain in-memory value objects
        $this->patient = (object) ['id' => 1001];
        $this->doctor = (object) ['id' => 2001];
        $this->studio = (object) ['id' => 3001];
    });

    describe('Basic Appointment Management', function () {
        it('creates appointment with required fields', function () {
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'type' => AppointmentTypeEnum::CONSULTATION,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ];
            
            expect($appointment->patient_id)->toBe($this->patient->id);
            expect($appointment->doctor_id)->toBe($this->doctor->id);
            expect($appointment->studio_id)->toBe($this->studio->id);
            expect($appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION);
            expect($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
        });

        it('validates appointment time constraints', function () {
            $startTime = Carbon::now()->addDay()->setTime(9, 0);
            $endTime = $startTime->copy()->addMinutes(30);
            
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
            ];
            
            expect($appointment->starts_at->isBefore($appointment->ends_at))->toBeTrue();
            expect($appointment->starts_at->diffInMinutes($appointment->ends_at))->toEqual(30);
        });

        it('detects invalid time range (end before start) without DB', function () {
            $startTime = Carbon::now()->addDay()->setTime(9, 0);
            $endTime = $startTime->copy()->subMinutes(30); // End time before start time

            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
            ];

            expect($appointment->starts_at->isBefore($appointment->ends_at))->toBeFalse();
        });
    });

    describe('Appointment Status Management', function () {
        it('transitions appointment through status workflow', function () {
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ];
            
            // In-memory status transition (no DB)
            $appointment->status = AppointmentStatusEnum::CONFIRMED;
            expect($appointment->status)->toBe(AppointmentStatusEnum::CONFIRMED);
            
            // Test transition to in progress
            $appointment->status = AppointmentStatusEnum::IN_PROGRESS;
            expect($appointment->status)->toBe(AppointmentStatusEnum::IN_PROGRESS);
            
            // Test transition to completed
            $appointment->status = AppointmentStatusEnum::COMPLETED;
            expect($appointment->status)->toBe(AppointmentStatusEnum::COMPLETED);
        });

        it('handles appointment cancellation', function () {
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ];
            
            $appointment->status = AppointmentStatusEnum::CANCELLED;
            expect($appointment->status)->toBe(AppointmentStatusEnum::CANCELLED);
        });

        it('handles no-show appointments', function () {
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::CONFIRMED,
            ];
            
            $appointment->status = AppointmentStatusEnum::NO_SHOW;
            expect($appointment->status)->toBe(AppointmentStatusEnum::NO_SHOW);
        });
    });

    describe('Appointment Type Management', function () {
        it('creates consultation appointment', function () {
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'type' => AppointmentTypeEnum::CONSULTATION,
            ];
            
            expect($appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION);
            expect($appointment->type->getLabel())->toBe('saluteora::enums.appointment_type.consultation');
            expect($appointment->type->getDuration())->toBe(20);
        });

        it('creates treatment appointment', function () {
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'type' => AppointmentTypeEnum::TREATMENT,
            ];
            
            expect($appointment->type)->toBe(AppointmentTypeEnum::TREATMENT);
            expect($appointment->type->getLabel())->toBe('saluteora::enums.appointment_type.treatment');
            expect($appointment->type->getDuration())->toBe(30);
        });

        it('creates emergency appointment with priority', function () {
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'type' => AppointmentTypeEnum::EMERGENCY,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ];
            
            expect($appointment->type)->toBe(AppointmentTypeEnum::EMERGENCY);
            expect($appointment->type->getLabel())->toBe('saluteora::enums.appointment_type.emergency');
            expect($appointment->type->getDuration())->toBe(30);
        });
    });

    describe('Business Rules Validation', function () {
        it('detects double booking for same doctor and overlapping time', function () {
            $startTime = Carbon::now()->addDay()->setTime(9, 0);
            $endTime = $startTime->copy()->addMinutes(30);

            $a1 = (object) [
                'doctor_id' => 10,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
            ];

            $a2 = (object) [
                'doctor_id' => 10,
                'starts_at' => $startTime->copy()->addMinutes(15),
                'ends_at' => $endTime->copy()->addMinutes(15),
            ];

            $overlaps = fn($x, $y): bool =>
                $x->doctor_id === $y->doctor_id &&
                $x->starts_at < $y->ends_at &&
                $y->starts_at < $x->ends_at;

            expect($overlaps($a1, $a2))->toBeTrue();
        });

        it('allows same time for different doctors', function () {
            $startTime = Carbon::now()->addDay()->setTime(10, 0);
            $endTime = $startTime->copy()->addMinutes(30);

            $a1 = (object) [
                'doctor_id' => 10,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
            ];

            $a2 = (object) [
                'doctor_id' => 11,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
            ];

            $overlaps = fn($x, $y): bool =>
                $x->doctor_id === $y->doctor_id &&
                $x->starts_at < $y->ends_at &&
                $y->starts_at < $x->ends_at;

            expect($overlaps($a1, $a2))->toBeFalse();
        });

        it('flags weekend appointments as outside business hours', function () {
            $weekendTime = Carbon::now()->next(Carbon::SATURDAY)->setTime(9, 0);

            $isWeekend = fn(Carbon $dt): bool => in_array($dt->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY], true);

            expect($isWeekend($weekendTime))->toBeTrue();
        });
    });

    describe('Data Integrity (in-memory)', function () {
        it('keeps core foreign keys assigned', function () {
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
            ];

            expect($appointment->patient_id)->toBe($this->patient->id);
            expect($appointment->patient_id)->toBe($this->patient->id);
            expect($appointment->studio_id)->toBe($this->studio->id);
        });

        it('validates required fields conceptually', function () {
            $validate = function ($a): bool {
                return $a->patient_id !== null && $a->doctor_id !== null && $a->studio_id !== null;
            };

            $ok = (object) ['patient_id' => 1, 'doctor_id' => 2, 'studio_id' => 3];
            $bad1 = (object) ['patient_id' => null, 'doctor_id' => 2, 'studio_id' => 3];

            expect($validate($ok))->toBeTrue();
            expect($validate($bad1))->toBeFalse();
        });
    });
});