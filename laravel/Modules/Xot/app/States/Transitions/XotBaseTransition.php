<?php

declare(strict_types=1);

namespace Modules\Xot\States\Transitions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Xot\Contracts\UserContract;
use Spatie\ModelStates\Transition;

abstract class XotBaseTransition extends Transition
{
    public function __construct(public Model $record, public ?string $message = '') {}

    public function handle(): Model
    {
        $this->sendNotifications();
        $class = static::class;

        $stateNamespace = Str::of($class)->beforeLast('\Transitions\\')->toString();
        $stateClassName = Str::of($class)->afterLast('To')->toString();
        $newStateClass = $stateNamespace.'\\'.$stateClassName;

        /** @phpstan-ignore-next-line */
        $this->record->state = new $newStateClass($this->record);
        $this->record->save();

        return $this->record;
    }

    public function sendNotifications(): void
    {

        $recipients = $this->getNotificationRecipients();
        foreach ($recipients as $recipient) {
            if ($recipient instanceof UserContract) {
                $this->sendRecipientNotification($recipient);
            } elseif ($recipient === null) {
                $this->sendRecipientNotification(null);
            }
        }
    }

    /**
     * @return array<string, Model|null>
     */
    public function getNotificationRecipients(): array
    {
        return [
            'me' => $this->record,
            // 'patient' => $this->record->patient,
            // 'doctor' => $this->record->doctor,
        ];
    }

    /**
     * @return array<int, mixed>
     */
    public function getNotificationAttachments(): array
    {
        return [];
    }

    public function getNotificationSlug(UserContract $recipient): string
    {

        $type = $recipient->type->value;
        $slug = class_basename($this->record).'-'.$type.'-'.Str::of(class_basename(static::class))->kebab()->toString();
        $slug = Str::slug($slug);

        return $slug;
    }

    public function sendRecipientNotification(?UserContract $recipient): void
    {
        if ($recipient == null) {
            return;
        }

        $slug = $this->getNotificationSlug($recipient);

        $notify = new RecordNotification(
            $this->record,
            $slug
        );

        $data = $this->getNotificationData();
        $notify = $notify->mergeData($data);
        $notify = $notify->addAttachments($this->getNotificationAttachments());
        // appointment-patient-pending-to-confirmed
        try {
            Notification::route('mail', $recipient->email)
                ->notify($notify);
        } catch (\TypeError $e) {
            dddx($e);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function getNotificationData(): array
    {
        return [
            'message' => $this->message,
            // 'appointment_date' => $this->appointment->starts_at?->format('d/m/Y H:i') ?? 'N/A',
            // 'patient_name' => $this->appointment->patient->name ?? 'N/A',
            // 'doctor_name' => $this->appointment->doctor->name ?? 'N/A',
        ];
    }
}
