<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Doctor;

use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Modules\Geo\Models\Address;
use Illuminate\Support\Facades\DB;
use Modules\SaluteOra\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\SaluteOra\Models\Doctor;
use Modules\SaluteOra\Models\Studio;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Models\MailTemplate;
use Modules\SaluteOra\Datas\DoctorData;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Enums\DoctorStatus;
use Modules\SaluteOra\Enums\UserTypeEnum;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Modules\Notify\Notifications\RecordNotification;
use Modules\SaluteOra\States\User\IntegrationCompleted;
use Modules\SaluteOra\Models\DoctorRegistrationWorkflow;
use Modules\SaluteOra\Enums\DoctorRegistrationStatusEnum;


class RegisterAction
{
    /**
     * Esegue l'azione di registrazione del dottore.
     *
     * @param array<string, mixed> $data
     * @return Doctor
     */
    public function execute(UserContract $record,array $data): Doctor
    {
        if(!isset($data['name']) && isset($data['email']) && is_string($data['email'])){
            $data['name']=Str::of($data['email'])->before('@')->append('-')->append(Str::random(3))->toString();
        }
        if(isset($data['id'])){
            $doctor = $record;
            $doctor->update($data);
        }else{
            $doctor= new Doctor();
            $doctor->fill($data);
            $doctor->save();
            //$doctor = Doctor::create($data);
        }
        if(isset($data['schedule'])){
            if(!is_array($data['studio'])){
                $data['studio']=[];
            }
            if(!is_array($data['studio']['address'])){
                $data['studio']['address']=[];
            }
            $studio = Studio::create($data['studio']);
            $address = Address::create($data['studio']['address']);
            $studio->address()->save($address);
            /** @phpstan-ignore-next-line */
            $doctor->studio()->save($studio);
            /** @phpstan-ignore-next-line */
            $doctor->studios()->attach($studio,['schedule'=>$data['schedule']]);
        }

         //-------------------------------------------------
             //*
            $attachments = Doctor::getAttachments();
            $data_attachments = [];
            foreach ($attachments as $attachment) {
                    /** @phpstan-ignore-next-line */
                    $media=$doctor->addMediaFromDisk($data[$attachment],'local')
                        ->toMediaCollection($attachment);
                    $data_attachments[$attachment]=$media->getPathRelativeToRoot();

            }
            $doctor->update($data_attachments);
             //*/
             //-------------------------------------------------

        //$record->save();
        //$record->update($data);
        /*
        $attachments = Doctor::getAttachments();
        foreach ($attachments as $attachment) {
                $doctor->addMediaFromDisk($data[$attachment],'local')
                    ->toMediaCollection($attachment);

        }
        */
        Assert::isInstanceOf($doctor, Doctor::class);
        
        if($data['state']=='integration_requested'){
            $doctor->state->transitionTo(IntegrationCompleted::class);
            return $doctor;
        }

        /** @phpstan-ignore-next-line */
        $mail_slug=Str::slug($data['type'].'-'.$data['state']);
        

        Notification::route('mail', $data['email'])
        //->locale('it')
        ->notify(new RecordNotification($doctor,$mail_slug));

        return $doctor;
    }



    /**
     * Ottiene lo stato di registrazione del dottore.
     *
     * @return string
     */
    private function getDoctorRegistrationStatus(): string
    {
        if (!class_exists(DoctorRegistrationStatusEnum::class)) {
            return 'pending';
        }

        try {
            $cases = DoctorRegistrationStatusEnum::cases();
            foreach ($cases as $case) {
                if (strtolower($case->name) === 'pending') {
                    return $case->value;
                }
            }
            return 'pending';
        } catch (\Exception $e) {
            return 'pending';
        }
    }

    /**
     * Invia l'email di conferma della registrazione.
     *
     * @param Doctor $doctor
     * @return void
     */
    protected function sendConfirmationEmail(Doctor $doctor): void
    {
        // Verifica se esiste già il template, altrimenti crealo
        if (!MailTemplate::where('slug', 'doctor_registration_pending')->exists()) {
            MailTemplate::create([
                'mailable' => SpatieEmail::class,
                'slug' => 'doctor_registration_pending',
                'subject' => 'Benvenuto, {{ first_name }}',
                'html_template' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>La tua registrazione come dottore è in attesa di approvazione. Ti contatteremo presto.</p>',
                'text_template' => 'Gentile {{ first_name }} {{ last_name }}, la tua registrazione come dottore è in attesa di approvazione. Ti contatteremo presto.'
            ]);
        }

        // Debug sicuro del tipo
        dddx([
            'type_value' => $doctor->type->value ?? 'null',
            'type_class' => get_class($doctor->type ?? new \stdClass()),
            'is_doctor' => $doctor->isDoctor(),
        ]);

        $email = new SpatieEmail($doctor, 'doctor_registration_pending');
        Mail::to($doctor->email)
            ->locale(app()->getLocale())
            ->send($email);
    }
}
