<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models\Policies;

use Modules\SaluteOra\States\Appointment\Completed;
use Modules\SaluteOra\States\Appointment\Confirmed;
use Modules\SaluteOra\States\Appointment\Pending;
use Modules\SaluteOra\States\Appointment\Rescheduled;

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
        if ($user->type === UserTypeEnum::PATIENT && $appointment->state->equals(Pending::class) || $appointment->state->equals(Confirmed::class)) {
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
        return true;
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
        return true;
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
        return $user->hasRole('super-admin') && $appointment->state->equals(Pending::class);
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
       return true;
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
        return true;
    }

    /**
     * Determine whether the user can complete the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    /**
     * Determine whether the user can complete the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function complete(UserContract $user, Appointment $appointment): bool
    {
        // Admin and staff can complete any appointment
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Doctors can complete their own confirmed appointments
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return $appointment->state->equals(Confirmed::class);
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
    /**
     * Determine whether the user can reschedule the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function reschedule(UserContract $user, Appointment $appointment): bool
    {
        // Admin and staff can reschedule any appointment
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Doctors can reschedule their own pending or confirmed appointments
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return $appointment->state->equals(Pending::class) || 
                   $appointment->state->equals(Confirmed::class);
        }

        // Patients can reschedule their own pending appointments
        if ($user->type === UserTypeEnum::PATIENT && $appointment->patient_id === $user->id) {
            return $appointment->state->equals(Pending::class);
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
    /**
     * Determine whether the user can cancel the appointment.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Appointment  $appointment
     * @return bool
     */
    public function cancel(UserContract $user, Appointment $appointment): bool
    {
        // Admin and staff can cancel any appointment
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Doctors can cancel their own pending or confirmed appointments
        if ($user->type === UserTypeEnum::DOCTOR && $appointment->doctor_id === $user->id) {
            return $appointment->state->equals(Pending::class) || 
                   $appointment->state->equals(Confirmed::class);
        }

        // Patients can cancel their own pending or confirmed appointments
        if ($user->type === UserTypeEnum::PATIENT && $appointment->patient_id === $user->id) {
            return $appointment->state->equals(Pending::class) || 
                   $appointment->state->equals(Confirmed::class);
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
       return true;
    }

    /**
     * Policy per stato Banned.
     */
    public function banned(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato ProBono.
     */
    public function proBono(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato RefundAccepted.
     */
    public function refundAccepted(UserContract $user, Appointment $appointment): bool
    {
        return $appointment->state->equals(Completed::class) && $user->hasRole(['salutemo::admin']);
    }

    /**
     * Policy per stato RefundCompleted.
     */
    public function refundCompleted(UserContract $user, Appointment $appointment): bool
    {
        return $appointment->state->equals(Completed::class) && $user->hasRole(['salutemo::admin']);
    }

    /**
     * Policy per stato RefundPending.
     */
    public function refundPending(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato RefundToIntegrate.
     */
    public function refundToIntegrate(UserContract $user, Appointment $appointment): bool
    {
        return $appointment->state->equals(Completed::class) && $user->hasRole(['salutemo::admin']);
    }

    /**
     * Policy per stato ReportPending.
     */
    public function reportPending(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato ReportCompleted.
     */
    public function reportCompleted(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato Cancelled.
     */
    public function cancelled(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato Completed.
     */
    public function completed(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato Confirmed.
     */
    public function confirmed(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato InProgress.
     */
    public function inProgress(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato NoShow.
     */
    public function noShow(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato Pending.
     */
    public function pending(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato Rejected.
     */
    public function rejected(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }

    /**
     * Policy per stato Scheduled.
     */
    public function scheduled(UserContract $user, Appointment $appointment): bool
    {
        return $appointment->state->equals(Pending::class) || $appointment->state->equals(Rescheduled::class);
    }

    /**
     * Policy per stato Rescheduled.
     */
    public function rescheduled(UserContract $user, Appointment $appointment): bool
    {
        return true;
    }
} 