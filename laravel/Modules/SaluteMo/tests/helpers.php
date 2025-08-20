<?php

use Modules\SaluteMo\Models\Appointment;
use Modules\SaluteMo\Enums\AppointmentStatus;
use Modules\SaluteMo\Enums\AppointmentType;

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