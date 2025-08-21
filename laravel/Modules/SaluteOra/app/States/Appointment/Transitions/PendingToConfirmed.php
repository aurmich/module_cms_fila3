<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Modules\Notify\Datas\RecordNotificationData;
use Modules\SaluteOra\Models\Appointment;
use Webmozart\Assert\Assert;

/**
 * Transition from Pending to Confirmed state.
 *
 * @property Appointment $record
 */
class PendingToConfirmed extends BaseTransition
{
    // --- (Funziona automaticamente grazie al pattern BaseTransition!)

    public function getNotificationRecipients(): array
    {
        $record = $this->record;
        // Assert::isInstanceOf($record, Appointment::class);

        return [
            'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
            'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
    }
}
