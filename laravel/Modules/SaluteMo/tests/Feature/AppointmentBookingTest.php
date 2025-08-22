<?php

declare(strict_types=1);

use Modules\User\Models\User;
use Modules\SaluteOra\Models\Studio;

it('validates basic appointment booking setup', function () {
    $patient = User::factory()->create(['type' => 'patient']);
    $doctor = User::factory()->create(['type' => 'doctor']);
    $studio = Studio::factory()->create();

    expect($patient)->not->toBeNull();
    expect($doctor)->not->toBeNull();
    expect($studio)->not->toBeNull();
});

it('validates user types for appointment booking', function () {
    $patient = User::factory()->create(['type' => 'patient']);
    $doctor = User::factory()->create(['type' => 'doctor']);

    expect($patient->type)->toBe('patient');
    expect($doctor->type)->toBe('doctor');
});
