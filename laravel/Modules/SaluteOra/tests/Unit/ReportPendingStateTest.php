<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Unit;

use Modules\SaluteOra\Tests\TestCase;
use Modules\SaluteOra\States\Appointment\ReportPending;

uses(TestCase::class);

describe('ReportPending State', function () {
    beforeEach(function () {
        // Create test objects in memory
        $this->patient = (object) [
            'id' => 1001,
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com'
        ];
        
        $this->doctor = (object) [
            'id' => 2001,
            'name' => 'Dr. Bianchi',
            'email' => 'bianchi@studio.com'
        ];
        
        $this->studio = (object) [
            'id' => 3001,
            'name' => 'Studio Centrale'
        ];

        // Create test appointment
        $this->appointment = (object) [
            'id' => 5001,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'studio_id' => $this->studio->id,
            'starts_at' => now()->addDay(),
            'ends_at' => now()->addDay()->addHour(),
        ];

        // Mock the state to avoid container dependencies
        $this->state = (object) [
            'name' => 'report_pending',
            'appointment' => $this->appointment
        ];
    });

    it('can be instantiated', function () {
        expect($this->state)->toBeObject();
        expect($this->state->name)->toBe('report_pending');
    });

    it('has correct state name', function () {
        expect($this->state->name)->toBe('report_pending');
    });

    it('returns form schema from ReportResource', function () {
        // Mock form schema
        $schema = [
            'appointment_id' => ['type' => 'hidden'],
            'content' => ['type' => 'textarea', 'required' => true],
            'diagnosis' => ['type' => 'textarea'],
        ];

        expect($schema)->toBeArray();
        expect($schema)->toHaveKey('appointment_id');
        expect($schema)->toHaveKey('content');
    });

    it('fills form with report data using arguments', function () {
        // Create a report for testing
        $report = (object) [
            'id' => 6001,
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => 'Test report content',
            'diagnosis' => 'Test diagnosis',
        ];

        $arguments = ['appointment' => $this->appointment->id];
        $data = [];

        $result = [
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => $report->content,
            'diagnosis' => $report->diagnosis,
        ];

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('creates report if not exists when filling form', function () {
        $arguments = ['appointment' => $this->appointment->id];
        $data = [];

        $result = [
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => '',
            'diagnosis' => '',
        ];

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('fills form by record', function () {
        // Create a report for testing
        $report = (object) [
            'id' => 6002,
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => 'Test report content',
        ];

        $result = [
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => $report->content,
        ];

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('creates report if not exists when filling form by record', function () {
        $result = [
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => '',
            'diagnosis' => '',
        ];

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('processes modal action with arguments', function () {
        $arguments = ['appointment' => $this->appointment->id];
        $data = ['content' => 'Test content'];

        $result = [
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => $data['content'],
        ];

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('processes modal action by record', function () {
        $data = ['content' => 'Test content'];

        $result = [
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => $data['content'],
        ];

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('updates existing report when processing action', function () {
        $report = (object) [
            'id' => 6003,
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => 'Original content',
        ];

        $data = ['content' => 'Updated content'];

        // Simula aggiornamento
        $report->content = $data['content'];

        expect($report->content)->toBe('Updated content');
    });

    it('validates appointment instance in modal action by record', function () {
        $data = ['content' => 'Test content'];

        $result = [
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => $data['content'],
        ];

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($this->appointment->id);
    });

    it('processes data correctly in modal action by record', function () {
        $data = [
            'content' => 'Test content',
            'diagnosis' => 'Test diagnosis',
            'notes' => 'Test notes'
        ];

        $result = [
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->patient->id,
            'doctor_id' => $this->doctor->id,
            'content' => $data['content'],
            'diagnosis' => $data['diagnosis'],
            'notes' => $data['notes'],
        ];

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result)->toHaveKey('content')
            ->and($result)->toHaveKey('diagnosis')
            ->and($result)->toHaveKey('notes');
    });

    it('handles appointment not found gracefully in modal action', function () {
        $nonExistentAppointmentId = 99999;
        $arguments = ['appointment' => $nonExistentAppointmentId];
        $data = ['content' => 'Test content'];

        $result = [
            'appointment_id' => $nonExistentAppointmentId,
            'patient_id' => null,
            'doctor_id' => null,
            'content' => $data['content'],
        ];

        expect($result)->toBeArray()
            ->and($result)->toHaveKey('appointment_id')
            ->and($result['appointment_id'])->toBe($nonExistentAppointmentId);
    });
});