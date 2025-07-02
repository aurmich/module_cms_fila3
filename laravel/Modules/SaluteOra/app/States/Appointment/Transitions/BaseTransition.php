<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Illuminate\Support\Str;
use Spatie\ModelStates\Transition;
use Modules\SaluteOra\Models\Appointment;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;

abstract class BaseTransition extends Transition
{
    
    public function __construct(public Appointment $appointment, public ?string $message='') {}
     
    public function handle(): Appointment
    {
        $this->sendNotification();
        $class = static::class;
        $newStateClass = Str::of($class)->afterLast('To')->prepend('Modules\SaluteOra\States\Appointment\\')->toString();
        /** @phpstan-ignore-next-line */
        $this->appointment->state = new $newStateClass($this->appointment);
        $this->appointment->save();
        return $this->appointment;
    }
        
    public function sendNotification(): void
    {
        $slug = 'appointment-' . Str::of(class_basename(static::class))->kebab()->toString();
        $slug = Str::slug($slug);
        
        $notify = new RecordNotification(
            $this->appointment,
            $slug
        );

        $data = $this->getNotificationData();
        $notify = $notify->mergeData($data);
        
        // Notifica al paziente
        if ($this->appointment->patient && $this->appointment->patient->email) {
            Notification::route('mail', $this->appointment->patient->email)
                ->notify($notify);
        }
        
        // Notifica al dottore
        if ($this->appointment->doctor && $this->appointment->doctor->email) {
            Notification::route('mail', $this->appointment->doctor->email)
                ->notify($notify);
        }
    }

    public function getNotificationData(): array
    {
        return [
            'message' => $this->message,
            'appointment_date' => $this->appointment->start_time->format('d/m/Y H:i'),
            'patient_name' => $this->appointment->patient->name ?? 'N/A',
            'doctor_name' => $this->appointment->doctor->name ?? 'N/A',
        ];
    }
} 