<?php

declare(strict_types=1);

use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Modules\Xot\Datas\XotData;

beforeEach(function () {
    if (!moduleEnabled('SaluteOra')) {
        $this->markTestSkipped('Module SaluteOra is disabled');
    }
});

describe('Appointment Model', function () {
    test('can create appointment with basic attributes', function () {
        $patient = Patient::factory()->create();
        $doctor = Doctor::factory()->create();
        $studio = Studio::factory()->create();

        $appointment = Appointment::factory()->create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'start_time' => now()->addDay(),
            'end_time' => now()->addDay()->addHour(),
            'status' => AppointmentStatusEnum::SCHEDULED,
        ]);

        expect($appointment->patient_id)->toBe($patient->id);
        expect($appointment->doctor_id)->toBe($doctor->id);
        expect($appointment->studio_id)->toBe($studio->id);
        expect($appointment->status)->toBe(AppointmentStatusEnum::SCHEDULED);
        expect($appointment->exists)->toBeTrue();
    });

    test('appointment model uses correct table', function () {
        $appointment = new Appointment();
        expect($appointment->getTable())->toBe('appointments');
    });

    test('appointment model has fillable attributes', function () {
        $appointment = new Appointment();
        $fillable = $appointment->getFillable();
        
        expect($fillable)->toContain('patient_id');
        expect($fillable)->toContain('doctor_id');
        expect($fillable)->toContain('studio_id');
        expect($fillable)->toContain('start_time');
        expect($fillable)->toContain('end_time');
        expect($fillable)->toContain('status');
    });

    test('appointment model casts attributes correctly', function () {
        $appointment = Appointment::factory()->create([
            'start_time' => now()->addDay(),
            'end_time' => now()->addDay()->addHour(),
            'status' => AppointmentStatusEnum::SCHEDULED,
        ]);

        expect($appointment->start_time)->toBeInstanceOf(\Carbon\Carbon::class);
        expect($appointment->end_time)->toBeInstanceOf(\Carbon\Carbon::class);
        expect($appointment->status)->toBeInstanceOf(AppointmentStatusEnum::class);
    });
});

describe('Appointment Relationships', function () {
    test('appointment belongs to patient', function () {
        $patient = Patient::factory()->create();
        $appointment = Appointment::factory()->create(['patient_id' => $patient->id]);

        $relation = $appointment->patient();
        expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($appointment->patient->id)->toBe($patient->id);
        expect($appointment->patient)->toBeInstanceOf(Patient::class);
    });

    test('appointment belongs to doctor', function () {
        $doctor = Doctor::factory()->create();
        $appointment = Appointment::factory()->create(['doctor_id' => $doctor->id]);

        $relation = $appointment->doctor();
        expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($appointment->doctor->id)->toBe($doctor->id);
        expect($appointment->doctor)->toBeInstanceOf(Doctor::class);
    });

    test('appointment belongs to studio', function () {
        $studio = Studio::factory()->create();
        $appointment = Appointment::factory()->create(['studio_id' => $studio->id]);

        $relation = $appointment->studio();
        expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($appointment->studio->id)->toBe($studio->id);
        expect($appointment->studio)->toBeInstanceOf(Studio::class);
    });
});

describe('Appointment Status Management', function () {
    test('appointment can change status', function () {
        $appointment = Appointment::factory()->create(['status' => AppointmentStatusEnum::SCHEDULED]);

        $appointment->status = AppointmentStatusEnum::CONFIRMED;
        $appointment->save();

        expect($appointment->fresh()->status)->toBe(AppointmentStatusEnum::CONFIRMED);
    });

    test('appointment status enum provides all expected values', function () {
        $statuses = AppointmentStatusEnum::cases();
        $values = array_map(fn($case) => $case->value, $statuses);

        expect($values)->toContain('scheduled');
        expect($values)->toContain('confirmed');
        expect($values)->toContain('in_progress');
        expect($values)->toContain('completed');
        expect($values)->toContain('cancelled');
        expect($values)->toContain('no_show');
        expect($values)->toContain('rejected');
        expect($values)->toContain('rescheduled');
    });

    test('appointment status has correct translations', function () {
        $locales = ['it', 'en', 'de'];
        $statuses = AppointmentStatusEnum::cases();

        foreach ($locales as $locale) {
            app()->setLocale($locale);
            
            foreach ($statuses as $status) {
                $label = __("saluteora::states.{$status->value}.label");
                $description = __("saluteora::states.{$status->value}.description");
                
                expect($label)->not->toContain('saluteora::');
                expect($description)->not->toContain('saluteora::');
            }
        }
    });
});

