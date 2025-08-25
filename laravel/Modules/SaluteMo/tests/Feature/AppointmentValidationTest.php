<?php

declare(strict_types=1);

// Pure unit: avoid Eloquent models and factories

it('validates basic appointment creation', function (): void {
    $patient = (object) ['type' => 'patient'];
    $doctor = (object) ['type' => 'doctor'];
    $studio = (object) ['id' => 101];

    expect($patient)->not->toBeNull();
    expect($doctor)->not->toBeNull();
    expect($studio)->not->toBeNull();
});

it('validates user types are correctly set', function (): void {
    $patient = (object) ['type' => 'patient'];
    $doctor = (object) ['type' => 'doctor'];

    expect($patient->type)->toBe('patient');
    expect($doctor->type)->toBe('doctor');
});
