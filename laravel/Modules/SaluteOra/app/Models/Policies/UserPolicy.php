<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Authorization policy for User model operations.
 * 
 * This policy determines what actions a user can perform on User models.
 * It follows the principle of least privilege and implements role-based access control.
 *
 * @property User $model
 */
class UserPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @return bool
     */
    public function viewAny(UserContract $user): bool
    {
        // Solo admin e staff possono vedere tutti gli utenti
        return $user->hasRole(['super-admin', 'admin', 'staff']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function view(UserContract $user, User $model): bool
    {
        // Admin e staff possono vedere qualsiasi utente
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Utenti possono vedere il proprio profilo
        if ($user->id === $model->id) {
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
        // Solo admin può creare nuovi utenti
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function update(UserContract $user, User $model): bool
    {
        // Admin può aggiornare qualsiasi utente
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Utenti possono aggiornare il proprio profilo
        if ($user->id === $model->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function delete(UserContract $user, User $model): bool
    {
        // Gli utenti non possono eliminare il proprio account
        if ($user->id === $model->id) {
            return false;
        }

        // Solo admin può eliminare utenti
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function restore(UserContract $user, User $model): bool
    {
        // Solo admin può ripristinare utenti eliminati
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function forceDelete(UserContract $user, User $model): bool
    {
        // Solo super-admin può eliminare definitivamente gli utenti
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can manage user roles.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function manageRoles(UserContract $user, User $model): bool
    {
        // Solo admin può gestire i ruoli
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can change user status.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function changeStatus(UserContract $user, User $model): bool
    {
        // Gli utenti non possono cambiare il proprio stato
        if ($user->id === $model->id) {
            return false;
        }

        // Solo admin può cambiare lo stato degli utenti
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can view user activity.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function viewActivity(UserContract $user, User $model): bool
    {
        // Admin e staff possono vedere l'attività di qualsiasi utente
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Utenti possono vedere la propria attività
        if ($user->id === $model->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can manage user permissions.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function managePermissions(UserContract $user, User $model): bool
    {
        // Solo super-admin può gestire i permessi
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can impersonate another user.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\User  $model
     * @return bool
     */
    public function impersonate(UserContract $user, User $model): bool
    {
        // Non si può impersonare se stessi
        if ($user->id === $model->id) {
            return false;
        }

        // Solo admin può impersonare altri utenti
        return $user->hasRole(['super-admin', 'admin']);
    }
} 