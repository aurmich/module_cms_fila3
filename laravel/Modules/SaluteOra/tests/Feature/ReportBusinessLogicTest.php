<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Carbon\Carbon;

describe('Report Business Logic', function () {
    
    beforeEach(function () {
        $this->doctor = Doctor::factory()->create();
        $this->patient = Patient::factory()->create();
        $this->studio = Studio::factory()->create();
    });

    describe('Medical Report Creation', function () {
        it('creates comprehensive medical report after appointment', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'title' => 'Visita di controllo',
            ]);
            
            $report = Report::factory()->create([
                'appointment_id' => $appointment->id,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'content' => 'Esame clinico completo eseguito. Stato generale buono.',
                'diagnosis' => 'Nessuna patologia significativa rilevata',
                'treatment_plan' => 'Igiene orale professionale consigliata fra 6 mesi',
                'medications' => 'Nessuna prescrizione necessaria',
                'follow_up_date' => Carbon::now()->addMonths(6),
            ]);
            
            expect($report->appointment->id)->toBe($appointment->id)
                ->and($report->patient->id)->toBe($this->patient->id)
                ->and($report->doctor->id)->toBe($this->doctor->id)
                ->and($report->content)->toContain('Esame clinico completo')
                ->and($report->diagnosis)->toBe('Nessuna patologia significativa rilevata')
                ->and($report->treatment_plan)->toContain('Igiene orale professionale')
                ->and($report->follow_up_date)->toBeInstanceOf(Carbon::class);
        });

        it('links report to appointment correctly', function () {
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            $report = Report::factory()->create([
                'appointment_id' => $appointment->id,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
            ]);
            
            expect($report->appointment->id)->toBe($appointment->id);
        });
    });
});
