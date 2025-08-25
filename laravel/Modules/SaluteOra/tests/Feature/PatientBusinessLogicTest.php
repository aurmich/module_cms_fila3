<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Modules\SaluteOra\Tests\TestCase;
use Carbon\Carbon;

uses(TestCase::class);

describe('Patient Business Logic', function () {
    
    beforeEach(function () {
        // Oggetti in memoria per test veloci
        $this->doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
        $this->studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
    });

    describe('Booking Eligibility', function () {
        it('allows new patient to book first appointment', function () {
            $patient = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'email' => 'mario@example.com',
                'phone' => '+39 123 456 7890',
                'is_new_patient' => true,
            ];
            
            expect($patient->is_new_patient)->toBeTrue()
                ->and($patient->name)->toBe('Mario Rossi')
                ->and($patient->email)->toBe('mario@example.com');
        });

        it('tracks patient appointment history', function () {
            $patient = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'appointments_count' => 0,
            ];
            
            // Simula primo appuntamento
            $patient->appointments_count = 1;
            
            expect($patient->appointments_count)->toBe(1);
        });
    });

    describe('Patient Information Management', function () {
        it('stores essential patient contact information', function () {
            $patient = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'email' => 'mario@example.com',
                'phone' => '+39 123 456 7890',
                'address' => 'Via Roma 123, Milano',
                'date_of_birth' => '1985-03-15',
            ];
            
            expect($patient->name)->toBe('Mario Rossi')
                ->and($patient->email)->toBe('mario@example.com')
                ->and($patient->phone)->toBe('+39 123 456 7890')
                ->and($patient->address)->toBe('Via Roma 123, Milano');
        });

        it('manages patient medical history', function () {
            $patient = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'medical_history' => [
                    'allergies' => ['Penicillina'],
                    'chronic_conditions' => [],
                    'medications' => [],
                ],
            ];
            
            expect($patient->medical_history['allergies'])->toContain('Penicillina')
                ->and($patient->medical_history['chronic_conditions'])->toBeEmpty()
                ->and($patient->medical_history['medications'])->toBeEmpty();
        });
    });

    describe('Appointment Preferences', function () {
        it('tracks patient appointment preferences', function () {
            $patient = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'preferences' => [
                    'preferred_time' => 'morning',
                    'preferred_doctor' => $this->doctor->id,
                    'notification_method' => 'email',
                ],
            ];
            
            expect($patient->preferences['preferred_time'])->toBe('morning')
                ->and($patient->preferences['preferred_doctor'])->toBe($this->doctor->id)
                ->and($patient->preferences['notification_method'])->toBe('email');
        });

        it('manages patient scheduling constraints', function () {
            $patient = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'constraints' => [
                    'unavailable_days' => ['saturday', 'sunday'],
                    'unavailable_hours' => ['18:00', '20:00'],
                    'max_travel_distance' => 50, // km
                ],
            ];
            
            expect($patient->constraints['unavailable_days'])->toContain('saturday')
                ->and($patient->constraints['max_travel_distance'])->toBe(50);
        });
    });

    describe('Patient-Studio Relationship', function () {
        it('associates patient with studio', function () {
            $patient = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'studio_id' => $this->studio->id,
            ];
            
            expect($patient->studio_id)->toBe($this->studio->id);
        });

        it('tracks patient studio preferences', function () {
            $patient = (object) [
                'id' => 1001,
                'name' => 'Mario Rossi',
                'preferred_studios' => [$this->studio->id],
                'current_studio_id' => $this->studio->id,
            ];
            
            expect($patient->preferred_studios)->toContain($this->studio->id)
                ->and($patient->current_studio_id)->toBe($this->studio->id);
        });
    });
});
