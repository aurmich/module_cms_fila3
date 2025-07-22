<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Patient;

use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\SaluteOra\Models\Patient;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\States\User\Pending;
use Illuminate\Support\Facades\Notification;
use Modules\Media\Actions\SaveAttachmentsAction;
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
        
        
        
            // Creazione del paziente usando STI
            if(isset($data['studio'])){
                unset($data['studio']);
            }
            if(!isset($data['name']) && isset($data['email']) && is_string($data['email'])){
                $data['name']=Str::of($data['email'])->before('@')->append('-')->append(Str::random(3))->toString();
            }
            //$patient = Patient::create($data);
            if(isset($data['id'])){
                $patient = $record;
                $patient->update($data);
            }else{
                $patient= new Patient();
                $patient->fill($data);
                $patient->save();
                //$doctor = Doctor::create($data);
            }

            //-------------------------------------------------
             //*
            $attachments = Patient::getAttachments();
            /*
            $data_attachments = [];
            foreach ($attachments as $attachment) {
                    $media=$patient->addMediaFromDisk($data[$attachment],'local')
                        ->toMediaCollection($attachment);
                    $data_attachments[$attachment]=$media->getPathRelativeToRoot();

            }
            $patient->update($data_attachments);
            */
            app(SaveAttachmentsAction::class)->execute($patient,$attachments,$data);
            //*/
            //-------------------------------------------------
            if(!method_exists($patient,'consents')){
                throw new \Exception('Method consents not found');
            }
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
            /** @phpstan-ignore argument.type, argument.type */
            $mail_slug=Str::of($data['type'])->append('-')->append($data['state'])->slug()->toString();
           //$mail_slug=Str::of($patient->type->value)->append('-')->append($patient->state::$name)->slug()->toString();
            //Assert::isInstanceOf($patient,Patient::class);
            
            //** @phpstan-ignore argument.type */
            $notify=new RecordNotification($patient,$mail_slug);
            Notification::route('mail', $data['email'])
            //->locale('it')
            ->notify($notify);
            //** @phpstan-ignore return.type */
            return $patient;
        
    }
}
