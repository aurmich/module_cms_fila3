<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Actions\Doctor;

use Illuminate\Support\Str;
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
use Webmozart\Assert\Assert;
use Modules\SaluteOra\Enums\UserStateEnum;


class RegisterAction
{
    /**
     * Esegue l'azione di registrazione del dottore.
     *
     * @param array<string, mixed> $data
     * @return \Modules\SaluteOra\Models\Doctor
     */
    public function execute(array $data): Doctor
    {
        // Creazione dello studio con validazione dei dati
        $studioData = $data['studio'] ?? [];
        Assert::isArray($studioData, 'Studio data must be an array');
        
        $studio = Studio::create($studioData);

        // Creazione dell'indirizzo se presente
        if (isset($data['studio']['address']) && is_array($data['studio']['address'])) {
            $addressData = $data['studio']['address'];
            $address = Address::create($addressData);
        }

        // Creazione dell'utente dottore
        $user = app(UserContract::class);
        Assert::isInstanceOf($user, UserContract::class);
        
        // Cast sicuro a Doctor dopo la verifica
        if (!$user instanceof Doctor) {
            throw new \InvalidArgumentException('User must be an instance of Doctor');
        }

        // Associazione con lo studio
        if (method_exists($user, 'studio')) {
            $user->studio()->associate($studio);
        }
        
        if (method_exists($user, 'studios')) {
            $user->studios()->attach($studio->id);
        }

        // Aggiornamento del state
        if (property_exists($user, 'state')) {
            $user->state = UserStateEnum::PENDING;
        }

        $user->save();

        // Gestione sicura della concatenazione per l'email
        $doctorName = $data['first_name'] ?? '';
        $doctorLastName = $data['last_name'] ?? '';
        $fullName = trim($doctorName . ' ' . $doctorLastName);

        // Invio notifica se l'utente è un Model
        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
            $mailSlug = 'doctor-registration';
            $user->notify(new RecordNotification($user, $mailSlug));
        }

        return $user;
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
