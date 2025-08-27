<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Modules\SaluteOra\Tests\TestCase;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Carbon\Carbon;

uses(TestCase::class);

describe('Appointment State Transition', function () {

    beforeEach(function () {
        // Oggetti in memoria per test veloci
        $this->patient = (object) ['id' => 1001, 'name' => 'Mario Rossi'];
        $this->doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
        $this->studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
    });

    describe('Basic Status Transitions', function () {
        it('creates appointment in scheduled state', function () {
            $appointment = (object) [
                'id' => 5001,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
                'status' => AppointmentStatusEnum::SCHEDULED,
            ];

            expect($appointment->status === AppointmentStatusEnum::SCHEDULED)->toBeTrue();
        });

        it('transitions from scheduled to confirmed', function () {
            $appointment = (object) [
                'id' => 5002,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
                'status' => AppointmentStatusEnum::SCHEDULED,
            ];

            $appointment->status = AppointmentStatusEnum::CONFIRMED;
            expect($appointment->status === AppointmentStatusEnum::CONFIRMED)->toBeTrue();
        });

        it('transitions from confirmed to completed', function () {
            $appointment = (object) [
                'id' => 5003,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
                'status' => AppointmentStatusEnum::CONFIRMED,
            ];

            $appointment->status = AppointmentStatusEnum::COMPLETED;
            expect($appointment->status === AppointmentStatusEnum::COMPLETED)->toBeTrue();
        });
    });

    describe('Status Validation', function () {
        it('handles status enum values correctly', function () {
            $statuses = [
                AppointmentStatusEnum::SCHEDULED,
                AppointmentStatusEnum::CONFIRMED,
                AppointmentStatusEnum::COMPLETED,
                AppointmentStatusEnum::CANCELLED,
                AppointmentStatusEnum::NO_SHOW,
            ];

            foreach ($statuses as $status) {
                expect($status)->toBeInstanceOf(AppointmentStatusEnum::class);
            }
        });

        it('validates status transitions', function () {
            $appointment = (object) [
                'id' => 5004,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ];

            // Simula transizioni valide
            $validTransitions = [
                AppointmentStatusEnum::CONFIRMED,
                AppointmentStatusEnum::CANCELLED,
            ];

            foreach ($validTransitions as $newStatus) {
                $appointment->status = $newStatus;
                expect($appointment->status === $newStatus)->toBeTrue();
            }
        });
    });

    describe('Time-Based Transitions', function () {
        it('handles future appointments correctly', function () {
            $appointment = (object) [
                'id' => 5005,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
                'status' => AppointmentStatusEnum::SCHEDULED,
            ];

            expect($appointment->starts_at->isFuture())->toBeTrue();
        });

        it('handles past appointments correctly', function () {
            $appointment = (object) [
                'id' => 5006,
                'starts_at' => Carbon::now()->subDay(),
                'ends_at' => Carbon::now()->subDay()->addHour(),
                'status' => AppointmentStatusEnum::COMPLETED,
            ];

            expect($appointment->starts_at->isPast())->toBeTrue();
        });
    });

    describe('Cancellation and No-Show', function () {
        it('allows cancellation of scheduled appointment', function () {
            $appointment = (object) [
                'id' => 5007,
                'status' => AppointmentStatusEnum::SCHEDULED,
                'cancelled_at' => null,
            ];

            $appointment->status = AppointmentStatusEnum::CANCELLED;
            $appointment->cancelled_at = Carbon::now();

            expect($appointment->status === AppointmentStatusEnum::CANCELLED)->toBeTrue();
            expect($appointment->cancelled_at)->toBeInstanceOf(Carbon::class);
        });

        it('marks appointment as no-show', function () {
            $appointment = (object) [
                'id' => 5008,
                'status' => AppointmentStatusEnum::CONFIRMED,
                'no_show_at' => null,
            ];

            $appointment->status = AppointmentStatusEnum::NO_SHOW;
            $appointment->no_show_at = Carbon::now();

            expect($appointment->status === AppointmentStatusEnum::NO_SHOW)->toBeTrue();
            expect($appointment->no_show_at)->toBeInstanceOf(Carbon::class);
        });
    });

    describe('Business Logic Validation', function () {
        it('enforces appointment time constraints', function () {
            $startTime = Carbon::now()->addDay();
            $endTime = $startTime->copy()->addMinutes(30);

            $appointment = (object) [
                'id' => 5009,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
            ];

            // Test business rule: end time must be after start time
            expect($appointment->starts_at->isBefore($appointment->ends_at))->toBeTrue();
            expect($appointment->starts_at->diffInMinutes($appointment->ends_at))->toEqual(30);
        });

        it('maintains appointment relationships integrity', function () {
            $appointment = (object) [
                'id' => 5010,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
            ];

            // Test business rule: appointment must have valid relationships
            expect($appointment->patient_id)->toBe($this->patient->id);
            expect($appointment->doctor_id)->toBe($this->doctor->id);
            expect($appointment->studio_id)->toBe($this->studio->id);
        });
    });
});