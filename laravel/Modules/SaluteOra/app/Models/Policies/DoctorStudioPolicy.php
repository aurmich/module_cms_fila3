<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\DoctorStudio;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Authorization policy for DoctorStudio model operations.
 * 
 * This policy determines what actions a user can perform on DoctorStudio pivot models.
 * It follows the principle of least privilege and implements role-based access control.
 *
 * @property DoctorStudio $model
 */
class DoctorStudioPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @return bool
     */
    public function viewAny(UserContract $user): bool
    {
        // Admin e staff possono vedere tutte le associazioni
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere le proprie associazioni
        if ($user->type === UserTypeEnum::DOCTOR) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\DoctorStudio  $doctorStudio
     * @return bool
     */
    public function view(UserContract $user, DoctorStudio $doctorStudio): bool
    {
        // Admin e staff possono vedere qualsiasi associazione
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere le proprie associazioni
        if ($user->type === UserTypeEnum::DOCTOR && $doctorStudio->doctor_id === $user->id) {
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
        // Admin e staff possono creare associazioni
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono creare associazioni per se stessi
        if ($user->type === UserTypeEnum::DOCTOR) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\DoctorStudio  $doctorStudio
     * @return bool
     */
    public function update(UserContract $user, DoctorStudio $doctorStudio): bool
    {
        // Admin e staff possono aggiornare qualsiasi associazione
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono aggiornare le proprie associazioni
        if ($user->type === UserTypeEnum::DOCTOR && $doctorStudio->doctor_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\DoctorStudio  $doctorStudio
     * @return bool
     */
    public function delete(UserContract $user, DoctorStudio $doctorStudio): bool
    {
        // Admin e staff possono eliminare qualsiasi associazione
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono eliminare le proprie associazioni
        if ($user->type === UserTypeEnum::DOCTOR && $doctorStudio->doctor_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\DoctorStudio  $doctorStudio
     * @return bool
     */
    public function restore(UserContract $user, DoctorStudio $doctorStudio): bool
    {
        // Solo admin può ripristinare associazioni eliminate
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\DoctorStudio  $doctorStudio
     * @return bool
     */
    public function forceDelete(UserContract $user, DoctorStudio $doctorStudio): bool
    {
        // Solo super-admin può eliminare definitivamente le associazioni
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can manage doctor availability in studio.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\DoctorStudio  $doctorStudio
     * @return bool
     */
    public function manageAvailability(UserContract $user, DoctorStudio $doctorStudio): bool
    {
        // Admin e staff possono gestire la disponibilità
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono gestire la propria disponibilità
        if ($user->type === UserTypeEnum::DOCTOR && $doctorStudio->doctor_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view doctor schedule in studio.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\DoctorStudio  $doctorStudio
     * @return bool
     */
    public function viewSchedule(UserContract $user, DoctorStudio $doctorStudio): bool
    {
        // Admin e staff possono vedere qualsiasi agenda
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere la propria agenda
        if ($user->type === UserTypeEnum::DOCTOR && $doctorStudio->doctor_id === $user->id) {
            return true;
        }

        return false;
    }
} 