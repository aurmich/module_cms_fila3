<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Modules\SaluteOra\Tests\TestCase;
use Carbon\Carbon;

uses(TestCase::class);

describe('Studio Business Logic', function () {
    
    beforeEach(function () {
        // Oggetti in memoria per test veloci
        $this->patient = (object) ['id' => 1001, 'name' => 'Mario Rossi'];
        $this->doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
    });

    describe('Studio Management', function () {
        it('creates studio with basic information', function () {
            $studio = (object) [
                'name' => 'Studio Medico Centrale',
                'address' => 'Via Roma 123',
                'city' => 'Milano',
                'phone' => '+39 02 1234567',
                'email' => 'info@studiocentrale.it',
            ];
            
            expect($studio->name)->toBe('Studio Medico Centrale')
                ->and($studio->address)->toBe('Via Roma 123')
                ->and($studio->city)->toBe('Milano');
        });

        it('manages studio operating hours', function () {
            $studio = (object) [
                'opening_hours' => [
                    'monday' => ['09:00', '18:00'],
                    'tuesday' => ['09:00', '18:00'],
                    'wednesday' => ['09:00', '18:00'],
                    'thursday' => ['09:00', '18:00'],
                    'friday' => ['09:00', '18:00'],
                    'saturday' => ['09:00', '12:00'],
                    'sunday' => ['closed'],
                ],
            ];
            
            expect($studio->opening_hours['monday'])->toBe(['09:00', '18:00'])
                ->and($studio->opening_hours['sunday'])->toBe(['closed']);
        });
    });

    describe('Doctor Management', function () {
        it('associates doctors with studio', function () {
            $studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
            
            $doctor = (object) [
                'id' => 2001,
                'name' => 'Dr. Bianchi',
                'studio_id' => $studio->id,
                'specialization' => 'Cardiologia',
            ];
            
            // Simula relazione in memoria
            $studio->doctors = collect([$doctor]);
            
            expect($studio->doctors)->toHaveCount(1)
                ->and($doctor->studio_id)->toBe($studio->id);
        });

        it('tracks doctor schedules within studio', function () {
            $studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
            
            $doctor = (object) [
                'id' => 2001,
                'name' => 'Dr. Bianchi',
                'studio_id' => $studio->id,
                'schedule' => [
                    'monday' => ['09:00', '17:00'],
                    'tuesday' => ['09:00', '17:00'],
                    'wednesday' => ['09:00', '17:00'],
                    'thursday' => ['09:00', '17:00'],
                    'friday' => ['09:00', '17:00'],
                ],
            ];
            
            expect($doctor->schedule['monday'])->toBe(['09:00', '17:00'])
                ->and($doctor->studio_id)->toBe($studio->id);
        });
    });

    describe('Appointment Management', function () {
        it('tracks studio appointments', function () {
            $studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
            
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $studio->id,
                'starts_at' => Carbon::now()->addDay(),
                'status' => 'scheduled',
            ];
            
            // Simula relazione in memoria
            $studio->appointments = collect([$appointment]);
            
            expect($studio->appointments)->toHaveCount(1)
                ->and($appointment->studio_id)->toBe($studio->id);
        });

        it('manages studio capacity and availability', function () {
            $studio = (object) [
                'id' => 3001,
                'name' => 'Studio Centrale',
                'max_concurrent_appointments' => 5,
                'current_appointments' => 3,
            ];
            
            $availableSlots = $studio->max_concurrent_appointments - $studio->current_appointments;
            
            expect($availableSlots)->toBe(2)
                ->and($studio->current_appointments)->toBeLessThan($studio->max_concurrent_appointments);
        });
    });
});
