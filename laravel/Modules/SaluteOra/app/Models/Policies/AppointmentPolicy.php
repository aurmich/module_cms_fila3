<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Authorization policy for Appointment model operations.
 * 
 * This policy determines what actions a user can perform on Appointment models.
 * It follows the principle of least privilege and implements role-based access control.
 *
 * @property Appointment $model
 */
class AppointmentPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @return bool
     */
    public function viewAny(UserContract $user): bool
    {
        // Admin e staff possono vedere tutti gli appuntamenti
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere i propri appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return true;
        }

        // Pazienti possono vedere i propri appuntamenti
        if ($user->type === UserTypeEnum::PATIENT) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function view(UserContract $user, Appointment $appointment): bool
    {
        // Admin e staff possono vedere qualsiasi appuntamento
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere i propri appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return true;
        }

        // Pazienti possono vedere i propri appuntamenti
        if ($user->type === UserTypeEnum::PATIENT && $appointment->patient_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @return bool
     */
    public function create(UserContract $user): bool
    {
        // Admin e staff possono creare appuntamenti
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono creare appuntamenti per i propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return true;
        }

        // Pazienti possono prenotare appuntamenti
        if ($user->type === UserTypeEnum::PATIENT) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function update(UserContract $user, Appointment $appointment): bool
    {
        // Admin e staff possono aggiornare qualsiasi appuntamento
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono aggiornare i propri appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return true;
        }

        // Pazienti possono aggiornare i propri appuntamenti (con limitazioni)
        if ($user->type === UserTypeEnum::PATIENT && $appointment->patient_id === $user->id) {
            // I pazienti possono aggiornare solo appuntamenti non confermati
            return in_array($appointment->state->getValue(), ['pending', 'rescheduled']);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function delete(UserContract $user, Appointment $appointment): bool
    {
        // Solo admin può eliminare appuntamenti
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Dottori possono eliminare i propri appuntamenti non confermati
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return in_array($appointment->state->getValue(), ['pending', 'rescheduled']);
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function restore(UserContract $user, Appointment $appointment): bool
    {
        // Solo admin può ripristinare appuntamenti eliminati
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function forceDelete(UserContract $user, Appointment $appointment): bool
    {
        // Solo super-admin può eliminare definitivamente gli appuntamenti
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can confirm the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function confirm(UserContract $user, Appointment $appointment): bool
    {
        // Admin e staff possono confermare qualsiasi appuntamento
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono confermare i propri appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return $appointment->state->getValue() === 'pending';
        }

        return false;
    }

    /**
     * Determine whether the user can reject the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function reject(UserContract $user, Appointment $appointment): bool
    {
        // Admin e staff possono rifiutare qualsiasi appuntamento
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono rifiutare i propri appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return in_array($appointment->state->getValue(), ['pending', 'confirmed']);
        }

        return false;
    }

    /**
     * Determine whether the user can complete the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function complete(UserContract $user, Appointment $appointment): bool
    {
        // Admin e staff possono completare qualsiasi appuntamento
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono completare i propri appuntamenti confermati
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return $appointment->state->value === 'confirmed';
        }

        return false;
    }

    /**
     * Determine whether the user can reschedule the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function reschedule(UserContract $user, Appointment $appointment): bool
    {
        // Admin e staff possono riprogrammare qualsiasi appuntamento
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono riprogrammare i propri appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return in_array($appointment->state->value, ['pending', 'confirmed']);
        }

        // Pazienti possono riprogrammare i propri appuntamenti non confermati
        if ($user->type === UserTypeEnum::PATIENT && $appointment->patient_id === $user->id) {
            return $appointment->state->value === 'pending';
        }

        return false;
    }

    /**
     * Determine whether the user can cancel the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function cancel(UserContract $user, Appointment $appointment): bool
    {
        // Admin e staff possono cancellare qualsiasi appuntamento
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono cancellare i propri appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return in_array($appointment->state->value, ['pending', 'confirmed']);
        }

        // Pazienti possono cancellare i propri appuntamenti
        if ($user->type === UserTypeEnum::PATIENT && $appointment->patient_id === $user->id) {
            return in_array($appointment->state->value, ['pending', 'confirmed']);
        }

        return false;
    }

    /**
     * Determine whether the user can generate a report for the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function generateReport(UserContract $user, Appointment $appointment): bool
    {
        // Admin e staff possono generare report per qualsiasi appuntamento
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono generare report per i propri appuntamenti completati
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return $appointment->state->value === 'completed';
        }

        return false;
    }
} 