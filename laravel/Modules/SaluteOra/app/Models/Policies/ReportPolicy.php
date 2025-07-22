<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Enums\UserTypeEnum;

/**
 * Authorization policy for Report model operations.
 * 
 * This policy determines what actions a user can perform on Report models.
 * It follows the principle of least privilege and implements role-based access control.
 *
 * @property Report $model
 */
class ReportPolicy extends XotBasePolicy
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
     * @param  \Modules\SaluteOra\Models\Report  $report
     * @return bool
     */
    public function view(UserContract $user, Report $report): bool
    {
        // Admin e staff possono vedere qualsiasi report
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono vedere i report che hanno creato
        if ($user->type === UserTypeEnum::DOCTOR && $report->doctor_id === $user->id) {
            return true;
        }

        // Pazienti possono vedere i propri report
        if ($user->type === UserTypeEnum::PATIENT && $report->patient_id === $user->id) {
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
        // Admin e staff possono creare report
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono creare report per i propri pazienti
        if ($user->type === UserTypeEnum::DOCTOR) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Report  $report
     * @return bool
     */
    public function update(UserContract $user, Report $report): bool
    {
        // Admin e staff possono aggiornare qualsiasi report
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono aggiornare i report che hanno creato
        if ($user->type === UserTypeEnum::DOCTOR && $report->doctor_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Report  $report
     * @return bool
     */
    public function delete(UserContract $user, Report $report): bool
    {
        // Solo admin può eliminare report
        if ($user->hasRole(['super-admin', 'admin'])) {
            return true;
        }

        // Dottori possono eliminare i propri report (se non sono ancora finalizzati)
        if ($user->type === UserTypeEnum::DOCTOR && $report->doctor_id === $user->id) {
            return $report->status === 'draft';
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Report  $report
     * @return bool
     */
    public function restore(UserContract $user, Report $report): bool
    {
        // Solo admin può ripristinare report eliminati
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Report  $report
     * @return bool
     */
    public function forceDelete(UserContract $user, Report $report): bool
    {
        // Solo super-admin può eliminare definitivamente i report
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can finalize the report.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Report  $report
     * @return bool
     */
    public function finalize(UserContract $user, Report $report): bool
    {
        // Admin e staff possono finalizzare qualsiasi report
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono finalizzare i propri report
        if ($user->type === UserTypeEnum::DOCTOR && $report->doctor_id === $user->id) {
            return $report->status === 'draft';
        }

        return false;
    }

    /**
     * Determine whether the user can approve the report.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Report  $report
     * @return bool
     */
    public function approve(UserContract $user, Report $report): bool
    {
        // Solo admin e staff possono approvare report
        return $user->hasRole(['super-admin', 'admin', 'staff']);
    }

    /**
     * Determine whether the user can download the report.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Report  $report
     * @return bool
     */
    public function download(UserContract $user, Report $report): bool
    {
        // Admin e staff possono scaricare qualsiasi report
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono scaricare i propri report
        if ($user->type === UserTypeEnum::DOCTOR && $report->doctor_id === $user->id) {
            return true;
        }

        // Pazienti possono scaricare i propri report
        if ($user->type === UserTypeEnum::PATIENT && $report->patient_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can share the report.
     *
     * @param  \Modules\Xot\Contracts\UserContract  $user
     * @param  \Modules\SaluteOra\Models\Report  $report
     * @return bool
     */
    public function share(UserContract $user, Report $report): bool
    {
        // Admin e staff possono condividere qualsiasi report
        if ($user->hasRole(['super-admin', 'admin', 'staff'])) {
            return true;
        }

        // Dottori possono condividere i propri report
        if ($user->type === UserTypeEnum::DOCTOR && $report->doctor_id === $user->id) {
            return true;
        }

        return false;
    }
} 