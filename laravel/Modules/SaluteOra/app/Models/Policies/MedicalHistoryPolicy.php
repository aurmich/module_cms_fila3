<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\MedicalHistory;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Authorization policy for MedicalHistory model operations.
 * 
 * This policy determines what actions a user can perform on MedicalHistory models.
 * It follows the principle of least privilege and implements role-based access control.
 *
 * @property MedicalHistory $model
 */
class MedicalHistoryPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @return bool
     */
    public function viewAny(UserContract $user): bool
    {
        // Solo admin, staff e dottori possono vedere la lista delle storie mediche
        return $user->hasRole(['super-admin', 'admin', 'staff']) || 
               $user->type === UserTypeEnum::DOCTOR;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\MedicalHistory  $medicalHistory
     * @return bool
     */
    public function view(UserContract $user, MedicalHistory $medicalHistory): bool
    {
        // Admin può vedere tutte le storie mediche
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere solo le storie mediche dei propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $medicalHistory->patient && $medicalHistory->patient->doctors()->where('doctor_id', $user->id)->exists();
        }

        // Pazienti possono vedere solo la propria storia medica
        if ($user->type === UserTypeEnum::PATIENT) {
            return $medicalHistory->patient_id === $user->id;
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
        // Solo admin, staff e dottori possono creare storie mediche
        return $user->hasRole(['super-admin', 'admin', 'staff']) || 
               $user->type === UserTypeEnum::DOCTOR;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\MedicalHistory  $medicalHistory
     * @return bool
     */
    public function update(UserContract $user, MedicalHistory $medicalHistory): bool
    {
        // Admin può modificare qualsiasi storia medica
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono modificare solo le storie mediche dei propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $medicalHistory->patient && $medicalHistory->patient->doctors()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\MedicalHistory  $medicalHistory
     * @return bool
     */
    public function delete(UserContract $user, MedicalHistory $medicalHistory): bool
    {
        // Solo admin può eliminare le storie mediche
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\MedicalHistory  $medicalHistory
     * @return bool
     */
    public function restore(UserContract $user, MedicalHistory $medicalHistory): bool
    {
        // Solo admin può ripristinare storie mediche eliminate
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\MedicalHistory  $medicalHistory
     * @return bool
     */
    public function forceDelete(UserContract $user, MedicalHistory $medicalHistory): bool
    {
        // Solo super-admin può eliminare definitivamente le storie mediche
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can add medical notes.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\MedicalHistory  $medicalHistory
     * @return bool
     */
    public function addNotes(UserContract $user, MedicalHistory $medicalHistory): bool
    {
        // Admin può aggiungere note a qualsiasi storia medica
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono aggiungere note solo alle storie mediche dei propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $medicalHistory->patient && $medicalHistory->patient->doctors()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can view sensitive medical information.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\MedicalHistory  $medicalHistory
     * @return bool
     */
    public function viewSensitive(UserContract $user, MedicalHistory $medicalHistory): bool
    {
        // Solo admin e dottori possono vedere informazioni sensibili
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere informazioni sensibili solo dei propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $medicalHistory->patient && $medicalHistory->patient->doctors()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }
} 