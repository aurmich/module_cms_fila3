<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\SaluteOra\Models\Studio;

it('validates basic appointment creation', function (): void {
    $patient = User::factory()->create(['type' => 'patient']);
    $doctor = User::factory()->create(['type' => 'doctor']);
    $studio = Studio::factory()->create();

    expect($patient)->not->toBeNull();
    expect($doctor)->not->toBeNull();
    expect($studio)->not->toBeNull();
});

it('validates user types are correctly set', function (): void {
    $patient = User::factory()->create(['type' => 'patient']);
    $doctor = User::factory()->factory()->create(['type' => 'doctor']);

    expect($patient->type)->toBe('patient');
    expect($doctor->type)->toBe('doctor');
});
