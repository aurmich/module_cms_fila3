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
            $patient = Patient::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                //'password' => Hash::make($data['password']),
                'address' => $data['address'] ?? null,
                'phone' => $data['phone'] ?? null,
                'last_dental_visit' => $data['last_dental_visit'] ?? null,
                'dental_problems' => $data['dental_problems'] ?? null,
            ]);

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
