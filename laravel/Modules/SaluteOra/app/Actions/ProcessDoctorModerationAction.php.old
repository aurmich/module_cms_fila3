<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions;

use Illuminate\Support\Facades\Mail;
use Modules\SaluteOra\Models\DoctorRegistrationWorkflow;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Mail\DoctorRegistrationModerated;
use Spatie\QueueableAction\QueueableAction;
use Modules\SaluteOra\Enums\DoctorRegistrationStatusEnum;

class ProcessDoctorModerationAction
{
    use QueueableAction;

    /**
     * Elabora la moderazione di un dottore.
     *
     * @param DoctorRegistrationWorkflow $workflow
     * @param bool $approved Se la moderazione è stata approvata
     * @param int $moderatorId ID dell'utente moderatore
     * @param string|null $notes Note di moderazione (opzionali)
     * 
     * @return bool
     */
    public function execute(
        DoctorRegistrationWorkflow $workflow,
        bool $approved,
        int $moderatorId,
        ?string $notes = null
    ): bool {
        try {
            // Aggiorna lo stato del workflow
            $workflow->status = $approved ? DoctorRegistrationStatusEnum::MODERATION_APPROVED : DoctorRegistrationStatusEnum::MODERATION_REJECTED;
            
            $workflow->moderation_notes = $notes;
            $workflow->moderated_at = now();
            $workflow->moderated_by = $moderatorId;
            
            // Se approvato, genera token per proseguire e aggiorna lo step
            if ($approved) {
                $workflow->generateModerationToken();
                $workflow->current_step = 'contacts_step';
            }
            
            $workflow->save();

            // Invia email al medico
            $doctor = Doctor::find($workflow->doctor_id);
            if ($doctor && $doctor->email) {
                Mail::to($doctor->email)
                    ->queue(new DoctorRegistrationModerated($workflow));
            }

            // Logga l'azione
            activity()
                ->performedOn($workflow)
                ->causedBy($moderatorId)
                ->withProperties([
                    'status' => $approved ? DoctorRegistrationStatusEnum::MODERATION_APPROVED : DoctorRegistrationStatusEnum::MODERATION_REJECTED,
                    'notes' => $notes,
                ])
                ->log('Doctor registration moderated');

            return true;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }
} 