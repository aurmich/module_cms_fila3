<?php

declare(strict_types=1);

namespace Modules\SaluteOra\States\Appointment;

use Modules\SaluteOra\Models\Report;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Filament\Resources\ReportResource;
use Modules\SaluteOra\States\Appointment\AppointmentState;

/**
 * Represents a completed appointment.
 *
 * The appointment has been successfully conducted and finished.
 * This is a final state with no further transitions.
 */
class ReportPending extends AppointmentState
{
    /** @var string */
    public static string $name = 'report_pending';

    public function modalFormSchema(): array
    {
        return ReportResource::getFormSchema();
    }

    public function modalFillForm(array $arguments,array $data): array
    {
        $appointmentId = $arguments['appointment'];
        $where=['appointment_id'=>$appointmentId];
        $report=Report::firstOrCreate($where);
        return $report->toArrayForce();
    }

    public function modalAction(array $arguments,array $data): void
    {
        $processData=$data;
        $appointmentId = $arguments['appointment'];
        $appointment = Appointment::firstWhere('id',$appointmentId);
        $processData['appointment_id']=$appointmentId;
        $processData['patient_id']=$appointment?->patient_id;
        $processData['doctor_id']=$appointment?->doctor_id;
        $where=['appointment_id'=>$appointmentId];
        $report=Report::firstOrCreate($where);
        $report->update($processData);

        $this->processStateAction($arguments,$data);
    }
    
}