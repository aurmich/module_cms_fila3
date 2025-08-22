<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment\Transitions;

use Webmozart\Assert\Assert;
use Modules\SaluteOra\Models\Appointment;
use Modules\Xot\Actions\Pdf\ContentPdfAction;
use Modules\Notify\Datas\RecordNotificationData;
use Modules\Xot\Actions\Pdf\StreamDownloadPdfAction;

/**
 * Transition from Rejected to Confirmed state.
 *
 * This transition is used when a previously rejected appointment 
 * is reconsidered and confirmed by the medical staff or patient.
 * Common scenarios:
 * - Doctor reconsiders a rejected appointment
 * - Patient provides additional required information
 * - Administrative review reverses the rejection decision
 */
class ReportPendingToReportCompleted extends BaseTransition
{
    //--- (Funziona automaticamente grazie al pattern BaseTransition!)

    public function getNotificationAttachments(): array{
        

        $record=$this->record;
        Assert::isInstanceOf($record, Appointment::class);
        $view='pub_theme::appointment.report_pdf';
        $data=['appointment'=>$record];
        $filename='report-' . $record->id . '.pdf';
        $data=app(ContentPdfAction::class)->execute(view:$view, data:$data, filename:$filename);

        $attachments = [
            [
                
                'data' => $data,
                'as'=>$filename,
                'mime'=>'application/pdf',
            ]
        ];
        return $attachments;
    }


    //---
    public function getNotificationRecipients(): array
    {
        $record = $this->record;
        // Assert::isInstanceOf($record, Appointment::class);

        return [
           'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
           // 'patient_sms' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'sms']),
           'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
    }
}
