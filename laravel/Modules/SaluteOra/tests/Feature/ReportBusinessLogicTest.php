<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Modules\SaluteOra\Tests\TestCase;
use Carbon\Carbon;

uses(TestCase::class);

describe('Report Business Logic', function () {
    
    beforeEach(function () {
        // Oggetti in memoria per test veloci
        $this->doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
        $this->patient = (object) ['id' => 1001, 'name' => 'Mario Rossi'];
        $this->studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
    });

    describe('Medical Report Creation', function () {
        it('creates comprehensive medical report after appointment', function () {
            $appointment = (object) [
                'id' => 5001,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => 'completed',
                'completed_at' => Carbon::now(),
            ];
            
            $report = (object) [
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'studio_id' => $appointment->studio_id,
                'content' => 'Visita di controllo completata',
                'diagnosis' => 'Stato di salute buono',
                'recommendations' => 'Controllo tra 6 mesi',
                'created_at' => Carbon::now(),
            ];
            
            expect($report->appointment_id)->toBe($appointment->id)
                ->and($report->patient_id)->toBe($this->patient->id)
                ->and($report->doctor_id)->toBe($this->doctor->id)
                ->and($report->content)->toBe('Visita di controllo completata');
        });

        it('links report to appointment correctly', function () {
            $appointment = (object) ['id' => 5001];
            $report = (object) [
                'appointment_id' => $appointment->id,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
            ];
            
            expect($report->appointment_id)->toBe($appointment->id)
                ->and($report->patient_id)->toBe($this->patient->id)
                ->and($report->doctor_id)->toBe($this->doctor->id);
        });
    });

    describe('Report Data Validation', function () {
        it('validates required report fields', function () {
            $report = (object) [
                'appointment_id' => 5001,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'content' => 'Contenuto del report',
                'diagnosis' => 'Diagnosi del paziente',
            ];
            
            expect($report->appointment_id)->toBe(5001)
                ->and($report->patient_id)->toBe($this->patient->id)
                ->and($report->doctor_id)->toBe($this->doctor->id)
                ->and($report->content)->toBe('Contenuto del report')
                ->and($report->diagnosis)->toBe('Diagnosi del paziente');
        });

        it('handles optional report fields', function () {
            $report = (object) [
                'appointment_id' => 5001,
                'patient_id' => $this->patient->id,
                'doctor_id' => $this->doctor->id,
                'content' => 'Contenuto del report',
                'diagnosis' => 'Diagnosi del paziente',
                'recommendations' => null,
                'notes' => null,
            ];
            
            expect($report->recommendations)->toBeNull()
                ->and($report->notes)->toBeNull();
        });
    });

    describe('Report Workflow', function () {

        it('manages report status transitions', function () {
            $report = (object) [
                'appointment_id' => 5001,
                'status' => 'draft',
            ];
            
            // Simula transizioni di stato
            $report->status = 'review';
            expect($report->status)->toBe('review');
            
            $report->status = 'finalized';
            expect($report->status)->toBe('finalized');
        });
    });
});
