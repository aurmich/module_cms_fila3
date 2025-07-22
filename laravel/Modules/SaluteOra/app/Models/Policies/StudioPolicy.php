<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Authorization policy for Studio model operations.
 * 
 * This policy determines what actions a user can perform on Studio models.
 * It follows the principle of least privilege and implements role-based access control.
 *
 * @property Studio $model
 */
class StudioPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @return bool
     */
    public function viewAny(UserContract $user): bool
    {
        

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Studio  $studio
     * @return bool
     */
    public function view(UserContract $user, Studio $studio): bool
    {
        // Admin e staff possono vedere qualsiasi studio
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere gli studi a cui sono associati
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $studio->doctors()->where('doctor_id', $user->id)->exists();
        }

        // Pazienti possono vedere tutti gli studi pubblici
        if ($user->type === UserTypeEnum::PATIENT) {
            return $studio->is_active;
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
        // Solo admin può creare nuovi studi
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Studio  $studio
     * @return bool
     */
    public function update(UserContract $user, Studio $studio): bool
    {
        // Admin può aggiornare qualsiasi studio
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Dottori possono aggiornare gli studi di cui sono proprietari
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $studio->owner_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Studio  $studio
     * @return bool
     */
    public function delete(UserContract $user, Studio $studio): bool
    {
        // Solo admin può eliminare studi
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Dottori possono eliminare i propri studi (se non hanno appuntamenti attivi)
        if ($user->type === UserTypeEnum::DOCTOR && $studio->owner_id === $user->id) {
            return !$studio->appointments()->where('starts_at', '>', now())->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Studio  $studio
     * @return bool
     */
    public function restore(UserContract $user, Studio $studio): bool
    {
        // Solo admin può ripristinare studi eliminati
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Studio  $studio
     * @return bool
     */
    public function forceDelete(UserContract $user, Studio $studio): bool
    {
        // Solo super-admin può eliminare definitivamente gli studi
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can manage doctors in the studio.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Studio  $studio
     * @return bool
     */
    public function manageDoctors(UserContract $user, Studio $studio): bool
    {
        // Admin può gestire i dottori in qualsiasi studio
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Dottori possono gestire i dottori nei propri studi
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $studio->owner_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can manage appointments in the studio.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Studio  $studio
     * @return bool
     */
    public function manageAppointments(UserContract $user, Studio $studio): bool
    {
        // Admin e staff possono gestire appuntamenti in qualsiasi studio
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono gestire appuntamenti nei propri studi
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $studio->doctors()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can view studio statistics.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Studio  $studio
     * @return bool
     */
    public function viewStatistics(UserContract $user, Studio $studio): bool
    {
        // Admin e staff possono vedere statistiche di qualsiasi studio
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere statistiche dei propri studi
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $studio->doctors()->where('doctor_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can manage studio settings.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Studio  $studio
     * @return bool
     */
    public function manageSettings(UserContract $user, Studio $studio): bool
    {
        // Admin può gestire impostazioni di qualsiasi studio
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Dottori possono gestire impostazioni dei propri studi
        if ($user->type === UserTypeEnum::DOCTOR) {
            return $studio->owner_id === $user->id;
        }

        return false;
    }
} 