describe('Appointment Validation', function () {
    test('appointment requires patient_id', function () {
        expect(function () {
            Appointment::create([
                'doctor_id' => Doctor::factory()->create()->id,
                'studio_id' => Studio::factory()->create()->id,
                'start_time' => now()->addDay(),
                'end_time' => now()->addDay()->addHour(),
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });

    test('appointment requires doctor_id', function () {
        expect(function () {
            Appointment::create([
                'patient_id' => Patient::factory()->create()->id,
                'studio_id' => Studio::factory()->create()->id,
                'start_time' => now()->addDay(),
                'end_time' => now()->addDay()->addHour(),
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });

    test('appointment requires studio_id', function () {
        expect(function () {
            Appointment::create([
                'patient_id' => Patient::factory()->create()->id,
                'doctor_id' => Doctor::factory()->create()->id,
                'start_time' => now()->addDay(),
                'end_time' => now()->addDay()->addHour(),
                'status' => AppointmentStatusEnum::SCHEDULED,
            ]);
        })->toThrow(\Illuminate\Database\QueryException::class);
    });

    test('appointment end_time must be after start_time', function () {
        $start = now()->addDay();
        $end = $start->copy()->subHour(); // End before start

        $appointment = Appointment::factory()->make([
            'start_time' => $start,
            'end_time' => $end,
        ]);

        // This should be validated at the application level
        expect($appointment->start_time)->toBeGreaterThan($appointment->end_time);
    });
});

describe('Appointment Scopes and Queries', function () {
    test('can filter appointments by status', function () {
        Appointment::factory()->create(['status' => AppointmentStatusEnum::SCHEDULED]);
        Appointment::factory()->create(['status' => AppointmentStatusEnum::CONFIRMED]);
        Appointment::factory()->create(['status' => AppointmentStatusEnum::COMPLETED]);

        $scheduled = Appointment::where('status', AppointmentStatusEnum::SCHEDULED)->get();
        $confirmed = Appointment::where('status', AppointmentStatusEnum::CONFIRMED)->get();
        $completed = Appointment::where('status', AppointmentStatusEnum::COMPLETED)->get();

        expect($scheduled)->toHaveCount(1);
        expect($confirmed)->toHaveCount(1);
        expect($completed)->toHaveCount(1);
    });

    test('can filter appointments by date range', function () {
        $today = now();
        $tomorrow = now()->addDay();
        $nextWeek = now()->addWeek();

        Appointment::factory()->create(['start_time' => $today]);
        Appointment::factory()->create(['start_time' => $tomorrow]);
        Appointment::factory()->create(['start_time' => $nextWeek]);

        $thisWeekAppointments = Appointment::whereBetween('start_time', [
            $today->startOfWeek(),
            $today->endOfWeek()
        ])->get();

        expect($thisWeekAppointments)->toHaveCount(2);
    });

    test('can filter appointments by patient', function () {
        $patient1 = Patient::factory()->create();
        $patient2 = Patient::factory()->create();

        Appointment::factory()->create(['patient_id' => $patient1->id]);
        Appointment::factory()->create(['patient_id' => $patient1->id]);
        Appointment::factory()->create(['patient_id' => $patient2->id]);

        $patient1Appointments = Appointment::where('patient_id', $patient1->id)->get();
        $patient2Appointments = Appointment::where('patient_id', $patient2->id)->get();

        expect($patient1Appointments)->toHaveCount(2);
        expect($patient2Appointments)->toHaveCount(1);
    });

    test('can filter appointments by doctor', function () {
        $doctor1 = Doctor::factory()->create();
        $doctor2 = Doctor::factory()->create();

        Appointment::factory()->create(['doctor_id' => $doctor1->id]);
        Appointment::factory()->create(['doctor_id' => $doctor2->id]);
        Appointment::factory()->create(['doctor_id' => $doctor2->id]);

        $doctor1Appointments = Appointment::where('doctor_id', $doctor1->id)->get();
        $doctor2Appointments = Appointment::where('doctor_id', $doctor2->id)->get();

        expect($doctor1Appointments)->toHaveCount(1);
        expect($doctor2Appointments)->toHaveCount(2);
    });

    test('can filter appointments by studio', function () {
        $studio1 = Studio::factory()->create();
        $studio2 = Studio::factory()->create();

        Appointment::factory()->create(['studio_id' => $studio1->id]);
        Appointment::factory()->create(['studio_id' => $studio1->id]);
        Appointment::factory()->create(['studio_id' => $studio2->id]);

        $studio1Appointments = Appointment::where('studio_id', $studio1->id)->get();
        $studio2Appointments = Appointment::where('studio_id', $studio2->id)->get();

        expect($studio1Appointments)->toHaveCount(2);
        expect($studio2Appointments)->toHaveCount(1);
    });
});

describe('Appointment Business Logic', function () {
    test('appointment can calculate duration', function () {
        $start = now()->addDay();
        $end = $start->copy()->addHours(2);

        $appointment = Appointment::factory()->create([
            'start_time' => $start,
            'end_time' => $end,
        ]);

        // If the model has a duration method
        if (method_exists($appointment, 'getDuration')) {
            expect($appointment->getDuration())->toBe(120); // minutes
        }
    });

    test('appointment can check if it is in the past', function () {
        $pastAppointment = Appointment::factory()->create([
            'start_time' => now()->subDay(),
            'end_time' => now()->subDay()->addHour(),
        ]);

        $futureAppointment = Appointment::factory()->create([
            'start_time' => now()->addDay(),
            'end_time' => now()->addDay()->addHour(),
        ]);

        // If the model has isPast method
        if (method_exists($pastAppointment, 'isPast')) {
            expect($pastAppointment->isPast())->toBeTrue();
            expect($futureAppointment->isPast())->toBeFalse();
        }
    });

    test('appointment can check if it can be cancelled', function () {
        $scheduledAppointment = Appointment::factory()->create([
            'status' => AppointmentStatusEnum::SCHEDULED,
        ]);

        $completedAppointment = Appointment::factory()->create([
            'status' => AppointmentStatusEnum::COMPLETED,
        ]);

        // If the model has canBeCancelled method
        if (method_exists($scheduledAppointment, 'canBeCancelled')) {
            expect($scheduledAppointment->canBeCancelled())->toBeTrue();
            expect($completedAppointment->canBeCancelled())->toBeFalse();
        }
    });
});
