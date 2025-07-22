<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Authorization policy for Doctor model operations.
 * 
 * This policy determines what actions a user can perform on Doctor models.
 * It follows the principle of least privilege and implements role-based access control.
 *
 * @property Doctor $model
 */
class DoctorPolicy extends XotBasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @return bool
     */
    public function viewAny(UserContract $user): bool
    {
        return true;
        
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor  $doctor
     * @return bool
     */
    public function view(UserContract $user, Doctor $doctor): bool
    {
        /*
        // Utenti possono vedere il proprio profilo
        if ($user->id === $doctor->id) {
            return true;
        }

        // Admin può vedere qualsiasi dottore
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }
        
        // Dottori possono vedere altri dottori dello stesso studio
        if ($user->type === UserTypeEnum::DOCTOR) {
            // Controllo se appartengono allo stesso studio
            if ($user->studio && $doctor->studio && $user->studio->id === $doctor->studio->id) {
                return true;
            }
        }
        
        // Pazienti possono vedere i dottori con cui hanno appuntamenti
        if ($user->type === UserTypeEnum::PATIENT) {
            return Appointment::where('patient_id', $user->id)
                ->where('doctor_id', $doctor->id)
                ->exists();
        }

        return false;
        */
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @return bool
     */
    public function create(UserContract $user): bool
    {
        // Solo admin può creare nuovi account dottore
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor  $doctor
     * @return bool
     */
    public function update(UserContract $user, Doctor $doctor): bool
    {
        // Utenti possono aggiornare il proprio profilo
        if ($user->id === $doctor->id) {
            return true;
        }

        // Admin può aggiornare qualsiasi dottore
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor  $doctor
     * @return bool
     */
    public function delete(UserContract $user, Doctor $doctor): bool
    {
        // Gli utenti non possono eliminare il proprio account
        if ($user->id === $doctor->id) {
            return false;
        }

        // Solo admin può eliminare i dottori
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor  $doctor
     * @return bool
     */
    public function restore(UserContract $user, Doctor $doctor): bool
    {
        // Solo admin può ripristinare dottori eliminati
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor  $doctor
     * @return bool
     */
    public function forceDelete(UserContract $user, Doctor $doctor): bool
    {
        // Solo super-admin può eliminare definitivamente i dottori
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can view the doctor's appointments.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor  $doctor
     * @return bool
     */
    public function viewAppointments(UserContract $user, Doctor $doctor): bool
    {
        // Dottori possono vedere i propri appuntamenti
        if ($user->id === $doctor->id) {
            return true;
        }

        // Admin può vedere tutti gli appuntamenti
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the doctor's availability.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor  $doctor
     * @return bool
     */
    public function updateAvailability(UserContract $user, Doctor $doctor): bool
    {
        // Dottori possono aggiornare la propria disponibilità
        if ($user->id === $doctor->id) {
            return true;
        }

        // Admin può aggiornare qualsiasi disponibilità
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the doctor's profile.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor  $doctor
     * @return bool
     */
    public function viewProfile(UserContract $user, Doctor $doctor): bool
    {
        // Utenti possono sempre vedere il proprio profilo
        if ($user->id === $doctor->id) {
            return true;
        }

        // Pazienti possono vedere i profili dei dottori
        if ($user->type === UserTypeEnum::PATIENT) {
            return true;
        }

        // Admin può vedere qualsiasi profilo
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        return false;
    }

    /**
     * Determina se l'utente può gestire gli appuntamenti.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor|null  $doctor
     * @return bool
     */
    public function appointments(UserContract $user, ?Doctor $doctor = null): bool
    {
        // Admin può gestire tutti gli appuntamenti
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }
        
        // Se è un dottore, può gestire solo i suoi appuntamenti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $doctor === null || $user->id === $doctor->id;
        }
        
        return false;
    }
    
    /**
     * Determina se l'utente può gestire gli studi del dottore.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Doctor|null  $doctor
     * @return bool
     */
    public function studios(UserContract $user, ?Doctor $doctor = null): bool
    {
        // Admin può gestire tutti gli studi
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }
        
        // Se è un dottore, può vedere solo i suoi studi
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $doctor === null || $user->id === $doctor->id;
        }
        
        return false;
    }
}
