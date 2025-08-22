<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Tests\Unit\Actions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\SaluteOra\Actions\Calendar\FetchCalendarEventsAction;
use Modules\SaluteOra\Enums\AppointmentStatusEnum;
use Modules\SaluteOra\Enums\AppointmentTypeEnum;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Models\Studio;
use Pest\Expectation;

/**
 * Business-logic-first tests for FetchCalendarEventsAction transformation.
 * No RefreshDatabase. We create only the records we need using factories and the global test SQLite setup.
 */

// Helper subclass to expose behavior via a public method (keeps unit under test focused on observable event payload)
class TestableFetchCalendarEventsAction extends FetchCalendarEventsAction
{
    /**
     * @return array<string, mixed>
     */
    public function toEvent(Appointment $appointment): array
    {
        // call the protected transform through a public proxy
        return \Closure::bind(fn () => $this->transformAppointment($appointment), $this, FetchCalendarEventsAction::class)();
    }
}

it('builds an emergency event with proper title, colors and contrast', function (): void {
    $patient = Patient::factory()->create(['first_name' => 'Anna', 'last_name' => 'Bianchi']);
    $doctor = Doctor::factory()->create();
    $studio = Studio::factory()->create(['name' => 'Studio Centro']);

    $appt = Appointment::factory()->for($patient, 'patient')->for($doctor, 'doctor')->for($studio, 'studio')->create([
        'type' => AppointmentTypeEnum::EMERGENCY,
        'status' => AppointmentStatusEnum::PENDING,
        'emergency' => true,
        'starts_at' => Carbon::now()->addDay(),
        'ends_at' => Carbon::now()->addDay()->addHour(),
        'notes' => 'Note',
    ]);

    $action = new TestableFetchCalendarEventsAction();
    $event = $action->toEvent($appt);

    expect($event)
        ->toHaveKeys(['id','title','start','end','backgroundColor','borderColor','textColor','extendedProps','editable'])
        ->and($event['backgroundColor'])->toBe('#dc3545') // emergency color
        ->and($event['borderColor'])->toBe('#dc3545')
        ->and($event['textColor'])->toBeOneOf(['#ffffff', '#000000']) // contrast resolved
        ->and($event['title'])
            ->toContain('Anna Bianchi')
            ->toContain('🚨')
            ->toContain($appt->status->getLabel());

    // extended props reflect business data
    expect($event['extendedProps'])
        ->type->toBe($appt->type->value)
        ->status->toBe($appt->status->value)
        ->patient_id->toBe($patient->id)
        ->doctor_id->toBe($doctor->id)
        ->studio_name->toBe('Studio Centro');
});

it('marks event editable only for future dates and matching doctor/admin', function (): void {
    $doctor = Doctor::factory()->create();
    $otherDoctor = Doctor::factory()->create();
    $patient = Patient::factory()->create();
    $studio = Studio::factory()->create();

    $futureAppt = Appointment::factory()->for($patient, 'patient')->for($doctor, 'doctor')->for($studio, 'studio')->create([
        'type' => AppointmentTypeEnum::CONSULTATION,
        'status' => AppointmentStatusEnum::CONFIRMED,
        'emergency' => false,
        'starts_at' => Carbon::now()->addHours(2),
        'ends_at' => Carbon::now()->addHours(3),
    ]);

    $pastAppt = Appointment::factory()->for($patient, 'patient')->for($doctor, 'doctor')->for($studio, 'studio')->create([
        'type' => AppointmentTypeEnum::CONSULTATION,
        'status' => AppointmentStatusEnum::CONFIRMED,
        'emergency' => false,
        'starts_at' => Carbon::now()->subHours(2),
        'ends_at' => Carbon::now()->subHour(),
    ]);

    $action = new TestableFetchCalendarEventsAction();

    // as the assigned doctor -> future editable, past not editable
    Auth::login($doctor);
    expect($action->toEvent($futureAppt)['editable'])->toBeTrue();
    expect($action->toEvent($pastAppt)['editable'])->toBeFalse();

    // as a different doctor -> not editable
    Auth::login($otherDoctor);
    expect($action->toEvent($futureAppt)['editable'])->toBeFalse();
});
