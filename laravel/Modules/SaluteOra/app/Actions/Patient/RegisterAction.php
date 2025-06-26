<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Patient;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\SaluteOra\Models\Patient;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\States\User\Pending;
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
    public function execute(UserContract $record,array $data): Patient
    {
        
        
        return DB::transaction(function () use ($data) {
            // Creazione del paziente usando STI
            if(isset($data['studio'])){
                unset($data['studio']);
            }
            $patient = Patient::create($data);

            //-------------------------------------------------
             //*
            $attachments = Patient::$attachments;
            foreach ($attachments as $attachment) {
                    $patient->addMediaFromDisk($data[$attachment],'local')
                        ->toMediaCollection($attachment);

            }
            //*/
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

            $mail_slug=Str::of($data['type'])->append('-')->append($data['state'])->slug()->toString();
           //$mail_slug=Str::of($patient->type->value)->append('-')->append($patient->state::$name)->slug()->toString();
            
            
            
            $notify=new RecordNotification($patient,$mail_slug);
            Notification::route('mail', $data['email'])
            //->locale('it')
            ->notify($notify);

            return $patient;
        });
    }
}
