<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Carbon\Carbon;

describe('Doctor Business Logic', function () {
    
    beforeEach(function () {
        $this->patient = Patient::factory()->create();
        $this->studio = Studio::factory()->create();
    });

    describe('Appointment Management', function () {
        it('tracks doctor appointments correctly', function () {
            $doctor = Doctor::factory()->create();
            
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            expect($doctor->appointments)->toHaveCount(1)
                ->and($doctor->appointments->first()->id)->toBe($appointment->id);
        });

        it('tracks patients through appointments', function () {
            $doctor = Doctor::factory()->create();
            
            Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($doctor->patients)->toHaveCount(1)
                ->and($doctor->patients->first()->id)->toBe($this->patient->id);
        });

        it('manages appointment scheduling for specific dates', function () {
            $doctor = Doctor::factory()->create();
            $date = Carbon::today()->addDay();
            
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
                'starts_at' => $date->setTime(9, 0),
                'ends_at' => $date->setTime(10, 0),
            ]);
            
            expect($appointment->starts_at->toDateString())->toBe($date->toDateString());
        });
    });

    describe('Studio Relationships and Schedule Management', function () {
        it('maintains data isolation between studios', function () {
            $doctor = Doctor::factory()->create();
            $studio1 = Studio::factory()->create();
            $studio2 = Studio::factory()->create();
            
            Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio1->id,
            ]);
            
            Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio2->id,
            ]);
            
            expect($doctor->appointments->where('studio_id', $studio1->id))->toHaveCount(1)
                ->and($doctor->appointments->where('studio_id', $studio2->id))->toHaveCount(1);
        });

        it('works within specific studio context', function () {
            $doctor = Doctor::factory()->create();
            
            Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($doctor->appointments->where('studio_id', $this->studio->id))->toHaveCount(1);
        });
    });

    describe('Report Generation and Medical Records', function () {
        it('tracks reports created by doctor', function () {
            $doctor = Doctor::factory()->create();
            
            $appointment = Appointment::factory()->create([
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            $report = Report::factory()->create([
                'appointment_id' => $appointment->id,
                'patient_id' => $this->patient->id,
                'doctor_id' => $doctor->id,
            ]);
            
            expect($doctor->reports)->toHaveCount(1)
                ->and($doctor->reports->first()->id)->toBe($report->id);
        });
    });
});
