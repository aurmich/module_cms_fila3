<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Illuminate\Support\Arr;
use Filament\Forms\Components;
use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Models\Appointment;
use Modules\Media\Actions\SaveAttachmentsAction;
use Modules\Media\Actions\GetAttachmentsSchemaAction;
use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a cancelled appointment.
 *
 * The appointment has been cancelled by either party.
 */
class RefundPending extends AppointmentState
{
    /** @var string */
    public static $name = 'refund_pending';

    
    public function modalFormSchema(): array
    {
        $attachments=['invoice'];
        $disk='attachments';
        $schema=app(GetAttachmentsSchemaAction::class)->execute($attachments,$disk);
        $schema['message']=Components\Textarea::make('message')
        ->required()
        ->maxLength(255);

        return $schema;
    }

    public function modalAction(array $arguments, array $data)
    {
        $attachments=['invoice'];
        $disk='attachments';
        $processData=$data;
        $appointmentId = $arguments['appointment'];
        $appointment = Appointment::firstWhere('id',$appointmentId);
        $processData['appointment_id']=$appointmentId;
        $processData['patient_id']=$appointment?->patient_id;
        $processData['doctor_id']=$appointment?->doctor_id;
        $where=['appointment_id'=>$appointmentId];
        $report=Report::firstOrCreate($where);
        $report->update($processData);
        app(SaveAttachmentsAction::class)->execute($report,$attachments,$data,$disk);
        if(null != $appointment){
            app(SaveAttachmentsAction::class)->execute($appointment,$attachments,$data,$disk);
        }
        
        $this->processStateAction($arguments,$data);
    }

    
}