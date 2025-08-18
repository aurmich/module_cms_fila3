<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Carbon\Carbon;

describe('Appointment Model', function () {
    it('can be created with factory', function () {
        $appointment = Appointment::factory()->create();
        
        expect($appointment)->toBeInstanceOf(Appointment::class)
            ->and($appointment->exists)->toBeTrue()
            ->and($appointment->id)->toBeInt();
    });

    it('belongs to patient, doctor, and studio', function () {
        $patient = Patient::factory()->create();
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();
        
        $appointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
        ]);
        
        expect($appointment->patient)->toBeInstanceOf(Patient::class)
            ->and($appointment->doctor)->toBeInstanceOf(Doctor::class)
            ->and($appointment->studio)->toBeInstanceOf(Studio::class)
            ->and($appointment->patient->id)->toBe($patient->id)
            ->and($appointment->doctor->id)->toBe($doctor->id)
            ->and($appointment->studio->id)->toBe($studio->id);
    });

    it('has correct fillable attributes', function () {
        $appointment = new Appointment();
        
        expect($appointment->getFillable())->toContain([
            'patient_id', 'doctor_id', 'studio_id', 'tenant_id',
            'title', 'starts_at', 'ends_at', 'type', 'status',
            'notes', 'treatment_plan', 'emergency', 'eligibility_confirmed',
            'reminder_sent', 'reminder_sent_at'
        ]);
    });

    it('casts datetime fields correctly', function () {
        $appointment = Appointment::factory()->create([
            'starts_at' => '2024-01-01 10:00:00',
            'ends_at' => '2024-01-01 11:00:00',
            'reminder_sent_at' => '2024-01-01 09:00:00',
        ]);
        
        expect($appointment->starts_at)->toBeInstanceOf(Carbon::class)
            ->and($appointment->ends_at)->toBeInstanceOf(Carbon::class)
            ->and($appointment->reminder_sent_at)->toBeInstanceOf(Carbon::class);
    });

    it('casts enum fields correctly', function () {
        $appointment = Appointment::factory()->create([
            'type' => AppointmentTypeEnum::CONSULTATION,
            'status' => AppointmentStatusEnum::SCHEDULED,
        ]);
        
        expect($appointment->type)->toBeInstanceOf(AppointmentTypeEnum::class)
            ->and($appointment->status)->toBeInstanceOf(AppointmentStatusEnum::class);
    });

    it('casts boolean fields correctly', function () {
        $appointment = Appointment::factory()->create([
            'emergency' => true,
            'eligibility_confirmed' => false,
            'reminder_sent' => true,
        ]);
        
        expect($appointment->emergency)->toBeBool()
            ->and($appointment->eligibility_confirmed)->toBeBool()
            ->and($appointment->reminder_sent)->toBeBool()
            ->and($appointment->emergency)->toBeTrue()
            ->and($appointment->eligibility_confirmed)->toBeFalse()
            ->and($appointment->reminder_sent)->toBeTrue();
    });

    describe('Aliases and Accessors', function () {
        it('has dentist_id alias for doctor_id', function () {
            $appointment = Appointment::factory()->create();
            
            expect($appointment->dentist_id)->toBe($appointment->doctor_id);
        });

        it('has is_emergency alias for emergency', function () {
            $appointment = Appointment::factory()->create(['emergency' => true]);
            
            expect($appointment->is_emergency)->toBe($appointment->emergency)
                ->and($appointment->is_emergency)->toBeTrue();
        });
    });

    describe('Scopes and Queries', function () {
        it('can filter by status', function () {
            Appointment::factory()->create(['status' => AppointmentStatusEnum::SCHEDULED]);
            Appointment::factory()->create(['status' => AppointmentStatusEnum::COMPLETED]);
            
            $scheduledAppointments = Appointment::where('status', AppointmentStatusEnum::SCHEDULED)->get();
            $completedAppointments = Appointment::where('status', AppointmentStatusEnum::COMPLETED)->get();
            
            expect($scheduledAppointments)->toHaveCount(1)
                ->and($completedAppointments)->toHaveCount(1);
        });

        it('can filter by emergency status', function () {
            Appointment::factory()->create(['emergency' => true]);
            Appointment::factory()->create(['emergency' => false]);
            
            $emergencyAppointments = Appointment::where('emergency', true)->get();
            $regularAppointments = Appointment::where('emergency', false)->get();
            
            expect($emergencyAppointments)->toHaveCount(1)
                ->and($regularAppointments)->toHaveCount(1);
        });

        it('can filter by date range', function () {
            $today = Carbon::today();
            $tomorrow = Carbon::tomorrow();
            
            Appointment::factory()->create(['starts_at' => $today]);
            Appointment::factory()->create(['starts_at' => $tomorrow]);
            
            $todayAppointments = Appointment::whereDate('starts_at', $today)->get();
            
            expect($todayAppointments)->toHaveCount(1);
        });

        it('can filter by tenant', function () {
            $appointment1 = Appointment::factory()->create(['tenant_id' => 1]);
            $appointment2 = Appointment::factory()->create(['tenant_id' => 2]);
            
            $tenant1Appointments = Appointment::where('tenant_id', 1)->get();
            
            expect($tenant1Appointments)->toHaveCount(1)
                ->and($tenant1Appointments->first()->id)->toBe($appointment1->id);
        });
    });

    describe('Business Logic', function () {
        it('requires essential fields', function () {
            expect(fn() => Appointment::factory()->create(['patient_id' => null]))
                ->toThrow(\Illuminate\Database\QueryException::class);
                
            expect(fn() => Appointment::factory()->create(['doctor_id' => null]))
                ->toThrow(\Illuminate\Database\QueryException::class);
                
            expect(fn() => Appointment::factory()->create(['studio_id' => null]))
                ->toThrow(\Illuminate\Database\QueryException::class);
        });

        it('can have optional fields null', function () {
            $appointment = Appointment::factory()->create([
                'notes' => null,
                'treatment_plan' => null,
                'reminder_sent_at' => null,
            ]);
            
            expect($appointment->notes)->toBeNull()
                ->and($appointment->treatment_plan)->toBeNull()
                ->and($appointment->reminder_sent_at)->toBeNull();
        });

        it('logs activity when created', function () {
            $appointment = Appointment::factory()->create();
            
            expect($appointment)->toHaveMethod('getActivitylogOptions')
                ->and($appointment->getActivitylogOptions())->toBeInstanceOf(\Spatie\Activitylog\LogOptions::class);
        });
    });

    describe('State Management', function () {
        it('has states functionality', function () {
            $appointment = Appointment::factory()->create();
            
            expect($appointment)->toBeInstanceOf(\Spatie\ModelStates\HasStatesContract::class);
        });

        it('can transition between states', function () {
            $appointment = Appointment::factory()->create([
                'status' => AppointmentStatusEnum::SCHEDULED
            ]);
            
            expect($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
            
            // Test state transition if available
            if (method_exists($appointment, 'transitionTo')) {
                $appointment->transitionTo(\Modules\SaluteOra\States\Appointment\Confirmed::class);
                expect($appointment->status)->toBe(AppointmentStatusEnum::CONFIRMED);
            }
        });
    });
});