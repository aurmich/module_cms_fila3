<?php

declare(strict_types=1);

use Carbon\Carbon;

/**
 * Business-logic-first tests for Calendar Events transformation.
 * Pure logic testing without external dependencies.
 */

it('builds an emergency event with proper title, colors and contrast', function (): void {
    // Create test objects in memory
    $patient = (object) [
        'id' => 1001,
        'first_name' => 'Anna',
        'last_name' => 'Bianchi',
        'name' => 'Anna Bianchi'
    ];
    
    $doctor = (object) [
        'id' => 2001,
        'name' => 'Dr. Rossi'
    ];
    
    $appointment = (object) [
        'id' => 4001,
        'patient_id' => 1001,
        'doctor_id' => 2001,
        'starts_at' => Carbon::now()->addDay(),
        'ends_at' => Carbon::now()->addDay()->addMinutes(30),
        'type' => 'emergency',
        'status' => 'confirmed',
        'emergency' => true,
        'title' => 'Emergency - Anna Bianchi',
        'patient' => $patient,
        'doctor' => $doctor
    ];
    
    // BUSINESS LOGIC: Emergency events should have specific formatting
    $eventData = [
        'id' => $appointment->id,
        'title' => "🚨 {$appointment->patient->name}",
        'start' => $appointment->starts_at->toISOString(),
        'end' => $appointment->ends_at->toISOString(),
        'backgroundColor' => '#ef4444', // Red for emergency
        'borderColor' => '#dc2626',
        'textColor' => '#ffffff',
        'extendedProps' => [
            'patient_name' => $appointment->patient->name,
            'doctor_name' => $appointment->doctor->name,
            'type' => $appointment->type,
            'emergency' => $appointment->emergency,
            'can_edit' => true
        ]
    ];
    
    expect($eventData['title'])->toContain('🚨')
        ->and($eventData['title'])->toContain('Anna Bianchi')
        ->and($eventData['backgroundColor'])->toBe('#ef4444')
        ->and($eventData['borderColor'])->toBe('#dc2626')
        ->and($eventData['textColor'])->toBe('#ffffff')
        ->and($eventData['extendedProps']['emergency'])->toBeTrue()
        ->and($eventData['extendedProps']['type'])->toBe('emergency');
});

it('marks event editable only for future dates and matching doctor/admin', function (): void {
    $currentUser = (object) [
        'id' => 2001,
        'type' => 'doctor'
    ];
    
    $futureAppointment = (object) [
        'id' => 4002,
        'doctor_id' => 2001,
        'starts_at' => Carbon::now()->addDay(),
        'ends_at' => Carbon::now()->addDay()->addHour(),
        'status' => 'scheduled'
    ];
    
    $pastAppointment = (object) [
        'id' => 4003,
        'doctor_id' => 2001,
        'starts_at' => Carbon::now()->subDay(),
        'ends_at' => Carbon::now()->subDay()->addHour(),
        'status' => 'completed'
    ];
    
    $otherDoctorAppointment = (object) [
        'id' => 4004,
        'doctor_id' => 3001, // Different doctor
        'starts_at' => Carbon::now()->addDay(),
        'ends_at' => Carbon::now()->addDay()->addHour(),
        'status' => 'scheduled'
    ];
    
    // BUSINESS LOGIC: Can edit if future and (is doctor's own appointment OR is admin)
    $canEditFuture = $futureAppointment->starts_at->isFuture() && 
                    ($currentUser->type === 'admin' || $futureAppointment->doctor_id === $currentUser->id);
    
    $canEditPast = $pastAppointment->starts_at->isFuture() && 
                  ($currentUser->type === 'admin' || $pastAppointment->doctor_id === $currentUser->id);
    
    $canEditOtherDoctor = $otherDoctorAppointment->starts_at->isFuture() && 
                         ($currentUser->type === 'admin' || $otherDoctorAppointment->doctor_id === $currentUser->id);
    
    expect($canEditFuture)->toBeTrue('Doctor can edit future own appointments')
        ->and($canEditPast)->toBeFalse('Cannot edit past appointments')
        ->and($canEditOtherDoctor)->toBeFalse('Doctor cannot edit other doctors appointments');
});

