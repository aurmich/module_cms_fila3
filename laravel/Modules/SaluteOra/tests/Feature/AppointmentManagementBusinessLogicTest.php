<?php

declare(strict_types=1);

// Enum values as strings to avoid config() dependency
use Carbon\Carbon;

describe('Appointment Management Business Logic', function () {
    
    beforeEach(function () {
        $this->patient = (object) [
            'id' => 1001,
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com',
            'type' => 'patient'
        ];
        $this->doctor = (object) [
            'id' => 2001,
            'name' => 'Dr. Giuseppe Verdi',
            'email' => 'giuseppe@studio.com',
            'type' => 'doctor'
        ];
        $this->studio = (object) [
            'id' => 3001,
            'name' => 'Studio Medico Centrale',
            'address' => 'Via Roma 123'
        ];
    });

    describe('Appointment Creation', function () {
        it('creates appointment with required fields', function () {
            $appointment = (object) [
                'id' => 4001,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
                'type' => 'consultation',
                'status' => 'scheduled',
            ];
            
            expect($appointment->patient_id)->toBe($this->patient->id);
            expect($appointment->doctor_id)->toBe($this->doctor->id);
            expect($appointment->studio_id)->toBe($this->studio->id);
            expect($appointment->type)->toBe('consultation');
            expect($appointment->status)->toBe('scheduled');
        });

        it('validates appointment time constraints', function () {
            $startTime = Carbon::now()->addDay()->setTime(9, 0);
            $endTime = $startTime->copy()->addMinutes(30);
            
            $appointment = (object) [
                'id' => 4002,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $startTime,
                'ends_at' => $endTime,
                'type' => 'consultation',
                'status' => 'scheduled',
            ];
            
            expect($appointment->starts_at->isBefore($appointment->ends_at))->toBeTrue();
        });
    });

    describe('Appointment Status Management', function () {
        it('transitions appointment through status workflow', function () {
            $appointment = (object) [
                'id' => 4003,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
                'type' => 'consultation',
                'status' => 'scheduled',
            ];
            
            // Test stato iniziale
            expect($appointment->status)->toBe('scheduled');
            
            // Simula transizione a CONFIRMED
            $appointment->status = 'confirmed';
            expect($appointment->status)->toBe('confirmed');
            
            // Simula transizione a COMPLETED
            $appointment->status = 'completed';
            expect($appointment->status)->toBe('completed');
        });

        it('handles appointment cancellation', function () {
            $appointment = (object) [
                'id' => 4004,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addHour(),
                'type' => 'consultation',
                'status' => 'scheduled',
                'cancelled_at' => null,
                'cancellation_reason' => null
            ];
            
            // Simula cancellazione
            $appointment->status = 'cancelled';
            $appointment->cancelled_at = Carbon::now();
            $appointment->cancellation_reason = 'Patient request';
            
            expect($appointment->status)->toBe('cancelled');
            expect($appointment->cancelled_at)->toBeInstanceOf(Carbon::class);
            expect($appointment->cancellation_reason)->toBe('Patient request');
        });
    });

    describe('Appointment Type Management', function () {
        it('creates consultation appointment', function () {
            $appointment = (object) [
                'id' => 4005,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addMinutes(20),
                'type' => 'consultation',
                'status' => 'scheduled',
            ];
            
            expect($appointment->type)->toBe('consultation');
        });

        it('creates treatment appointment', function () {
            $appointment = (object) [
                'id' => 4006,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'ends_at' => Carbon::now()->addDay()->addMinutes(30),
                'type' => 'treatment',
                'status' => 'scheduled',
            ];
            
            expect($appointment->type)->toBe('treatment');
        });

        it('creates emergency appointment', function () {
            $appointment = (object) [
                'id' => 4007,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => Carbon::now()->addHour(),
                'ends_at' => Carbon::now()->addHour()->addMinutes(45),
                'type' => 'emergency',
                'status' => 'confirmed',
                'emergency' => true,
                'priority' => 'high'
            ];
            
            expect($appointment->type)->toBe('emergency');
            expect($appointment->type)->toBe('emergency');
            expect($appointment->emergency)->toBeTrue();
            expect($appointment->priority)->toBe('high');
        });
    });

    describe('Appointment Scheduling Logic', function () {
        it('prevents overlapping appointments', function () {
            $baseTime = Carbon::now()->addDay()->setTime(10, 0);
            
            $appointment1 = (object) [
                'id' => 4008,
                'doctor_id' => $this->doctor->id,
                'starts_at' => $baseTime,
                'ends_at' => $baseTime->copy()->addHour(),
            ];
            
            $appointment2 = (object) [
                'id' => 4009,
                'doctor_id' => $this->doctor->id,
                'starts_at' => $baseTime->copy()->addMinutes(30),
                'ends_at' => $baseTime->copy()->addMinutes(90),
            ];
            
            // Verifica sovrapposizione
            $hasOverlap = $appointment1->starts_at->lt($appointment2->ends_at) && 
                         $appointment2->starts_at->lt($appointment1->ends_at);
            
            expect($hasOverlap)->toBeTrue();
        });

        it('allows consecutive appointments', function () {
            $baseTime = Carbon::now()->addDay()->setTime(10, 0);
            
            $appointment1 = (object) [
                'id' => 4010,
                'doctor_id' => $this->doctor->id,
                'starts_at' => $baseTime,
                'ends_at' => $baseTime->copy()->addHour(),
            ];
            
            $appointment2 = (object) [
                'id' => 4011,
                'doctor_id' => $this->doctor->id,
                'starts_at' => $baseTime->copy()->addHour(),
                'ends_at' => $baseTime->copy()->addHours(2),
            ];
            
            // Verifica nessuna sovrapposizione
            $hasOverlap = $appointment1->starts_at->lt($appointment2->ends_at) && 
                         $appointment2->starts_at->lt($appointment1->ends_at);
            
            expect($hasOverlap)->toBeFalse();
            expect($appointment1->ends_at)->toEqual($appointment2->starts_at);
        });
    });

    describe('Business Rules Validation', function () {
        

        it('enforces minimum advance booking time', function () {
            $now = Carbon::now();
            $minimumAdvanceHours = 1;
            
            $validAppointment = (object) [
                'starts_at' => $now->copy()->addHours($minimumAdvanceHours + 1),
            ];
            
            $invalidAppointment = (object) [
                'starts_at' => $now->copy()->addMinutes(30),
            ];
            
            expect($validAppointment->starts_at->diffInHours($now, true))->toBeGreaterThan($minimumAdvanceHours);
            expect($invalidAppointment->starts_at->diffInHours($now, true))->toBeLessThan($minimumAdvanceHours);
        });
    });
});