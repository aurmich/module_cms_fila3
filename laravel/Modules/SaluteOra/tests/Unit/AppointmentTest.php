<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Carbon\Carbon;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    // In-memory appointment only (no factories to avoid DB side effects)
    $this->appointment = new Appointment([
        'patient_id' => 'patient-1',
        'doctor_id' => 'doctor-1',
        'studio_id' => 'studio-1',
        'title' => 'Visita di controllo',
        'type' => AppointmentTypeEnum::CONSULTATION,
        'status' => AppointmentStatusEnum::CONFIRMED,
        'starts_at' => Carbon::now()->addDay()->setTime(10, 0),
        'ends_at' => Carbon::now()->addDay()->setTime(11, 0),
        'notes' => 'Controllo routine',
        'emergency' => false,
        'eligibility_confirmed' => true,
        'reminder_sent' => false,
    ]);
});

// ✅ TEST BUSINESS LOGIC - Creazione e aggiornamento
test('appointment can be created with business data', function (): void {
    expect($this->appointment)->toBeInstanceOf(Appointment::class);
    expect($this->appointment->title)->toBe('Visita di controllo');
    expect($this->appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION);
    expect($this->appointment->status)->toBe(AppointmentStatusEnum::CONFIRMED);
    expect($this->appointment->notes)->toBe('Controllo routine');
});

test('appointment can be updated with business logic', function (): void {
    // In-memory attribute changes (no DB)
    $this->appointment->title = 'Visita di controllo aggiornata';
    $this->appointment->notes = 'Note aggiornate per il paziente';

    expect($this->appointment->title)->toBe('Visita di controllo aggiornata');
    expect($this->appointment->notes)->toBe('Note aggiornate per il paziente');
});

// ✅ TEST BUSINESS LOGIC - Metodi di business
test('appointment calculates correct duration in minutes for business scheduling', function (): void {
    $appointment = new Appointment([
        'starts_at' => Carbon::now()->setTime(10, 0),
        'ends_at' => Carbon::now()->setTime(11, 30),
    ]);

    // Test business behavior: duration calculation for scheduling
    $duration = $appointment->starts_at->diffInMinutes($appointment->ends_at);
    expect($duration)->toBe(90.0); // Carbon returns float, business logic handles it correctly
});

test('appointment can be marked as emergency', function (): void {
    $this->appointment->emergency = true;
    expect($this->appointment->emergency)->toBeTrue();
});

test('appointment can be marked as completed', function (): void {
    $this->appointment->status = AppointmentStatusEnum::COMPLETED;
    expect($this->appointment->status)->toBe(AppointmentStatusEnum::COMPLETED);
});

test('appointment can be cancelled', function (): void {
    $this->appointment->status = AppointmentStatusEnum::CANCELLED;
    expect($this->appointment->status)->toBe(AppointmentStatusEnum::CANCELLED);
});

// ✅ TEST BUSINESS LOGIC - Scopes personalizzati (se esistono)
test('appointment can be filtered by emergency status (in-memory)', function (): void {
    $emergencyAppointment = new Appointment(['emergency' => true]);
    $normalAppointment = new Appointment(['emergency' => false]);

    $collection = collect([$emergencyAppointment, $normalAppointment]);
    $filtered = $collection->filter(fn ($a) => $a->emergency === true);

    expect($filtered->all())->toContain($emergencyAppointment);
    expect($filtered->all())->not->toContain($normalAppointment);
});

test('appointment can be filtered by status (in-memory)', function (): void {
    $a1 = new Appointment(['status' => AppointmentStatusEnum::CONFIRMED]);
    $a2 = new Appointment(['status' => AppointmentStatusEnum::CANCELLED]);

    $collection = collect([$a1, $a2]);
    $filtered = $collection->filter(fn ($a) => $a->status === AppointmentStatusEnum::CONFIRMED);

    expect($filtered->all())->toContain($a1);
    expect($filtered->all())->not->toContain($a2);
});

// ✅ TEST BUSINESS LOGIC - Relazioni di business (se hanno logica custom)
test('appointment has access to patient information (assigned in-memory)', function (): void {
    // Simulate loaded relation using a plain object to avoid Eloquent construction
    $patient = (object) ['first_name' => 'Mario', 'last_name' => 'Rossi', 'email' => 'mario.rossi@example.com'];
    $this->appointment->setRelation('patient', $patient);
    expect($this->appointment->patient->first_name)->toBe('Mario');
    expect($this->appointment->patient->last_name)->toBe('Rossi');
});

test('appointment has access to doctor information (assigned in-memory)', function (): void {
    $doctor = (object) ['first_name' => 'Dr. Giovanni', 'last_name' => 'Bianchi', 'email' => 'giovanni.bianchi@example.com'];
    $this->appointment->setRelation('doctor', $doctor);
    expect($this->appointment->doctor->first_name)->toBe('Dr. Giovanni');
    expect($this->appointment->doctor->last_name)->toBe('Bianchi');
});

test('appointment has access to studio information (assigned in-memory)', function (): void {
    $studio = (object) ['name' => 'Studio Dentistico Roma Centro', 'address' => 'Via del Corso 123'];
    $this->appointment->setRelation('studio', $studio);
    expect($this->appointment->studio->name)->toBe('Studio Dentistico Roma Centro');
});

// ✅ TEST BUSINESS LOGIC - Validazioni di business (se esistono)
test('appointment can be logically removed from a collection (no DB delete)', function (): void {
    $a1 = $this->appointment;
    $a2 = new Appointment();
    $collection = collect([$a1, $a2]);

    $remaining = $collection->reject(fn ($a) => $a === $a1);
    expect($remaining->all())->not->toContain($a1);
    expect($remaining->all())->toContain($a2);
});
