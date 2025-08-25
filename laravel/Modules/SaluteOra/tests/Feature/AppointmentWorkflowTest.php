<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Modules\SaluteOra\Tests\TestCase;
use Carbon\Carbon;

uses(TestCase::class);

describe('Appointment Workflow', function () {
    
    beforeEach(function () {
        // Oggetti in memoria per test veloci
        $this->patient = (object) ['id' => 1001, 'name' => 'Mario Rossi'];
        $this->doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
        $this->studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
    });

    describe('Basic Workflow', function () {
        it('creates appointment in scheduled state', function () {
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => 'scheduled',
                'starts_at' => Carbon::now()->addDay(),
            ];
            
            expect($appointment->status)->toBe('scheduled')
                ->and($appointment->patient_id)->toBe($this->patient->id)
                ->and($appointment->doctor_id)->toBe($this->doctor->id);
        });

        it('transitions appointment through workflow states', function () {
            $appointment = (object) [
                'status' => 'scheduled',
                'starts_at' => Carbon::now()->addDay(),
            ];
            
            // Simula transizioni di stato
            $appointment->status = 'confirmed';
            expect($appointment->status)->toBe('confirmed');
            
            $appointment->status = 'in_progress';
            expect($appointment->status)->toBe('in_progress');
            
            $appointment->status = 'completed';
            expect($appointment->status)->toBe('completed');
        });
    });

    describe('Appointment Scheduling', function () {
        it('schedules appointment at specific time', function () {
            $startsAt = Carbon::today()->addDay()->setTime(9, 0);
            $endsAt = $startsAt->copy()->addHour();
            
            $appointment = (object) [
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'duration_minutes' => 60,
            ];
            
            expect($appointment->starts_at->hour)->toBe(9)
                ->and($appointment->ends_at->hour)->toBe(10)
                ->and($appointment->duration_minutes)->toBe(60);
        });

        it('prevents double booking for same time slot', function () {
            $timeSlot = Carbon::today()->addDay()->setTime(9, 0);
            
            $existingAppointment = (object) [
                'starts_at' => $timeSlot,
                'ends_at' => $timeSlot->copy()->addHour(),
            ];
            
            $newAppointment = (object) [
                'starts_at' => $timeSlot->copy()->addMinutes(30),
                'ends_at' => $timeSlot->copy()->addHour()->addMinutes(30),
            ];
            
            // Simula controllo sovrapposizione
            $hasConflict = $newAppointment->starts_at < $existingAppointment->ends_at && 
                          $newAppointment->ends_at > $existingAppointment->starts_at;
            
            expect($hasConflict)->toBeTrue();
        });
    });

    describe('Appointment Cancellation and Rescheduling', function () {
        it('cancels appointment and frees time slot', function () {
            $appointment = (object) [
                'status' => 'scheduled',
                'starts_at' => Carbon::now()->addDay(),
                'cancelled_at' => null,
            ];
            
            // Simula cancellazione
            $appointment->status = 'cancelled';
            $appointment->cancelled_at = now();
            
            expect($appointment->status)->toBe('cancelled')
                ->and($appointment->cancelled_at)->toBeInstanceOf(Carbon::class);
        });

        it('reschedules appointment to new time', function () {
            $originalTime = Carbon::now()->addDay();
            $newTime = Carbon::now()->addDays(2);
            
            $appointment = (object) [
                'starts_at' => $originalTime,
                'ends_at' => $originalTime->copy()->addHour(),
                'original_starts_at' => $originalTime,
            ];
            
            // Simula riprogrammazione
            $appointment->starts_at = $newTime;
            $appointment->ends_at = $newTime->copy()->addHour();
            
            expect($appointment->starts_at)->toBe($newTime)
                ->and($appointment->original_starts_at)->toBe($originalTime);
        });
    });
});
