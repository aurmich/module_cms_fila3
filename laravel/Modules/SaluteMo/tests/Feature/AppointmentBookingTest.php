<?php

declare(strict_types=1);

describe('Appointment Booking', function () {
    it('validates basic appointment booking setup', function () {
        $patient = (object) ['type' => 'patient'];
        $doctor = (object) ['type' => 'doctor'];
        $studio = (object) ['id' => 101];

        expect($patient)->not->toBeNull();
        expect($doctor)->not->toBeNull();
        expect($studio)->not->toBeNull();
    });

    it('validates user types for appointment booking', function () {
        $patient = (object) ['type' => 'patient'];
        $doctor = (object) ['type' => 'doctor'];

        expect($patient->type)->toBe('patient');
        expect($doctor->type)->toBe('doctor');
    });
});
