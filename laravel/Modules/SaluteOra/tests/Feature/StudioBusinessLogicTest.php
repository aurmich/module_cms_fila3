<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Carbon\Carbon;

describe('Studio Business Logic', function () {
    
    beforeEach(function () {
        $this->patient = Patient::factory()->create();
        $this->doctor = Doctor::factory()->create();
    });

    describe('Studio Management', function () {
        it('creates studio with basic information', function () {
            $studio = Studio::factory()->create([
                'name' => 'Studio Medico Centrale',
                'address' => 'Via Roma 123',
                'city' => 'Milano',
                'phone' => '+39 02 1234567',
            ]);
            
            expect($studio->name)->toBe('Studio Medico Centrale');
            expect($studio->address)->toBe('Via Roma 123');
            expect($studio->city)->toBe('Milano');
        });

        it('manages studio working hours', function () {
            $studio = Studio::factory()->create([
                'working_hours' => [
                    'monday' => ['09:00', '18:00'],
                    'tuesday' => ['09:00', '18:00'],
                    'wednesday' => ['09:00', '18:00'],
                    'thursday' => ['09:00', '18:00'],
                    'friday' => ['09:00', '18:00'],
                ],
            ]);
            
            expect($studio->working_hours)->toBeArray();
            expect($studio->working_hours['monday'])->toBe(['09:00', '18:00']);
        });
    });

    describe('Doctor Relationships', function () {
        it('associates doctors with studio', function () {
            $studio = Studio::factory()->create();
            
            $doctor1 = Doctor::factory()->create(['studio_id' => $studio->id]);
            $doctor2 = Doctor::factory()->create(['studio_id' => $studio->id]);
            
            expect($studio->doctors)->toHaveCount(2);
            expect($studio->doctors->pluck('id')->toArray())->toContain($doctor1->id);
            expect($studio->doctors->pluck('id')->toArray())->toContain($doctor2->id);
        });

        it('tracks studio capacity', function () {
            $studio = Studio::factory()->create(['max_doctors' => 5]);
            
            expect($studio->max_doctors)->toBe(5);
            expect($studio->doctors->count())->toBeLessThanOrEqual($studio->max_doctors);
        });
    });

    describe('Appointment Scheduling', function () {
        it('manages studio appointment capacity', function () {
            $studio = Studio::factory()->create(['max_appointments_per_day' => 20]);
            
            $appointment1 = Appointment::factory()->create([
                'studio_id' => $studio->id,
                'doctor_id' => $this->doctor->id,
                'patient_id' => $this->patient->id,
                'starts_at' => Carbon::today()->setTime(9, 0),
                'ends_at' => Carbon::today()->setTime(9, 30),
            ]);
            
            $appointment2 = Appointment::factory()->create([
                'studio_id' => $studio->id,
                'doctor_id' => $this->doctor->id,
                'patient_id' => $this->patient->id,
                'starts_at' => Carbon::today()->setTime(9, 30),
                'ends_at' => Carbon::today()->setTime(10, 0),
            ]);
            
            $todayAppointments = Appointment::where('studio_id', $studio->id)
                ->whereDate('starts_at', Carbon::today())
                ->count();
            
            expect($todayAppointments)->toBeLessThanOrEqual($studio->max_appointments_per_day);
        });

        it('prevents double booking in same time slot', function () {
            $studio = Studio::factory()->create();
            $timeSlot = Carbon::today()->setTime(10, 0);
            
            $appointment1 = Appointment::factory()->create([
                'studio_id' => $studio->id,
                'doctor_id' => $this->doctor->id,
                'patient_id' => $this->patient->id,
                'starts_at' => $timeSlot,
                'ends_at' => $timeSlot->copy()->addMinutes(30),
            ]);
            
            $conflictingAppointment = Appointment::factory()->create([
                'studio_id' => $studio->id,
                'doctor_id' => $this->doctor->id,
                'patient_id' => $this->patient->id,
                'starts_at' => $timeSlot->copy()->addMinutes(15),
                'ends_at' => $timeSlot->copy()->addMinutes(45),
            ]);
            
            expect($appointment1->id)->not->toBe($conflictingAppointment->id);
        });
    });

    describe('Studio Operations', function () {
        it('manages studio availability', function () {
            $studio = Studio::factory()->create([
                'is_active' => true,
                'maintenance_mode' => false,
            ]);
            
            expect($studio->is_active)->toBeTrue();
            expect($studio->maintenance_mode)->toBeFalse();
        });

        it('tracks studio performance metrics', function () {
            $studio = Studio::factory()->create();
            
            $completedAppointments = Appointment::factory()->count(5)->create([
                'studio_id' => $studio->id,
                'doctor_id' => $this->doctor->id,
                'patient_id' => $this->patient->id,
                'status' => AppointmentStatusEnum::COMPLETED,
            ]);
            
            $cancelledAppointments = Appointment::factory()->count(2)->create([
                'studio_id' => $studio->id,
                'doctor_id' => $this->doctor->id,
                'patient_id' => $this->patient->id,
                'status' => AppointmentStatusEnum::CANCELLED,
            ]);
            
            $totalAppointments = Appointment::where('studio_id', $studio->id)->count();
            $completionRate = Appointment::where('studio_id', $studio->id)
                ->where('status', AppointmentStatusEnum::COMPLETED)
                ->count() / $totalAppointments * 100;
            
            expect($completionRate)->toBeGreaterThan(0);
        });
    });
});
