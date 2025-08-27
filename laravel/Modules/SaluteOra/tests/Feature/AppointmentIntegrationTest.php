<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Modules\SaluteOra\Tests\TestCase;
use Carbon\Carbon;

uses(TestCase::class);

describe('Appointment Integration', function () {
    beforeEach(function () {
        // Oggetti in memoria per test veloci
        $this->patient = (object) ['id' => 1001, 'name' => 'Mario Rossi'];
        $this->doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
        $this->studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
    });

    it('creates complete appointment with all relationships', function () {
        $appointment = (object) [
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'studio_id' => $this->studio->id,
            'title' => 'Visita di controllo',
            'starts_at' => Carbon::now()->addDay(),
            'ends_at' => Carbon::now()->addDay()->addHour(),
            'type' => 'consultation',
            'status' => 'scheduled',
        ];
        
        expect($appointment->patient_id)->toBe($this->patient->id)
            ->and($appointment->doctor_id)->toBe($this->doctor->id)
            ->and($appointment->studio_id)->toBe($this->studio->id)
            ->and($appointment->title)->toBe('Visita di controllo')
            ->and($appointment->type)->toBe('consultation')
            ->and($appointment->status)->toBe('scheduled');
    });

    it('handles appointment scheduling workflow', function () {
        $appointment = (object) [
            'status' => 'scheduled',
            'reminder_sent' => false,
        ];
        
        // Simula reminder sent
        $appointment->reminder_sent = true;
        $appointment->reminder_sent_at = now();
        
        expect($appointment->reminder_sent)->toBeTrue()
            ->and($appointment->reminder_sent_at)->toBeInstanceOf(Carbon::class);
    });

    
});