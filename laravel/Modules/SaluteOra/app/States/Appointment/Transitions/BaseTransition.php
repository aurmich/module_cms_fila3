<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Modules\Notify\Datas\RecordNotificationData;
use Modules\SaluteOra\Models\Appointment;
use Modules\Xot\States\Transitions\XotBaseTransition;
use Webmozart\Assert\Assert;

/**
 * @property Appointment $record
 */
abstract class BaseTransition extends XotBaseTransition
{
    public function getNotificationRecipients(): array
    {
        $record = $this->record;

        // Assert::isInstanceOf($record, Appointment::class);
        return [
            'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
            // 'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
    }

    public function getNotificationData(): array
    {
        $record = $this->record;

        // Assert::isInstanceOf($record, Appointment::class);
        return [
            'message' => $this->message,
            'appointment_date' => $record->starts_at?->format('d/m/Y H:i') ?? 'N/A',
            'patient_name' => $record->patient->name ?? 'N/A',
            'doctor_name' => $record->doctor->name ?? 'N/A',
        ];
    }
}