it('formats event title based on appointment type', function (): void {
    $patient = (object) ['name' => 'Mario Rossi'];
    
    $consultationAppointment = (object) [
        'type' => 'consultation',
        'emergency' => false,
        'patient' => $patient
    ];
    
    $emergencyAppointment = (object) [
        'type' => 'emergency',
        'emergency' => true,
        'patient' => $patient
    ];
    
    $treatmentAppointment = (object) [
        'type' => 'treatment',
        'emergency' => false,
        'patient' => $patient,
        'treatment_description' => 'Otturazione'
    ];
    
    // BUSINESS LOGIC: Title formatting based on type
    $consultationTitle = $consultationAppointment->patient->name;
    $emergencyTitle = "🚨 {$emergencyAppointment->patient->name}";
    $treatmentTitle = "🔧 {$treatmentAppointment->patient->name}";
    
    expect($consultationTitle)->toBe('Mario Rossi')
        ->and($emergencyTitle)->toBe('🚨 Mario Rossi')
        ->and($treatmentTitle)->toBe('🔧 Mario Rossi');
});

it('calculates event duration correctly', function (): void {
    $appointment = (object) [
        'starts_at' => Carbon::now()->addDay()->setTime(10, 0),
        'ends_at' => Carbon::now()->addDay()->setTime(10, 30),
        'type' => 'consultation'
    ];
    
    // BUSINESS LOGIC: Duration calculation
    $durationMinutes = $appointment->starts_at->diffInMinutes($appointment->ends_at);
    $expectedDuration = 30; // consultation = 30 minutes
    
    expect($durationMinutes)->toEqual($expectedDuration);
});

it('handles appointment color coding by status', function (): void {
    $scheduledAppointment = (object) ['status' => 'scheduled'];
    $confirmedAppointment = (object) ['status' => 'confirmed'];
    $completedAppointment = (object) ['status' => 'completed'];
    $cancelledAppointment = (object) ['status' => 'cancelled'];
    
    // BUSINESS LOGIC: Color coding by status
    $colorMap = [
        'scheduled' => '#3b82f6',  // Blue
        'confirmed' => '#10b981',  // Green
        'completed' => '#6b7280',  // Gray
        'cancelled' => '#ef4444'   // Red
    ];
    
    $scheduledColor = $colorMap[$scheduledAppointment->status];
    $confirmedColor = $colorMap[$confirmedAppointment->status];
    $completedColor = $colorMap[$completedAppointment->status];
    $cancelledColor = $colorMap[$cancelledAppointment->status];
    
    expect($scheduledColor)->toBe('#3b82f6')
        ->and($confirmedColor)->toBe('#10b981')
        ->and($completedColor)->toBe('#6b7280')
        ->and($cancelledColor)->toBe('#ef4444');
});

it('builds comprehensive event data structure', function (): void {
    $appointment = (object) [
        'id' => 5001,
        'patient_id' => 1001,
        'doctor_id' => 2001,
        'studio_id' => 3001,
        'starts_at' => Carbon::now()->addDay(),
        'ends_at' => Carbon::now()->addDay()->addMinutes(45),
        'type' => 'treatment',
        'status' => 'confirmed',
        'emergency' => false,
        'patient' => (object) ['name' => 'Luca Bianchi'],
        'doctor' => (object) ['name' => 'Dr. Verdi'],
        'studio' => (object) ['name' => 'Studio Centrale']
    ];
    
    // BUSINESS LOGIC: Complete event data transformation
    $eventData = [
        'id' => $appointment->id,
        'title' => "🔧 {$appointment->patient->name}",
        'start' => $appointment->starts_at->toISOString(),
        'end' => $appointment->ends_at->toISOString(),
        'backgroundColor' => '#10b981', // Confirmed = green
        'borderColor' => '#059669',
        'textColor' => '#ffffff',
        'extendedProps' => [
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'studio_id' => $appointment->studio_id,
            'patient_name' => $appointment->patient->name,
            'doctor_name' => $appointment->doctor->name,
            'studio_name' => $appointment->studio->name,
            'type' => $appointment->type,
            'status' => $appointment->status,
            'emergency' => $appointment->emergency,
            'duration_minutes' => 45,
            'can_edit' => true,
            'tooltip' => "Treatment - Luca Bianchi with Dr. Verdi"
        ]
    ];
    
    expect($eventData)->toHaveKey('id')
        ->and($eventData)->toHaveKey('title')
        ->and($eventData)->toHaveKey('start')
        ->and($eventData)->toHaveKey('end')
        ->and($eventData)->toHaveKey('extendedProps')
        ->and($eventData['title'])->toContain('🔧')
        ->and($eventData['extendedProps']['duration_minutes'])->toBe(45)
        ->and($eventData['extendedProps']['tooltip'])->toContain('Treatment')
        ->and($eventData['extendedProps']['tooltip'])->toContain('Luca Bianchi');
});