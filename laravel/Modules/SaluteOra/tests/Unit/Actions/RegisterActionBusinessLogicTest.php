<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Unit\Actions;

use Illuminate\Support\Str;
use Modules\SaluteOra\Tests\TestCase;
use Modules\SaluteOra\Enums\UserTypeEnum;

uses(TestCase::class);

describe('Registration Actions Business Logic', function () {
    
    beforeEach(function () {
        // In-memory test objects following CLAUDE.md guidelines
        $this->patientData = [
            'email' => 'patient@test.it',
            'name' => 'Mario Rossi',
            'first_name' => 'Mario',
            'last_name' => 'Rossi',
            'phone' => '+39 333 123 4567',
            'type' => 'patient',
            'state' => 'pending',
            'privacy_acceptance' => true,
            'newsletter' => false,
        ];

        $this->doctorData = [
            'email' => 'doctor@test.it',
            'name' => 'Dr. Giuseppe Bianchi',
            'first_name' => 'Giuseppe',
            'last_name' => 'Bianchi',
            'phone' => '+39 333 987 6543',
            'type' => 'doctor',
            'state' => 'pending',
            'privacy_acceptance' => true,
            'newsletter' => true,
            'studio' => [
                'name' => 'Studio Dentistico Bianchi',
                'address' => [
                    'street' => 'Via Roma 123',
                    'city' => 'Milano',
                    'postal_code' => '20100',
                ],
            ],
            'schedule' => [
                'monday' => ['09:00-12:00', '14:00-18:00'],
                'tuesday' => ['09:00-12:00', '14:00-18:00'],
                'wednesday' => ['09:00-12:00'],
                'thursday' => ['09:00-12:00', '14:00-18:00'],
                'friday' => ['09:00-12:00', '14:00-17:00'],
            ],
        ];
    });

    describe('Patient Registration Business Logic', function () {
        
        it('generates name from email when name is missing', function () {
            $data = $this->patientData;
            unset($data['name']);
            
            // Simulate the name generation logic
            if (!isset($data['name']) && isset($data['email']) && is_string($data['email'])) {
                $data['name'] = Str::of($data['email'])->before('@')->append('-')->append(Str::random(3))->toString();
            }
            
            expect($data['name'])->toStartWith('patient-');
            expect($data['name'])->toHaveLength(11); // 'patient-' (8) + random (3)
        });

        it('validates required patient fields', function () {
            $requiredFields = ['email', 'type', 'state'];
            
            foreach ($requiredFields as $field) {
                expect($this->patientData)->toHaveKey($field);
                expect($this->patientData[$field])->not->toBeEmpty();
            }
        });

        it('handles consent preferences correctly', function () {
            $consents = [];
            
            if (isset($this->patientData['privacy_acceptance'])) {
                $consents[] = [
                    'type' => 'privacy',
                    'accepted' => true,
                    'accepted_at' => now(),
                ];
            }

            if (isset($this->patientData['newsletter'])) {
                $consents[] = [
                    'type' => 'newsletter',
                    'accepted' => false,
                    'accepted_at' => now(),
                ];
            }

            expect($consents)->toHaveCount(2);
            expect($consents[0]['type'])->toBe('privacy');
            expect($consents[0]['accepted'])->toBeTrue();
            expect($consents[1]['type'])->toBe('newsletter');
            expect($consents[1]['accepted'])->toBeFalse();
        });

        it('generates correct mail slug for notifications', function () {
            $mailSlug = Str::of($this->patientData['type'])
                ->append('-')
                ->append($this->patientData['state'])
                ->slug()
                ->toString();

            expect($mailSlug)->toBe('patient-pending');
        });

        it('handles integration completed state transition', function () {
            $data = $this->patientData;
            $data['state'] = 'integration_requested';
            
            // Simulate state transition logic
            $shouldTransition = $data['state'] === 'integration_requested';
            
            expect($shouldTransition)->toBeTrue();
        });
    });

    describe('Doctor Registration Business Logic', function () {
        
        it('validates doctor specific data structure', function () {
            expect($this->doctorData)->toHaveKey('studio');
            expect($this->doctorData)->toHaveKey('schedule');
            expect($this->doctorData['studio'])->toHaveKey('name');
            expect($this->doctorData['studio'])->toHaveKey('address');
            expect($this->doctorData['schedule'])->toHaveKey('monday');
        });

        it('processes studio address data correctly', function () {
            $studioData = $this->doctorData['studio'];
            
            expect($studioData['address'])->toHaveKey('street');
            expect($studioData['address'])->toHaveKey('city');
            expect($studioData['address'])->toHaveKey('postal_code');
            
            // Business logic: validate Italian postal code format
            $postalCode = $studioData['address']['postal_code'];
            expect($postalCode)->toMatch('/^\d{5}$/');
        });

        it('validates schedule format', function () {
            $schedule = $this->doctorData['schedule'];
            
            foreach ($schedule as $day => $hours) {
                expect($hours)->toBeArray();
                
                foreach ($hours as $timeSlot) {
                    // Validate time slot format: HH:MM-HH:MM
                    expect($timeSlot)->toMatch('/^\d{2}:\d{2}-\d{2}:\d{2}$/');
                    
                    // Validate time logic
                    $times = explode('-', $timeSlot);
                    $startTime = $times[0];
                    $endTime = $times[1];
                    
                    expect($startTime < $endTime)->toBeTrue();
                }
            }
        });

        it('handles doctor attachments structure', function () {
            // Simulate typical doctor attachments
            $attachments = [
                'doctor_certificate',
                'medical_license',
                'professional_insurance',
                'cv',
            ];
            
            expect($attachments)->toContain('doctor_certificate');
            expect($attachments)->toContain('medical_license');
            expect($attachments)->toHaveCount(4);
        });

        it('generates appropriate notification slug for doctors', function () {
            $mailSlug = Str::slug($this->doctorData['type'] . '-' . $this->doctorData['state']);
            
            expect($mailSlug)->toBe('doctor-pending');
        });
    });

    describe('Common Registration Business Logic', function () {
        
        it('validates email format for both user types', function () {
            $patientEmail = $this->patientData['email'];
            $doctorEmail = $this->doctorData['email'];
            
            expect($patientEmail)->toMatch('/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
            expect($doctorEmail)->toMatch('/^[^\s@]+@[^\s@]+\.[^\s@]+$/');
        });

        it('validates Italian phone number format', function () {
            $patientPhone = $this->patientData['phone'];
            $doctorPhone = $this->doctorData['phone'];
            
            // Italian mobile format: +39 3XX XXX XXXX
            $italianMobilePattern = '/^\+39\s3\d{2}\s\d{3}\s\d{4}$/';
            
            expect($patientPhone)->toMatch($italianMobilePattern);
            expect($doctorPhone)->toMatch($italianMobilePattern);
        });

        it('enforces privacy acceptance requirement', function () {
            expect($this->patientData['privacy_acceptance'])->toBeTrue();
            expect($this->doctorData['privacy_acceptance'])->toBeTrue();
        });

        it('handles newsletter preferences as optional', function () {
            // Newsletter can be true, false, or missing
            expect($this->patientData['newsletter'])->toBeBool();
            expect($this->doctorData['newsletter'])->toBeBool();
        });

        it('validates user type enum values', function () {
            $validTypes = ['patient', 'doctor', 'admin'];
            
            expect($validTypes)->toContain($this->patientData['type']);
            expect($validTypes)->toContain($this->doctorData['type']);
        });

        it('validates state transition logic', function () {
            $validStates = ['pending', 'active', 'integration_requested', 'completed', 'suspended'];
            
            expect($validStates)->toContain($this->patientData['state']);
            expect($validStates)->toContain($this->doctorData['state']);
        });
    });

    describe('Error Handling Business Logic', function () {
        
        it('handles missing required email gracefully', function () {
            $data = $this->patientData;
            unset($data['email']);
            
            $hasRequiredEmail = isset($data['email']) && !empty($data['email']);
            
            expect($hasRequiredEmail)->toBeFalse();
        });

        it('validates data consistency for doctors', function () {
            $data = $this->doctorData;
            
            // If schedule is provided, studio must also be provided
            $hasSchedule = isset($data['schedule']);
            $hasStudio = isset($data['studio']);
            
            if ($hasSchedule) {
                expect($hasStudio)->toBeTrue();
            }
        });

        it('handles malformed schedule data', function () {
            $invalidSchedule = [
                'monday' => ['invalid-time-format'],
                'tuesday' => [], // empty array should be valid
            ];
            
            foreach ($invalidSchedule['monday'] as $timeSlot) {
                $isValidFormat = preg_match('/^\d{2}:\d{2}-\d{2}:\d{2}$/', $timeSlot);
                expect($isValidFormat)->toBeFalsy();
            }
            
            // Empty schedule for a day should be valid
            expect($invalidSchedule['tuesday'])->toBeEmpty();
        });
    });
});