<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Carbon\Carbon;

describe('Appointment Integration', function () {
    it('creates complete appointment with all relationships', function () {
        $patient = Patient::factory()->create();
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();
        
        $appointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'title' => 'Visita di controllo',
            'starts_at' => Carbon::now()->addDay(),
            'ends_at' => Carbon::now()->addDay()->addHour(),
            'type' => AppointmentTypeEnum::CONSULTATION,
            'status' => AppointmentStatusEnum::SCHEDULED,
        ]);
        
        expect($appointment->patient->id)->toBe($patient->id)
            ->and($appointment->doctor->id)->toBe($doctor->id)
            ->and($appointment->studio->id)->toBe($studio->id)
            ->and($appointment->title)->toBe('Visita di controllo')
            ->and($appointment->type)->toBe(AppointmentTypeEnum::CONSULTATION)
            ->and($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
    });

    it('handles appointment scheduling workflow', function () {
        $appointment = Appointment::factory()->create([
            'status' => AppointmentStatusEnum::SCHEDULED,
            'reminder_sent' => false,
        ]);
        
        // Simulate reminder sent
        $appointment->update([
            'reminder_sent' => true,
            'reminder_sent_at' => now(),
        ]);
        
        expect($appointment->reminder_sent)->toBeTrue()
            ->and($appointment->reminder_sent_at)->toBeInstanceOf(Carbon::class);
    });

    it('can filter appointments by date range', function () {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $nextWeek = Carbon::now()->addWeek();
        
        Appointment::factory()->create(['starts_at' => $today]);
        Appointment::factory()->create(['starts_at' => $tomorrow]);
        Appointment::factory()->create(['starts_at' => $nextWeek]);
        
        $thisWeekAppointments = Appointment::whereBetween('starts_at', [
            $today->startOfWeek(),
            $today->endOfWeek()
        ])->get();
        
        expect($thisWeekAppointments)->toHaveCount(2);
    });
});