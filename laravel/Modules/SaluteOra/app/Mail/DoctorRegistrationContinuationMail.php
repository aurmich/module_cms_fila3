<?php

namespace Modules\SaluteOra\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\SaluteOra\Models\Doctor;

class DoctorRegistrationContinuationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $doctor;
    public $continuationUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Doctor $doctor, string $continuationUrl)
    {
        $this->doctor = $doctor;
        $this->continuationUrl = $continuationUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Continua la tua registrazione su SaluteOra')
                    ->view('saluteora::emails.doctor-registration-continuation')
                    ->with([
                        'doctor' => $this->doctor,
                        'continuationUrl' => $this->continuationUrl,
                    ]);
    }
}
