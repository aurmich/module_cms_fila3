<?php

declare(strict_types=1);

use Modules\SaluteOra\Models\Appointment;

/**
 * Create an appointment for testing.
 */
function createAppointment(array $attributes = []): Appointment
{
    return Appointment::factory()->create($attributes);
}

/**
 * Make an appointment instance without saving.
 */
function makeAppointment(array $attributes = []): Appointment
{
    return Appointment::factory()->make($attributes);
}
