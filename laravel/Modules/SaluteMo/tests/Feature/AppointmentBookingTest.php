<?php

declare(strict_types=1);

use Modules\SaluteMo\Models\Appointment;
use Modules\SaluteMo\Enums\AppointmentStatus;
use Modules\SaluteMo\Enums\AppointmentType;
use Modules\User\Models\User;
use Modules\SaluteOra\Models\Studio;

test('patient can book appointment', function () {
    $patient = User::factory()->create(['type' => 'patient']);
    $doctor = User::factory()->create(['type' => 'doctor']);
    $studio = Studio::factory()->create();
    
    $appointmentData = [
        'title' => 'Consultation',
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'studio_id' => $studio->id,
        'starts_at' => now()->addDay(),
        'ends_at' => now()->addDay()->addHour(),
        'type' => AppointmentType::CONSULTATION,
        'status' => AppointmentStatus::SCHEDULED,
    ];
    
    $appointment = createAppointment($appointmentData);
    
    expect($appointment)
        ->toBeAppointment()
        ->and($appointment->patient)->toBeInstanceOf(User::class)
        ->and($appointment->doctor)->toBeInstanceOf(User::class)
        ->and($appointment->studio)->toBeInstanceOf(Studio::class);
});

test('appointment cannot overlap with existing appointments', function () {
    $doctor = User::factory()->create(['type' => 'doctor']);
    $studio = Studio::factory()->create();
    
    $baseTime = now()->addDay();
    
    // Create first appointment
    createAppointment([
        'doctor_id' => $doctor->id,
        'studio_id' => $studio->id,
        'starts_at' => $baseTime,
        'ends_at' => $baseTime->copy()->addHour(),
    ]);
    
    // Try to create overlapping appointment
    expect(fn () => createAppointment([
        'doctor_id' => $doctor->id,
        'studio_id' => $studio->id,
        'starts_at' => $baseTime->copy()->addMinutes(30),
        'ends_at' => $baseTime->copy()->addMinutes(90),
    ]))->toThrow(\Exception::class);
});

test('emergency appointment can be created', function () {
    $patient = User::factory()->create(['type' => 'patient']);
    $doctor = User::factory()->create(['type' => 'doctor']);
    $studio = Studio::factory()->create();
    
    $appointment = createAppointment([
        'patient_id' => $patient->id,
        'doctor_id' => $doctor->id,
        'studio_id' => $studio->id,
        'emergency' => true,
        'type' => AppointmentType::EMERGENCY,
    ]);
    
    expect($appointment)
        ->emergency->toBeTrue()
        ->type->toBe(AppointmentType::EMERGENCY);
});
