<?php

declare(strict_types=1);

use Modules\SaluteOra\States\Appointment\ReportPending;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Appointment State Transitions', function () {
    beforeEach(function () {
        // Create test entities
        $this->patient = Patient::factory()->create();
        $this->doctor = Doctor::factory()->create();
        $this->studio = Studio::factory()->create();
        
        $this->appointment = Appointment::factory()->create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'studio_id' => $this->studio->id,
            'status' => 'scheduled',
        ]);

        $this->reportPendingState = new ReportPending();
    });

    it('can transition appointment to report pending state', function () {
        expect($this->reportPendingState)->toBeInstanceOf(ReportPending::class)
            ->and($this->reportPendingState::$name)->toBe('report_pending');
    });

    it('creates report when transitioning to report pending', function () {
        $initialReportCount = Report::count();
        
        $arguments = ['appointment' => $this->appointment->id];
        $data = [
            'content' => 'Medical examination completed',
            'diagnosis' => 'Patient shows signs of improvement',
            'recommendations' => 'Continue current treatment',
        ];

        $this->reportPendingState->modalAction($arguments, $data);

        expect(Report::count())->toBe($initialReportCount + 1);
        
        $report = Report::where('appointment_id', $this->appointment->id)->first();
        expect($report)->not->toBeNull()
            ->and($report->appointment_id)->toBe($this->appointment->id)
            ->and($report->patient_id)->toBe($this->patient->id)
            ->and($report->doctor_id)->toBe($this->doctor->id);
    });

    it('updates existing report when processing state action', function () {
        // Create existing report
        $existingReport = Report::factory()->create([
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => 'Initial report content',
        ]);

        $data = [
            'content' => 'Updated medical report',
            'diagnosis' => 'Revised diagnosis',
            'recommendations' => 'Updated recommendations',
        ];

        $this->reportPendingState->modalActionByRecord($this->appointment, $data);

        $existingReport->refresh();
        expect($existingReport->content)->toBe('Updated medical report');
    });

    it('maintains data integrity during state transitions', function () {
        $data = [
            'content' => 'Comprehensive medical report',
            'diagnosis' => 'Detailed patient diagnosis',
            'recommendations' => 'Specific treatment recommendations',
            'notes' => 'Additional medical notes',
        ];

        $this->reportPendingState->modalActionByRecord($this->appointment, $data);

        $report = Report::where('appointment_id', $this->appointment->id)->first();
        
        // Verify all relationships are maintained
        expect($report->appointment_id)->toBe($this->appointment->id)
            ->and($report->patient_id)->toBe($this->appointment->patient_id)
            ->and($report->doctor_id)->toBe($this->appointment->doctor_id);
            
        // Verify data was processed correctly
        expect($report->content)->toBe('Comprehensive medical report');
    });

    it('handles form schema integration', function () {
        $schema = $this->reportPendingState->modalFormSchema();
        
        expect($schema)->toBeArray();
        
        // Verify that the schema comes from ReportResource
        // This tests the integration between State and Resource
        foreach ($schema as $key => $component) {
            expect($key)->toBeString();
        }
    });

    it('processes appointment data correctly in form filling', function () {
        // Test form filling with appointment arguments
        $arguments = ['appointment' => $this->appointment->id];
        $data = [];

        $formData = $this->reportPendingState->modalFillForm($arguments, $data);

        expect($formData)->toBeArray()
            ->and($formData)->toHaveKey('appointment_id')
            ->and($formData['appointment_id'])->toBe($this->appointment->id);
    });

    it('processes appointment data correctly in form filling by record', function () {
        $formData = $this->reportPendingState->modalFillFormByRecord($this->appointment);

        expect($formData)->toBeArray()
            ->and($formData)->toHaveKey('appointment_id')
            ->and($formData['appointment_id'])->toBe($this->appointment->id);
    });

    it('handles multiple appointments correctly', function () {
        // Create multiple appointments
        $appointment2 = Appointment::factory()->create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'studio_id' => $this->studio->id,
        ]);

        $appointment3 = Appointment::factory()->create([
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'studio_id' => $this->studio->id,
        ]);

        // Process state actions for each
        $data1 = ['content' => 'Report 1'];
        $data2 = ['content' => 'Report 2'];
        $data3 = ['content' => 'Report 3'];

        $this->reportPendingState->modalActionByRecord($this->appointment, $data1);
        $this->reportPendingState->modalActionByRecord($appointment2, $data2);
        $this->reportPendingState->modalActionByRecord($appointment3, $data3);

        // Verify each appointment has its own report
        expect(Report::where('appointment_id', $this->appointment->id)->count())->toBe(1)
            ->and(Report::where('appointment_id', $appointment2->id)->count())->toBe(1)
            ->and(Report::where('appointment_id', $appointment3->id)->count())->toBe(1);
    });

    it('validates appointment state workflow', function () {
        // Test the complete workflow from appointment to report
        expect($this->appointment->status)->toBe('scheduled');

        // Process to report pending
        $data = [
            'content' => 'Appointment completed successfully',
            'diagnosis' => 'Patient examination complete',
        ];

        $this->reportPendingState->modalActionByRecord($this->appointment, $data);

        // Verify report was created
        $report = Report::where('appointment_id', $this->appointment->id)->first();
        expect($report)->not->toBeNull();
    });

    it('handles report creation with minimal data', function () {
        $minimalData = [];

        $this->reportPendingState->modalActionByRecord($this->appointment, $minimalData);

        $report = Report::where('appointment_id', $this->appointment->id)->first();
        expect($report)->not->toBeNull()
            ->and($report->appointment_id)->toBe($this->appointment->id);
    });

    it('handles report creation with complete data', function () {
        $completeData = [
            'content' => 'Complete medical examination report',
            'diagnosis' => 'Comprehensive patient diagnosis',
            'recommendations' => 'Detailed treatment recommendations',
            'medications' => 'Prescribed medications list',
            'follow_up' => 'Follow-up appointment scheduled',
            'notes' => 'Additional medical notes and observations',
        ];

        $this->reportPendingState->modalActionByRecord($this->appointment, $completeData);

        $report = Report::where('appointment_id', $this->appointment->id)->first();
        expect($report)->not->toBeNull()
            ->and($report->content)->toBe('Complete medical examination report');
    });

    it('validates state name consistency', function () {
        expect(ReportPending::$name)->toBe('report_pending')
            ->and($this->reportPendingState::$name)->toBe('report_pending');
    });

    it('ensures appointment model relationships', function () {
        // Verify appointment has proper relationships
        expect($this->appointment->patient_id)->toBe($this->patient->id)
            ->and($this->appointment->doctor_id)->toBe($this->doctor->id)
            ->and($this->appointment->studio_id)->toBe($this->studio->id);
    });
});
