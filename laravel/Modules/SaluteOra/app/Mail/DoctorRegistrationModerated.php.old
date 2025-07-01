<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\SaluteOra\Models\DoctorRegistrationWorkflow;

class DoctorRegistrationModerated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public DoctorRegistrationWorkflow $workflow
    ) {}

    /**
     * Build the message.
     */
    public function build(): self
    {
        $subject = $this->workflow->isModerationApproved()
            ? 'Registrazione approvata - Completa il tuo profilo'
            : 'Registrazione in revisione - Aggiornamento stato';

        return $this->subject($subject)
            ->view('saluteora::emails.doctor-registration-moderated', [
                'workflow' => $this->workflow,
                'continueUrl' => $this->workflow->isModerationApproved()
                    ? route('doctor.registration.continue', [
                        'token' => $this->workflow->moderation_token
                    ])
                    : null,
            ]);
    }
} 