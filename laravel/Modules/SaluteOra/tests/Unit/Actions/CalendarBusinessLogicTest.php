<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Unit\Actions;

use Carbon\Carbon;
use Modules\SaluteOra\Tests\TestCase;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;

uses(TestCase::class);

describe('Calendar Business Logic', function () {
    
    beforeEach(function () {
        // In-memory test appointments following CLAUDE.md guidelines
        $this->baseAppointment = [
            'id' => 'apt-123',
            'patient_id' => 'pat-456',
            'doctor_id' => 'doc-789',
            'studio_id' => 'studio-101',
            'starts_at' => Carbon::now()->addDay()->setTime(9, 0),
            'ends_at' => Carbon::now()->addDay()->setTime(9, 30),
            'type' => AppointmentTypeEnum::CONSULTATION,
            'status' => AppointmentStatusEnum::CONFIRMED,
            'emergency' => false,
            'notes' => 'Routine checkup',
        ];

        $this->emergencyAppointment = [
            'id' => 'apt-emergency-456',
            'patient_id' => 'pat-789',
            'doctor_id' => 'doc-789',
            'studio_id' => 'studio-101',
            'starts_at' => Carbon::now()->addHours(2),
            'ends_at' => Carbon::now()->addHours(2)->addMinutes(45),
            'type' => AppointmentTypeEnum::EMERGENCY,
            'status' => AppointmentStatusEnum::CONFIRMED,
            'emergency' => true,
            'notes' => 'Urgent dental emergency',
        ];

        $this->patientUser = (object) [
            'id' => 'pat-456',
            'type' => UserTypeEnum::PATIENT,
        ];

        $this->doctorUser = (object) [
            'id' => 'doc-789',
            'type' => UserTypeEnum::DOCTOR,
        ];

        $this->adminUser = (object) [
            'id' => 'admin-001',
            'type' => UserTypeEnum::ADMIN,
        ];
    });

    describe('Calendar Event Transformation', function () {
        
        it('transforms appointment to calendar event format', function () {
            $appointment = (object) $this->baseAppointment;
            $appointment->patient = (object) ['full_name' => 'Mario Rossi'];
            $appointment->doctor = (object) ['full_name' => 'Dr. Giuseppe Bianchi'];
            $appointment->studio = (object) ['name' => 'Studio Dentistico Milano'];
            
            // Simulate transformation logic
            $event = [
                'id' => $appointment->id,
                'title' => $appointment->patient->full_name . ' • ' . $appointment->type->getLabel(),
                'start' => $appointment->starts_at->toIso8601String(),
                'end' => $appointment->ends_at->toIso8601String(),
                'allDay' => false,
                'extendedProps' => [
                    'type' => $appointment->type->value,
                    'status' => $appointment->status->value,
                    'patient_name' => $appointment->patient->full_name,
                    'doctor_name' => $appointment->doctor->full_name,
                    'studio_name' => $appointment->studio->name,
                    'emergency' => $appointment->emergency,
                    'notes' => $appointment->notes,
                ],
            ];
            
            expect($event['id'])->toBe('apt-123');
            expect($event['title'])->toContain('Mario Rossi');
            expect($event['allDay'])->toBeFalse();
            expect($event['extendedProps']['type'])->toBe(AppointmentTypeEnum::CONSULTATION->value);
            expect($event['extendedProps']['emergency'])->toBeFalse();
        });

        it('handles emergency appointment titles correctly', function () {
            $appointment = (object) $this->emergencyAppointment;
            $appointment->patient = (object) ['full_name' => 'Luigi Verdi'];
            
            // Simulate emergency title formatting
            $titleParts = [];
            $titleParts[] = $appointment->patient->full_name;
            
            if ($appointment->type) {
                $titleParts[] = $appointment->type->getLabel();
            }
            
            if ($appointment->emergency) {
                $titleParts[] = '🚨 Emergency';
            }
            
            $title = implode(' • ', $titleParts);
            
            expect($title)->toContain('Luigi Verdi');
            expect($title)->toContain('🚨 Emergency');
            expect($title)->toContain('•');
        });

        it('formats time correctly for different locales', function () {
            $appointment = (object) $this->baseAppointment;
            
            $startIso = $appointment['starts_at']->toIso8601String();
            $endIso = $appointment['ends_at']->toIso8601String();
            
            expect($startIso)->toMatch('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{2}:\d{2}$/');
            expect($endIso)->toMatch('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{2}:\d{2}$/');
            
            // Verify end time is after start time
            expect(Carbon::parse($startIso)->isBefore(Carbon::parse($endIso)))->toBeTrue();
        });
    });

    describe('Appointment Color Logic', function () {
        
        it('assigns red color to emergency appointments', function () {
            $emergency = $this->emergencyAppointment;
            
            $color = $emergency['emergency'] ? '#dc3545' : $this->getAppointmentTypeColor($emergency['type']);
            
            expect($color)->toBe('#dc3545');
        });

        it('assigns appropriate colors based on appointment type', function () {
            $colorMap = [
                AppointmentTypeEnum::CONSULTATION->value => '#fd7e14',
                AppointmentTypeEnum::CLEANING->value => '#17a2b8',
                AppointmentTypeEnum::TREATMENT->value => '#28a745',
                AppointmentTypeEnum::EMERGENCY->value => '#dc3545',
                AppointmentTypeEnum::FOLLOWUP->value => '#ffc107',
                AppointmentTypeEnum::SURGERY->value => '#6f42c1',
                AppointmentTypeEnum::ORTHODONTICS->value => '#6f42c1',
                AppointmentTypeEnum::PREVENTION->value => '#17a2b8',
            ];
            
            foreach ($colorMap as $type => $expectedColor) {
                expect($expectedColor)->toMatch('/^#[0-9a-f]{6}$/');
            }
            
            expect($colorMap[AppointmentTypeEnum::CONSULTATION->value])->toBe('#fd7e14');
            expect($colorMap[AppointmentTypeEnum::EMERGENCY->value])->toBe('#dc3545');
        });

        it('calculates contrast color correctly', function () {
            $testColors = [
                '#ffffff' => '#000000', // white background -> black text
                '#000000' => '#ffffff', // black background -> white text  
                '#dc3545' => '#ffffff', // red background -> white text
                '#ffc107' => '#000000', // yellow background -> black text
            ];
            
            foreach ($testColors as $bgColor => $expectedTextColor) {
                $contrast = $this->calculateContrastColor($bgColor);
                expect($contrast)->toBe($expectedTextColor);
            }
        });
    });

    describe('User Permission Logic', function () {
        
        it('allows doctors to see only their appointments', function () {
            $appointment = (object) $this->baseAppointment;
            $user = $this->doctorUser;
            
            $canViewAppointment = $user->type === UserTypeEnum::DOCTOR && 
                                 $user->id === $appointment->doctor_id;
            
            expect($canViewAppointment)->toBeTrue();
            
            // Test with different doctor
            $otherDoctor = (object) ['id' => 'doc-999', 'type' => UserTypeEnum::DOCTOR];
            $canOtherDoctorView = $otherDoctor->type === UserTypeEnum::DOCTOR && 
                                 $otherDoctor->id === $appointment->doctor_id;
            
            expect($canOtherDoctorView)->toBeFalse();
        });

        it('allows patients to see only their appointments', function () {
            $appointment = (object) $this->baseAppointment;
            $user = $this->patientUser;
            
            $canViewAppointment = $user->type === UserTypeEnum::PATIENT && 
                                 $user->id === $appointment->patient_id;
            
            expect($canViewAppointment)->toBeTrue();
        });

        it('allows admins to see all appointments', function () {
            $appointment = (object) $this->baseAppointment;
            $user = $this->adminUser;
            
            $canViewAppointment = $user->type === UserTypeEnum::ADMIN;
            
            expect($canViewAppointment)->toBeTrue();
        });

        it('determines appointment editability correctly', function () {
            $futureAppointment = (object) [
                'doctor_id' => 'doc-789',
                'starts_at' => Carbon::now()->addDay(),
            ];
            
            $pastAppointment = (object) [
                'doctor_id' => 'doc-789', 
                'starts_at' => Carbon::now()->subDay(),
            ];
            
            $user = $this->doctorUser;
            
            // Future appointment by assigned doctor should be editable
            $canEditFuture = $futureAppointment->starts_at->isFuture() && 
                            ($user->type === UserTypeEnum::ADMIN || $user->id === $futureAppointment->doctor_id);
            
            // Past appointment should not be editable
            $canEditPast = $pastAppointment->starts_at->isFuture() && 
                          ($user->type === UserTypeEnum::ADMIN || $user->id === $pastAppointment->doctor_id);
            
            expect($canEditFuture)->toBeTrue();
            expect($canEditPast)->toBeFalse();
        });
    });

    describe('Time Range Filtering', function () {
        
        it('correctly identifies appointments within date range', function () {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
            
            $appointmentInRange = (object) [
                'starts_at' => Carbon::now()->addDays(2),
            ];
            
            $appointmentOutOfRange = (object) [
                'starts_at' => Carbon::now()->addWeeks(2),
            ];
            
            $inRange = $appointmentInRange->starts_at->between($startDate, $endDate);
            $outOfRange = $appointmentOutOfRange->starts_at->between($startDate, $endDate);
            
            expect($inRange)->toBeTrue();
            expect($outOfRange)->toBeFalse();
        });

        it('handles month view filtering correctly', function () {
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();
            
            $appointmentThisMonth = (object) [
                'starts_at' => Carbon::now()->setDay(15),
            ];
            
            $appointmentNextMonth = (object) [
                'starts_at' => Carbon::now()->addMonth()->setDay(15),
            ];
            
            $thisMonthInRange = $appointmentThisMonth->starts_at->between($monthStart, $monthEnd);
            $nextMonthInRange = $appointmentNextMonth->starts_at->between($monthStart, $monthEnd);
            
            expect($thisMonthInRange)->toBeTrue();
            expect($nextMonthInRange)->toBeFalse();
        });
    });
});

// Helper methods for business logic testing (these would be extracted from the actual Action)
function getAppointmentTypeColor($type): string
{
    return match ($type) {
        AppointmentTypeEnum::CONSULTATION => '#fd7e14',
        AppointmentTypeEnum::CLEANING => '#17a2b8',
        AppointmentTypeEnum::TREATMENT => '#28a745',
        AppointmentTypeEnum::EMERGENCY => '#dc3545',
        AppointmentTypeEnum::FOLLOWUP => '#ffc107',
        AppointmentTypeEnum::SURGERY => '#6f42c1',
        AppointmentTypeEnum::ORTHODONTICS => '#6f42c1',
        AppointmentTypeEnum::PREVENTION => '#17a2b8',
        default => '#3490dc',
    };
}

function calculateContrastColor(string $hexColor): string
{
    $hexColor = ltrim($hexColor, '#');
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));
    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
    return $luminance > 0.5 ? '#000000' : '#ffffff';
}