<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Carbon\Carbon;

describe('Patient Business Logic', function () {
    
    beforeEach(function () {
        $this->doctor = Doctor::factory()->create();
        $this->studio = Studio::factory()->create();
    });

    describe('Booking Eligibility', function () {
        it('allows new patient to book first appointment', function () {
            $patient = Patient::factory()->create();
            
            $appointment = Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            expect($appointment->patient->id)->toBe($patient->id)
                ->and($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
        });

        it('allows patient with completed appointments to book new appointment', function () {
            $patient = Patient::factory()->create();
            
            // Primo appuntamento completato
            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::COMPLETED,
            ]);
            
            // Nuovo appuntamento
            $newAppointment = Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
            
            expect($newAppointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
        });
    });

    describe('Relationships and Data Integrity', function () {
        it('maintains relationship with appointments', function () {
            $patient = Patient::factory()->create();
            
            $appointment = Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($patient->appointments)->toHaveCount(1)
                ->and($patient->appointments->first()->id)->toBe($appointment->id);
        });

        it('maintains relationship with doctors through appointments', function () {
            $patient = Patient::factory()->create();
            
            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($patient->appointments->first()->doctor->id)->toBe($this->doctor->id);
        });

        it('maintains relationship with studios through appointments', function () {
            $patient = Patient::factory()->create();
            
            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $this->doctor->id,
                'studio_id' => $this->studio->id,
            ]);
            
            expect($patient->appointments->first()->studio->id)->toBe($this->studio->id);
        });
    });
});
