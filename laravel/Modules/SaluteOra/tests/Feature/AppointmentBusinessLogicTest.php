<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\States\Appointment\Pending;
use Modules\SaluteOra\States\Appointment\Confirmed;
use Modules\SaluteOra\States\Appointment\Completed;
use Modules\SaluteOra\States\Appointment\Cancelled;
use Modules\SaluteOra\States\Appointment\NoShow;

uses(Tests\TestCase::class);

describe('Appointment Business Logic', function () {
    
    describe('State Transitions', function () {
        it('transitions from pending to confirmed correctly', function () {
            $appointment = Appointment::factory()->create(['state' => Pending::class]);
            
            // BUSINESS BEHAVIOR: Transizione da pending a confirmed
            $appointment->state->transitionTo(Confirmed::class);
            
            expect($appointment->fresh()->state)->toBeInstanceOf(Confirmed::class)
                ->and($appointment->status)->toBe(AppointmentStatusEnum::CONFIRMED);
        });

        it('transitions from confirmed to completed correctly', function () {
            $appointment = Appointment::factory()->create(['state' => Confirmed::class]);
            
            // BUSINESS BEHAVIOR: Transizione da confirmed a completed
            $appointment->state->transitionTo(Completed::class);
            
            expect($appointment->fresh()->state)->toBeInstanceOf(Completed::class)
                ->and($appointment->status)->toBe(AppointmentStatusEnum::COMPLETED);
        });

        it('transitions from confirmed to cancelled correctly', function () {
            $appointment = Appointment::factory()->create(['state' => Confirmed::class]);
            
            // BUSINESS BEHAVIOR: Transizione da confirmed a cancelled
            $appointment->state->transitionTo(Cancelled::class);
            
            expect($appointment->fresh()->state)->toBeInstanceOf(Cancelled::class)
                ->and($appointment->status)->toBe(AppointmentStatusEnum::CANCELLED);
        });

        it('prevents invalid state transitions', function () {
            $appointment = Appointment::factory()->create(['state' => Completed::class]);
            
            // BUSINESS BEHAVIOR: Non dovrebbe permettere transizione da completed a confirmed
            expect(fn() => $appointment->state->transitionTo(Confirmed::class))
                ->toThrow(\InvalidArgumentException::class);
        });
    });

    describe('Scheduling Constraints', function () {
        it('detects overlapping appointments for same doctor', function () {
            $doctor = Doctor::factory()->create();
            $studio = Studio::factory()->create();
            
            // Appuntamento esistente
            Appointment::factory()->create([
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'start_time' => '2024-01-15 10:00:00',
                'end_time' => '2024-01-15 11:00:00',
                'state' => Confirmed::class
            ]);
            
            // BUSINESS BEHAVIOR: Dovrebbe rilevare sovrapposizione
            $overlapping = Appointment::hasOverlap(
                $doctor->id,
                '2024-01-15 10:30:00',
                '2024-01-15 11:30:00'
            );
            
            expect($overlapping)->toBeTrue();
        });

        it('allows non-overlapping appointments for same doctor', function () {
            $doctor = Doctor::factory()->create();
            $studio = Studio::factory()->create();
            
            // Appuntamento esistente
            Appointment::factory()->create([
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'start_time' => '2024-01-15 10:00:00',
                'end_time' => '2024-01-15 11:00:00',
                'state' => Confirmed::class
            ]);
            
            // BUSINESS BEHAVIOR: Non dovrebbe rilevare sovrapposizione
            $overlapping = Appointment::hasOverlap(
                $doctor->id,
                '2024-01-15 11:30:00',
                '2024-01-15 12:30:00'
            );
            
            expect($overlapping)->toBeFalse();
        });

        it('ignores cancelled appointments for overlap detection', function () {
            $doctor = Doctor::factory()->create();
            $studio = Studio::factory()->create();
            
            // Appuntamento cancellato
            Appointment::factory()->create([
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'start_time' => '2024-01-15 10:00:00',
                'end_time' => '2024-01-15 11:00:00',
                'state' => Cancelled::class
            ]);
            
            // BUSINESS BEHAVIOR: Appuntamenti cancellati non dovrebbero causare sovrapposizione
            $overlapping = Appointment::hasOverlap(
                $doctor->id,
                '2024-01-15 10:30:00',
                '2024-01-15 11:30:00'
            );
            
            expect($overlapping)->toBeFalse();
        });
    });

    describe('Revenue Calculation', function () {
        it('calculates correct revenue for completed appointment', function () {
            $appointment = Appointment::factory()->create([
                'state' => Completed::class,
                'duration' => 1.5, // 1.5 ore
                'hourly_rate' => 100.00
            ]);
            
            // BUSINESS BEHAVIOR: Calcolo revenue corretto
            expect($appointment->calculateRevenue())->toBe(150.00);
        });

        it('returns zero revenue for non-completed appointments', function () {
            $appointment = Appointment::factory()->create([
                'state' => Pending::class,
                'duration' => 1.5,
                'hourly_rate' => 100.00
            ]);
            
            // BUSINESS BEHAVIOR: Solo appuntamenti completed generano revenue
            expect($appointment->calculateRevenue())->toBe(0.00);
        });

        it('handles pro bono appointments with zero revenue', function () {
            $appointment = Appointment::factory()->create([
                'state' => Completed::class,
                'duration' => 1.5,
                'hourly_rate' => 0.00, // Pro bono
                'is_pro_bono' => true
            ]);
            
            // BUSINESS BEHAVIOR: Appuntamenti pro bono hanno revenue zero
            expect($appointment->calculateRevenue())->toBe(0.00);
        });
    });

    describe('Patient History', function () {
        it('retrieves patient appointment history correctly', function () {
            $patient = Patient::factory()->create();
            $doctor = Doctor::factory()->create();
            $studio = Studio::factory()->create();
            
            // Appuntamenti completati
            Appointment::factory()->count(3)->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'state' => Completed::class
            ]);
            
            // BUSINESS BEHAVIOR: Storia appuntamenti completati
            $history = $patient->getCompletedAppointments();
            
            expect($history)->toHaveCount(3)
                ->and($history->every->state)->toBeInstanceOf(Completed::class);
        });

        it('filters appointments by date range', function () {
            $patient = Patient::factory()->create();
            $doctor = Doctor::factory()->create();
            $studio = Studio::factory()->create();
            
            // Appuntamenti in date diverse
            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'start_time' => '2024-01-10 10:00:00',
                'state' => Completed::class
            ]);
            
            Appointment::factory()->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'start_time' => '2024-01-15 10:00:00',
                'state' => Completed::class
            ]);
            
            // BUSINESS BEHAVIOR: Filtro per range date
            $filtered = $patient->getAppointmentsInDateRange('2024-01-12', '2024-01-20');
            
            expect($filtered)->toHaveCount(1)
                ->and($filtered->first()->start_time->format('Y-m-d'))->toBe('2024-01-15');
        });
    });

    describe('No Show Handling', function () {
        it('tracks no-show appointments count', function () {
            $patient = Patient::factory()->create();
            $doctor = Doctor::factory()->create();
            $studio = Studio::factory()->create();
            
            // Appuntamenti no-show
            Appointment::factory()->count(2)->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'state' => NoShow::class
            ]);
            
            // BUSINESS BEHAVIOR: Conteggio no-show corretto
            expect($patient->getNoShowCount())->toBe(2);
        });

        it('determines if patient should be blocked due to no-shows', function () {
            $patient = Patient::factory()->create();
            $doctor = Doctor::factory()->create();
            $studio = Studio::factory()->create();
            
            // 3 no-show (soglia di blocco)
            Appointment::factory()->count(3)->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'state' => NoShow::class
            ]);
            
            // BUSINESS BEHAVIOR: Paziente con 3+ no-show dovrebbe essere bloccato
            expect($patient->shouldBeBlockedDueToNoShows())->toBeTrue();
        });

        it('allows patient with less than threshold no-shows', function () {
            $patient = Patient::factory()->create();
            $doctor = Doctor::factory()->create();
            $studio = Studio::factory()->create();
            
            // 2 no-show (sotto soglia)
            Appointment::factory()->count(2)->create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'studio_id' => $studio->id,
                'state' => NoShow::class
            ]);
            
            // BUSINESS BEHAVIOR: Paziente con meno di 3 no-show non dovrebbe essere bloccato
            expect($patient->shouldBeBlockedDueToNoShows())->toBeFalse();
        });
    });
});