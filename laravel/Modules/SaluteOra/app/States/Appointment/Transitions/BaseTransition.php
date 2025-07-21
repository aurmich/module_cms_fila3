<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Illuminate\Support\Str;
use Spatie\ModelStates\Transition;
use Modules\Xot\Contracts\UserContract;
use Modules\SaluteOra\Models\Appointment;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;

abstract class BaseTransition extends Transition
{
    
    public function __construct(public Appointment $appointment, public ?string $message='') {}
     
    public function handle(): Appointment
    {
        $this->sendNotifications();
        $class = static::class;
        $newStateClass = Str::of($class)->afterLast('To')->prepend('Modules\SaluteOra\States\Appointment\\')->toString();
        /** @phpstan-ignore assign.propertyType */
        $this->appointment->state = new $newStateClass($this->appointment);
        $this->appointment->save();
        return $this->appointment;
    }


    public function sendNotifications(): void
    {   

        $recipients=$this->getNotificationRecipients();
        foreach($recipients as $recipient){
            $this->sendRecipientNotification($recipient);
        }
    }


    public function getNotificationRecipients(): array
    {
        return [
            'patient' => $this->appointment->patient,
            //'doctor' => $this->appointment->doctor,
        ];
    }


    public function sendRecipientNotification(UserContract $recipient): void
    {
        $type=$recipient->type->value;
        $slug = 'appointment-' .$type.'-'. Str::of(class_basename(static::class))->kebab()->toString();
        $slug = Str::slug($slug);
        
        $notify = new RecordNotification(
            $this->appointment,
            $slug
        );

        $data = $this->getNotificationData();
        $notify = $notify->mergeData($data);
        Notification::route('mail', $recipient->email)
            ->notify($notify);
    }
        
    
    public function getNotificationData(): array
    {
        return [
            'message' => $this->message,
            'appointment_date' => $this->appointment->starts_at?->format('d/m/Y H:i') ?? 'N/A',
            'patient_name' => $this->appointment->patient->name ?? 'N/A',
            'doctor_name' => $this->appointment->doctor->name ?? 'N/A',
        ];
    }
} 