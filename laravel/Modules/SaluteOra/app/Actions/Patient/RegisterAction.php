<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Patient;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\SaluteOra\Models\Patient;
use Modules\SaluteOra\States\User\Pending;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;


class RegisterAction
{
    /**
     * Esegue l'azione di registrazione del paziente.
     *
     * @param array<string, mixed> $data
     * @return Patient
     */
    public function execute(array $data): Patient
    {
        return DB::transaction(function () use ($data) {

            // Creazione del paziente usando STI
            $patient = Patient::create($data);

            //-------------------------------------------------

            $attachments = Patient::$attachments;
            foreach ($attachments as $attachment) {
                    $patient->addMediaFromDisk($data[$attachment],'local')
                        ->toMediaCollection($attachment);

            }

            //-------------------------------------------------

            // Gestione delle preferenze
            if (isset($data['privacy_acceptance'])) {
                $patient->consents()->create([
                    'type' => 'privacy',
                    'accepted' => true,
                    'accepted_at' => now(),
                ]);
            }

            if (isset($data['newsletter'])) {
                $patient->consents()->create([
                    'type' => 'newsletter',
                    'accepted' => true,
                    'accepted_at' => now(),
                ]);
            }

            Notification::route('mail', $data['email'])
            //->locale('it')
            ->notify(new RecordNotification($patient,'patient_registration_pending'));

            return $patient;
        });
    }
}
