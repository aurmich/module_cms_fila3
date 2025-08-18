<?php

declare(strict_types=1);

use Modules\SaluteMo\Models\Appointment;
use Modules\SaluteMo\Enums\AppointmentStatus;
use Modules\SaluteMo\Enums\AppointmentType;

test('appointment can be created', function () {
    $appointment = createAppointment([
        'title' => 'Test Appointment',
        'starts_at' => now(),
        'ends_at' => now()->addHour(),
        'status' => AppointmentStatus::SCHEDULED,
        'type' => AppointmentType::CONSULTATION,
    ]);

    expect($appointment)
        ->toBeAppointment()
        ->and($appointment->title)->toBe('Test Appointment')
        ->and($appointment->status)->toBe(AppointmentStatus::SCHEDULED)
        ->and($appointment->type)->toBe(AppointmentType::CONSULTATION);
});

test('appointment has required attributes', function () {
    $appointment = makeAppointment();

    expect($appointment)
        ->toHaveProperty('title')
        ->toHaveProperty('starts_at')
        ->toHaveProperty('ends_at')
        ->toHaveProperty('status')
        ->toHaveProperty('type')
        ->toHaveProperty('patient_id')
        ->toHaveProperty('doctor_id')
        ->toHaveProperty('studio_id');
});

test('appointment can be marked as emergency', function () {
    $appointment = createAppointment(['emergency' => true]);
    
    expect($appointment->emergency)->toBeTrue();
});

test('appointment duration is calculated correctly', function () {
    $startsAt = now();
    $endsAt = $startsAt->copy()->addMinutes(30);
    
    $appointment = createAppointment([
        'starts_at' => $startsAt,
        'ends_at' => $endsAt,
    ]);
    
    expect($appointment->duration_minutes)->toBe(30);
});

test('appointment can change status', function () {
    $appointment = createAppointment(['status' => AppointmentStatus::SCHEDULED]);
    
    $appointment->update(['status' => AppointmentStatus::CONFIRMED]);
    
    expect($appointment->fresh()->status)->toBe(AppointmentStatus::CONFIRMED);
});
