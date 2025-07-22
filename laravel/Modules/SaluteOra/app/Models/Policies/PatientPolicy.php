<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Authorization policy for Patient model operations.
 * 
 * This policy determines what actions a user can perform on Patient models.
 * It follows the principle of least privilege and implements role-based access control.
 *
 * @property Patient $model
 */
class PatientPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @return bool
     */
    public function viewAny(UserContract $user): bool
    {
        // Admin e staff possono vedere tutti i pazienti
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere i propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return true;
        }

        // Pazienti possono vedere solo se stessi
        if ($user->type === UserTypeEnum::PATIENT) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function view(UserContract $user, Patient $patient): bool
    {
        // Admin e staff possono vedere qualsiasi paziente
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Pazienti possono vedere solo il proprio profilo
        if ($user->type === UserTypeEnum::PATIENT && $user->id === $patient->id) {
            return true;
        }

        // Dottori possono vedere i pazienti con cui hanno appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $patient->appointments()->where('doctor_id', $user->id)->exists();
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
        // Admin e staff possono creare nuovi pazienti
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono creare pazienti per i propri studi
        if ($user->type === UserTypeEnum::DOCTOR) {
            return true;
        }

        // Pazienti possono registrarsi autonomamente
        if ($user->type === UserTypeEnum::PATIENT) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function update(UserContract $user, Patient $patient): bool
    {
        // Admin e staff possono aggiornare qualsiasi paziente
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Pazienti possono aggiornare il proprio profilo
        if ($user->type === UserTypeEnum::PATIENT && $user->id === $patient->id) {
            return true;
        }

        // Dottori possono aggiornare i pazienti con cui hanno appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $patient->appointments()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function delete(UserContract $user, Patient $patient): bool
    {
        // Gli utenti non possono eliminare il proprio account
        if ($user->id === $patient->id) {
            return false;
        }

        // Solo admin può eliminare i pazienti
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function restore(UserContract $user, Patient $patient): bool
    {
        // Solo admin può ripristinare pazienti eliminati
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function forceDelete(UserContract $user, Patient $patient): bool
    {
        // Solo super-admin può eliminare definitivamente i pazienti
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can view patient medical history.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function viewMedicalHistory(UserContract $user, Patient $patient): bool
    {
        // Admin e staff possono vedere la storia medica di qualsiasi paziente
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Pazienti possono vedere la propria storia medica
        if ($user->type === UserTypeEnum::PATIENT && $user->id === $patient->id) {
            return true;
        }

        // Dottori possono vedere la storia medica dei propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $patient->appointments()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can update patient medical history.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function updateMedicalHistory(UserContract $user, Patient $patient): bool
    {
        // Admin e staff possono aggiornare la storia medica di qualsiasi paziente
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono aggiornare la storia medica dei propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $patient->appointments()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can view patient documents.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function viewDocuments(UserContract $user, Patient $patient): bool
    {
        // Admin e staff possono vedere i documenti di qualsiasi paziente
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Pazienti possono vedere i propri documenti
        if ($user->type === UserTypeEnum::PATIENT && $user->id === $patient->id) {
            return true;
        }

        // Dottori possono vedere i documenti dei propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $patient->appointments()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can upload patient documents.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function uploadDocuments(UserContract $user, Patient $patient): bool
    {
        // Admin e staff possono caricare documenti per qualsiasi paziente
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Pazienti possono caricare i propri documenti
        if ($user->type === UserTypeEnum::PATIENT && $user->id === $patient->id) {
            return true;
        }

        // Dottori possono caricare documenti per i propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $patient->appointments()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can view patient appointments.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Patient  $patient
     * @return bool
     */
    public function viewAppointments(UserContract $user, Patient $patient): bool
    {
        // Admin e staff possono vedere gli appuntamenti di qualsiasi paziente
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Pazienti possono vedere i propri appuntamenti
        if ($user->type === UserTypeEnum::PATIENT && $user->id === $patient->id) {
            return true;
        }

        // Dottori possono vedere gli appuntamenti dei propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $patient->appointments()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }
} 