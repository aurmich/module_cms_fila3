<?php

declare(strict_types=1);

use Modules\SaluteOra\States\Appointment\ReportPending;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Filament\Resources\ReportResource;
use Illuminate\Database\Eloquent\Model;


describe('ReportPending State', function () {
    beforeEach(function () {
        $this->state = new ReportPending();
        
        // Create test appointment
        $this->appointment = Appointment::factory()->create([
            'patient_id' => 1,
            'doctor_id' => 2,
            'studio_id' => 1,
        ]);
    });

    it('can be instantiated', function () {
        expect($this->state)->toBeInstanceOf(ReportPending::class);
    });

    it('has correct state name', function () {
        expect(ReportPending::$name)->toBe('report_pending');
    });

    it('returns form schema from ReportResource', function () {
        // Mock ReportResource::getFormSchema to return a predictable structure
        $schema = $this->state->modalFormSchema();

        expect($schema)->toBeArray();
    });

    it('fills form with report data using arguments', function () {
        // Create a report for testing
        $report = Report::factory()->create([
            'appointment_id' => $this->appointment->id,
            'content' => 'Test report content',
            'diagnosis' => 'Test diagnosis',
        ]);

        $arguments = ['appointment' => $this->appointment->id];
        $data = [];

        $result = $this->state->modalFillForm($arguments, $data);

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('creates report if not exists when filling form', function () {
        $initialCount = Report::count();
        
        $arguments = ['appointment' => $this->appointment->id];
        $data = [];

        $result = $this->state->modalFillForm($arguments, $data);

        expect(Report::count())->toBe($initialCount + 1)
            ->and($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('fills form by record', function () {
        // Create a report for testing
        $report = Report::factory()->create([
            'appointment_id' => $this->appointment->id,
            'content' => 'Test report content',
        ]);

        $result = $this->state->modalFillFormByRecord($this->appointment);

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('creates report if not exists when filling form by record', function () {
        $initialCount = Report::count();

        $result = $this->state->modalFillFormByRecord($this->appointment);

        expect(Report::count())->toBe($initialCount + 1)
            ->and($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id');
    });

    it('processes modal action with arguments', function () {
        $arguments = ['appointment' => $this->appointment->id];
        $data = [
            'content' => 'Updated report content',
            'diagnosis' => 'Updated diagnosis',
        ];

        // This should not throw an exception
        expect(fn () => $this->state->modalAction($arguments, $data))->not->toThrow(Exception::class);
        
        // Verify report was created/updated
        $report = Report::where('appointment_id', $this->appointment->id)->first();
        expect($report)->not->toBeNull()
            ->and($report->appointment_id)->toBe($this->appointment->id)
            ->and($report->patient_id)->toBe($this->appointment->patient_id)
            ->and($report->doctor_id)->toBe($this->appointment->doctor_id);
    });

    it('processes modal action by record', function () {
        $data = [
            'content' => 'Test report content',
            'diagnosis' => 'Test diagnosis',
            'recommendations' => 'Test recommendations',
        ];

        // This should not throw an exception
        expect(fn () => $this->state->modalActionByRecord($this->appointment, $data))->not->toThrow(Exception::class);
        
        // Verify report was created/updated
        $report = Report::where('appointment_id', $this->appointment->id)->first();
        expect($report)->not->toBeNull()
            ->and($report->appointment_id)->toBe($this->appointment->id)
            ->and($report->patient_id)->toBe($this->appointment->patient_id)
            ->and($report->doctor_id)->toBe($this->appointment->doctor_id);
    });

    it('updates existing report when processing action', function () {
        // Create existing report
        $existingReport = Report::factory()->create([
            'appointment_id' => $this->appointment->id,
            'content' => 'Original content',
        ]);

        $data = [
            'content' => 'Updated content',
            'diagnosis' => 'New diagnosis',
        ];

        $this->state->modalActionByRecord($this->appointment, $data);

        $existingReport->refresh();
        expect($existingReport->content)->toBe('Updated content');
    });

    it('handles appointment not found gracefully in modal action', function () {
        $arguments = ['appointment' => 99999]; // Non-existent ID
        $data = ['content' => 'Test'];

        expect(fn () => $this->state->modalAction($arguments, $data))
            ->toThrow(\Webmozart\Assert\InvalidArgumentException::class);
    });

    it('validates appointment instance in modal action by record', function () {
        $invalidModel = new class extends Model {
            protected $table = 'invalid_table';
        };

        $data = ['content' => 'Test'];

        expect(fn () => $this->state->modalActionByRecord($invalidModel, $data))
            ->toThrow(\Webmozart\Assert\InvalidArgumentException::class);
    });

    it('processes data correctly in modal action by record', function () {
        $data = [
            'content' => 'Detailed report content',
            'diagnosis' => 'Patient diagnosis',
            'recommendations' => 'Doctor recommendations',
            'extra_field' => 'Should be included',
        ];

        $this->state->modalActionByRecord($this->appointment, $data);

        $report = Report::where('appointment_id', $this->appointment->id)->first();
        
        // Verify all process data is set correctly
        expect($report->appointment_id)->toBe($this->appointment->id)
            ->and($report->patient_id)->toBe($this->appointment->patient_id)
            ->and($report->doctor_id)->toBe($this->appointment->doctor_id);
    });
});
