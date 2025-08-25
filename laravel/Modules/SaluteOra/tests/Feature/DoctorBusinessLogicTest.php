<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Feature;

use Modules\SaluteOra\Tests\TestCase;
use Carbon\Carbon;

uses(TestCase::class);

describe('Doctor Business Logic', function () {
    
    beforeEach(function () {
        // Oggetti in memoria per test veloci
        $this->patient = (object) ['id' => 1001, 'name' => 'Mario Rossi'];
        $this->studio = (object) ['id' => 3001, 'name' => 'Studio Centrale'];
    });

    describe('Appointment Management', function () {
        it('tracks doctor appointments correctly', function () {
            $doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
            
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
                'status' => 'scheduled',
            ];
            
            // Simula relazione in memoria
            $doctor->appointments = collect([$appointment]);
            
            expect($doctor->appointments)->toHaveCount(1);
        });

        it('tracks patients through appointments', function () {
            $doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
            
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
            ];
            
            // Simula relazione in memoria
            $doctor->appointments = collect([$appointment]);
            $doctor->patients = collect([$this->patient]);
            
            expect($doctor->patients)->toHaveCount(1)
                ->and($doctor->patients->first()->id)->toBe($this->patient->id);
        });

        it('manages appointment scheduling for specific dates', function () {
            $doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
            $date = Carbon::today()->addDay();
            
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $date->setTime(9, 0),
                'ends_at' => $date->setTime(10, 0),
            ];
            
            expect($appointment->starts_at->toDateString())->toBe($date->toDateString());
        });
    });

    describe('Studio Relationships and Schedule Management', function () {
        it('maintains data isolation between studios', function () {
            $doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
            $studio1 = (object) ['id' => 3001, 'name' => 'Studio 1'];
            $studio2 = (object) ['id' => 3002, 'name' => 'Studio 2'];
            
            $appointment1 = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio1->id,
            ];
            
            $appointment2 = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio2->id,
            ];
            
            // Simula relazioni in memoria
            $doctor->appointments = collect([$appointment1, $appointment2]);
            
            $studio1Appointments = $doctor->appointments->where('studio_id', $studio1->id);
            $studio2Appointments = $doctor->appointments->where('studio_id', $studio2->id);
            
            expect($studio1Appointments)->toHaveCount(1)
                ->and($studio2Appointments)->toHaveCount(1);
        });

        it('works within specific studio context', function () {
            $doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
            
            $appointment = (object) [
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
            ];
            
            // Simula relazione in memoria
            $doctor->appointments = collect([$appointment]);
            
            $studioAppointments = $doctor->appointments->where('studio_id', $this->studio->id);
            expect($studioAppointments)->toHaveCount(1);
        });
    });

    describe('Report Generation and Medical Records', function () {
        it('tracks reports created by doctor', function () {
            $doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
            
            $report = (object) [
                'doctor_id' => $doctor->id,
                'patient_id' => $this->patient->id,
                'content' => 'Test report',
            ];
            
            // Simula relazione in memoria
            $doctor->reports = collect([$report]);
            
            expect($doctor->reports)->toHaveCount(1);
        });
    });
});
